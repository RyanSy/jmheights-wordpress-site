<?php
/**
 * JM Heights — Import Content from Google Docs
 *
 * This script reads site-structure.md, fetches content from linked Google Docs,
 * cleans the HTML, and updates the corresponding WordPress pages.
 *
 * Usage (via WP-CLI):
 *   wp eval-file wp-content/plugins/jmheights-setup/import-google-docs.php
 *
 * Usage (via browser — WordPress admin):
 *   Navigate to Tools → Import Google Docs Content
 *
 * Requirements:
 *   - Google Docs must be publicly accessible (shared with "Anyone with the link")
 *   - WordPress pages must already exist (created by the JM Heights Setup plugin)
 */

// If running via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    jmheights_run_import();
    return;
}

// If loaded as part of WordPress admin
if (defined('ABSPATH')) {
    add_action('admin_menu', 'jmheights_import_menu');
    add_action('admin_init', 'jmheights_handle_import');
}

/**
 * Add admin menu item under Tools
 */
function jmheights_import_menu() {
    add_management_page(
        'Import Google Docs Content',
        'Import Google Docs',
        'manage_options',
        'jmheights-import',
        'jmheights_import_page'
    );
}

/**
 * Admin page UI
 */
function jmheights_import_page() {
    $results = get_transient('jmheights_import_results');
    delete_transient('jmheights_import_results');
    ?>
    <div class="wrap">
        <h1>Import Google Docs Content</h1>
        <p>This will fetch content from the Google Docs linked in <code>site-structure.md</code> and update the corresponding WordPress pages.</p>
        <p><strong>Requirements:</strong></p>
        <ul style="list-style: disc; margin-left: 20px;">
            <li>Google Docs must be publicly accessible ("Anyone with the link" sharing)</li>
            <li>Pages must already exist (activate the JM Heights Setup plugin first)</li>
            <li><code>site-structure.md</code> must be in the WordPress root directory</li>
        </ul>

        <form method="post" action="">
            <?php wp_nonce_field('jmheights_import_action', 'jmheights_import_nonce'); ?>
            <p>
                <label for="structure_file"><strong>Path to site-structure.md:</strong></label><br>
                <input type="text" id="structure_file" name="structure_file"
                       value="<?php echo esc_attr(ABSPATH . 'site-structure.md'); ?>"
                       style="width: 600px;" />
            </p>
            <p>
                <label>
                    <input type="checkbox" name="dry_run" value="1" checked />
                    Dry run (preview changes without updating pages)
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="import_towns" value="1" checked />
                    Import town pages from combined Google Doc
                </label>
            </p>
            <?php submit_button('Import Content', 'primary', 'jmheights_import_submit'); ?>
        </form>

        <?php if ($results): ?>
            <h2>Import Results</h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Page</th>
                        <th>Slug</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $r): ?>
                        <tr>
                            <td><?php echo $r['status'] === 'success' ? '&#9989;' : ($r['status'] === 'skipped' ? '&#9898;' : '&#10060;'); ?></td>
                            <td><?php echo esc_html($r['title']); ?></td>
                            <td><code><?php echo esc_html($r['slug']); ?></code></td>
                            <td><?php echo esc_html($r['message']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Handle form submission
 */
function jmheights_handle_import() {
    if (!isset($_POST['jmheights_import_submit'])) return;
    if (!wp_verify_nonce($_POST['jmheights_import_nonce'], 'jmheights_import_action')) return;
    if (!current_user_can('manage_options')) return;

    $structure_file = sanitize_text_field($_POST['structure_file']);
    $dry_run = isset($_POST['dry_run']);
    $import_towns = isset($_POST['import_towns']);

    $results = jmheights_run_import($structure_file, $dry_run, $import_towns, false);
    set_transient('jmheights_import_results', $results, 300);

    wp_redirect(admin_url('tools.php?page=jmheights-import'));
    exit;
}

/**
 * Main import function
 */
function jmheights_run_import($structure_file = null, $dry_run = false, $import_towns = true, $is_cli = true) {
    if ($structure_file === null) {
        $structure_file = ABSPATH . 'site-structure.md';
    }

    if (!file_exists($structure_file)) {
        $msg = "Error: site-structure.md not found at: $structure_file";
        if ($is_cli) { WP_CLI::error($msg); return; }
        return [['status' => 'error', 'title' => 'File', 'slug' => '', 'message' => $msg]];
    }

    $content = file_get_contents($structure_file);
    $mappings = jmheights_parse_structure($content);
    $results = [];

    if ($is_cli) {
        WP_CLI::log("Found " . count($mappings) . " pages with Google Doc links.");
        if ($dry_run) WP_CLI::log("DRY RUN — no pages will be updated.");
        WP_CLI::log("");
    }

    foreach ($mappings as $map) {
        $result = jmheights_import_single_page($map, $dry_run, $is_cli);
        $results[] = $result;

        // Rate limit to avoid being blocked by Google
        if ($result['status'] === 'success') {
            usleep(500000); // 0.5 second delay
        }
    }

    // Import town pages from combined doc
    if ($import_towns) {
        $town_doc_id = jmheights_get_town_doc_id($content);
        if ($town_doc_id) {
            $town_results = jmheights_import_town_pages($town_doc_id, $dry_run, $is_cli);
            $results = array_merge($results, $town_results);
        }
    }

    if ($is_cli) {
        $success = count(array_filter($results, fn($r) => $r['status'] === 'success'));
        $skipped = count(array_filter($results, fn($r) => $r['status'] === 'skipped'));
        $errors = count(array_filter($results, fn($r) => $r['status'] === 'error'));
        WP_CLI::log("");
        WP_CLI::success("Import complete: $success updated, $skipped skipped, $errors errors.");
    }

    return $results;
}

/**
 * Parse site-structure.md to extract title, Google Doc URL, and slug mappings
 */
function jmheights_parse_structure($content) {
    $mappings = [];

    // Match: [Title](google-doc-url) (/slug/)
    // Also match: [Home](google-doc-url) (/)
    preg_match_all(
        '/\[([^\]]+)\]\((https:\/\/docs\.google\.com\/document\/d\/[^)]+)\)\s*\((\/?[^)]*\/)\)/',
        $content,
        $matches,
        PREG_SET_ORDER
    );

    foreach ($matches as $match) {
        $title = trim($match[1]);
        $doc_url = $match[2];
        $slug = trim($match[3], '/');

        // Extract Google Doc ID
        preg_match('/\/document\/d\/([a-zA-Z0-9_-]+)/', $doc_url, $id_match);
        if (empty($id_match[1])) continue;

        $mappings[] = [
            'title' => $title,
            'doc_id' => $id_match[1],
            'slug' => $slug ?: 'home',
            'doc_url' => $doc_url,
        ];
    }

    return $mappings;
}

/**
 * Get the combined town pages doc ID
 */
function jmheights_get_town_doc_id($content) {
    if (preg_match('/\[jmheights[^\]]*town[^\]]*\]\((https:\/\/docs\.google\.com\/document\/d\/([a-zA-Z0-9_-]+)[^)]*)\)/', $content, $match)) {
        return $match[2];
    }
    return null;
}

/**
 * Import a single page from Google Docs
 */
function jmheights_import_single_page($map, $dry_run, $is_cli) {
    $title = $map['title'];
    $slug = $map['slug'];
    $doc_id = $map['doc_id'];

    // Find the WordPress page by slug
    $page = jmheights_find_page_by_slug($slug);

    if (!$page) {
        $msg = "Page not found in WordPress";
        if ($is_cli) WP_CLI::warning("SKIP: $title ($slug) — $msg");
        return ['status' => 'skipped', 'title' => $title, 'slug' => $slug, 'message' => $msg];
    }

    // Fetch Google Doc content
    $html = jmheights_fetch_google_doc($doc_id);
    if ($html === false) {
        $msg = "Failed to fetch Google Doc";
        if ($is_cli) WP_CLI::warning("ERROR: $title ($slug) — $msg");
        return ['status' => 'error', 'title' => $title, 'slug' => $slug, 'message' => $msg];
    }

    // Clean the HTML
    $clean_html = jmheights_clean_google_html($html);
    if (empty(trim(strip_tags($clean_html)))) {
        $msg = "Google Doc is empty";
        if ($is_cli) WP_CLI::warning("SKIP: $title ($slug) — $msg");
        return ['status' => 'skipped', 'title' => $title, 'slug' => $slug, 'message' => $msg];
    }

    $content_length = strlen($clean_html);

    if ($dry_run) {
        $msg = "Would update ($content_length chars)";
        if ($is_cli) WP_CLI::log("DRY: $title ($slug) — $msg");
        return ['status' => 'success', 'title' => $title, 'slug' => $slug, 'message' => $msg];
    }

    // Update the page
    $result = wp_update_post([
        'ID' => $page->ID,
        'post_content' => $clean_html,
    ], true);

    if (is_wp_error($result)) {
        $msg = "Update failed: " . $result->get_error_message();
        if ($is_cli) WP_CLI::warning("ERROR: $title ($slug) — $msg");
        return ['status' => 'error', 'title' => $title, 'slug' => $slug, 'message' => $msg];
    }

    $msg = "Updated ($content_length chars)";
    if ($is_cli) WP_CLI::log("OK: $title ($slug) — $msg");
    return ['status' => 'success', 'title' => $title, 'slug' => $slug, 'message' => $msg];
}

/**
 * Import town pages from the combined Google Doc
 */
function jmheights_import_town_pages($doc_id, $dry_run, $is_cli) {
    $results = [];

    if ($is_cli) WP_CLI::log("\nImporting town pages from combined doc...");

    $html = jmheights_fetch_google_doc($doc_id);
    if ($html === false) {
        $msg = "Failed to fetch combined town pages doc";
        if ($is_cli) WP_CLI::warning($msg);
        return [['status' => 'error', 'title' => 'Town Pages', 'slug' => '', 'message' => $msg]];
    }

    // Split by town headings — look for h1/h2/h3 tags containing town names
    $clean_html = jmheights_clean_google_html($html);

    // Split content by major headings that match town names
    $towns = jmheights_get_all_towns();
    $sections = jmheights_split_by_towns($clean_html, $towns);

    foreach ($sections as $town_name => $town_content) {
        $slug = 'service-areas/' . sanitize_title($town_name);
        $page = jmheights_find_page_by_slug($slug);

        if (!$page) {
            // Try just the town slug under service-areas
            $page = jmheights_find_page_by_slug(sanitize_title($town_name));
        }

        if (!$page) {
            if ($is_cli) WP_CLI::warning("SKIP: $town_name ($slug) — Page not found");
            $results[] = ['status' => 'skipped', 'title' => $town_name, 'slug' => $slug, 'message' => 'Page not found'];
            continue;
        }

        $content_length = strlen($town_content);

        if ($dry_run) {
            $msg = "Would update ($content_length chars)";
            if ($is_cli) WP_CLI::log("DRY: $town_name ($slug) — $msg");
            $results[] = ['status' => 'success', 'title' => $town_name, 'slug' => $slug, 'message' => $msg];
            continue;
        }

        $result = wp_update_post([
            'ID' => $page->ID,
            'post_content' => $town_content,
        ], true);

        if (is_wp_error($result)) {
            $msg = "Update failed: " . $result->get_error_message();
            if ($is_cli) WP_CLI::warning("ERROR: $town_name ($slug) — $msg");
            $results[] = ['status' => 'error', 'title' => $town_name, 'slug' => $slug, 'message' => $msg];
        } else {
            $msg = "Updated ($content_length chars)";
            if ($is_cli) WP_CLI::log("OK: $town_name ($slug) — $msg");
            $results[] = ['status' => 'success', 'title' => $town_name, 'slug' => $slug, 'message' => $msg];
        }

        usleep(100000); // 0.1 second delay between DB updates
    }

    return $results;
}

/**
 * Find a WordPress page by its slug (handles nested slugs)
 */
function jmheights_find_page_by_slug($slug) {
    // For nested slugs like "plumbing/water-heaters", get the last segment
    $parts = explode('/', $slug);
    $page_slug = end($parts);

    // Try exact slug match first
    $pages = get_posts([
        'name' => $page_slug,
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => 1,
    ]);

    if (!empty($pages)) {
        return $pages[0];
    }

    // Try with full path for disambiguation
    $page = get_page_by_path($slug);
    return $page ?: null;
}

/**
 * Fetch a Google Doc as HTML
 */
function jmheights_fetch_google_doc($doc_id) {
    $url = "https://docs.google.com/document/d/{$doc_id}/export?format=html";

    $response = wp_remote_get($url, [
        'timeout' => 30,
        'user-agent' => 'Mozilla/5.0 (compatible; JMHeights/1.0)',
    ]);

    if (is_wp_error($response)) {
        return false;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        return false;
    }

    return wp_remote_retrieve_body($response);
}

/**
 * Clean Google Docs exported HTML — strip styles, scripts, and Google-specific markup
 */
function jmheights_clean_google_html($html) {
    // Extract just the body content
    if (preg_match('/<body[^>]*>(.*)<\/body>/s', $html, $match)) {
        $html = $match[1];
    }

    // Remove style tags and their contents
    $html = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $html);

    // Remove script tags
    $html = preg_replace('/<script[^>]*>.*?<\/script>/s', '', $html);

    // Remove all inline styles
    $html = preg_replace('/\s*style="[^"]*"/', '', $html);

    // Remove all class attributes
    $html = preg_replace('/\s*class="[^"]*"/', '', $html);

    // Remove all id attributes
    $html = preg_replace('/\s*id="[^"]*"/', '', $html);

    // Remove Google tracking links (redirect URLs)
    $html = preg_replace('/href="https:\/\/www\.google\.com\/url\?q=([^&]+)&[^"]*"/', 'href="$1"', $html);

    // URL decode the cleaned hrefs
    $html = preg_replace_callback('/href="([^"]+)"/', function($m) {
        return 'href="' . urldecode($m[1]) . '"';
    }, $html);

    // Remove empty spans
    $html = preg_replace('/<span>\s*<\/span>/', '', $html);

    // Collapse nested spans — unwrap <span> tags
    $html = preg_replace('/<span>([^<]*)<\/span>/', '$1', $html);

    // Remove empty paragraphs
    $html = preg_replace('/<p>\s*<\/p>/', '', $html);

    // Remove <a> tags that are just anchors (no href or empty href)
    $html = preg_replace('/<a>\s*<\/a>/', '', $html);

    // Clean up whitespace
    $html = preg_replace('/\n{3,}/', "\n\n", $html);
    $html = trim($html);

    return $html;
}

/**
 * Get all town names
 */
function jmheights_get_all_towns() {
    return [
        // Bergen County
        'Allendale', 'Bergenfield', 'Cliffside Park', 'Closter', 'Cresskill',
        'Demarest', 'Dumont', 'Edgewater', 'Elmwood Park', 'Emerson',
        'Englewood', 'Englewood Cliffs', 'Fair Lawn', 'Fort Lee', 'Franklin Lakes',
        'Garfield', 'Glen Rock', 'Hackensack', 'Hasbrouck Heights', 'Hillsdale',
        'Ho-Ho-Kus', 'Leonia', 'Lodi', 'Lyndhurst', 'Mahwah',
        'Maywood', 'Midland Park', 'Montvale', 'New Milford', 'Oakland',
        'Old Tappan', 'Oradell', 'Palisades Park', 'Paramus', 'Park Ridge',
        'Ramsey', 'Ridgefield', 'Ridgefield Park', 'Ridgewood', 'River Edge',
        'River Vale', 'Rutherford', 'Saddle Brook', 'Saddle River', 'Teaneck',
        'Tenafly', 'Upper Saddle River', 'Waldwick', 'Westwood', 'Woodcliff Lake',
        'Wyckoff',
        // Passaic County
        'Bloomingdale', 'Clifton', 'Hawthorne', 'Little Falls', 'Passaic',
        'Paterson', 'Pompton Lakes', 'Ringwood', 'Totowa', 'Wanaque',
        'Wayne', 'West Milford', 'Woodland Park',
    ];
}

/**
 * Split combined HTML content into sections by town name headings
 */
function jmheights_split_by_towns($html, $towns) {
    $sections = [];

    // Sort towns by length (longest first) to avoid partial matches
    usort($towns, fn($a, $b) => strlen($b) - strlen($a));

    // Build a regex pattern for town-name headings
    $town_pattern = implode('|', array_map('preg_quote', $towns));

    // Split by headings containing town names
    // Match h1, h2, h3, or h4 tags that contain a town name
    $pattern = '/(<h[1-4][^>]*>(?:[^<]*)?(' . $town_pattern . ')(?:[^<]*)?<\/h[1-4]>)/i';

    $parts = preg_split($pattern, $html, -1, PREG_SPLIT_DELIM_CAPTURE);

    $current_town = null;
    $current_content = '';

    for ($i = 0; $i < count($parts); $i++) {
        $part = trim($parts[$i]);
        if (empty($part)) continue;

        // Check if this part is a heading with a town name
        $found_town = null;
        foreach ($towns as $town) {
            if (preg_match('/<h[1-4][^>]*>.*?' . preg_quote($town, '/') . '.*?<\/h[1-4]>/i', $part)) {
                $found_town = $town;
                break;
            }
        }

        if ($found_town) {
            // Save previous town's content
            if ($current_town && !empty(trim(strip_tags($current_content)))) {
                $sections[$current_town] = trim($current_content);
            }
            $current_town = $found_town;
            $current_content = $part; // Include the heading
            $i++; // Skip the captured town name group
        } else {
            $current_content .= $part;
        }
    }

    // Save last town
    if ($current_town && !empty(trim(strip_tags($current_content)))) {
        $sections[$current_town] = trim($current_content);
    }

    return $sections;
}
