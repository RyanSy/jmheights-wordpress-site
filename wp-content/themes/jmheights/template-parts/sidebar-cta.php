<?php
/**
 * Sidebar CTA widget + service navigation
 */

$current_page_id = get_the_ID();
$parent_id = wp_get_post_parent_id($current_page_id);
$top_parent_id = $parent_id ? ($parent_id ?: $current_page_id) : $current_page_id;

// Get top-level ancestor
$ancestors = get_post_ancestors($current_page_id);
if (!empty($ancestors)) {
    $top_parent_id = end($ancestors);
}

// Get sibling pages
$siblings = get_pages([
    'parent'      => $parent_id ?: $current_page_id,
    'sort_column' => 'menu_order',
]);

if (!empty($siblings)):
?>
<div class="sidebar-widget">
    <div class="sidebar-widget-title">
        <?php echo get_the_title($parent_id ?: $current_page_id); ?>
    </div>
    <ul>
        <?php foreach ($siblings as $sibling): ?>
            <li <?php echo ($sibling->ID === $current_page_id) ? 'class="active"' : ''; ?>>
                <a href="<?php echo get_permalink($sibling->ID); ?>">
                    <?php echo esc_html($sibling->post_title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- CTA Widget -->
<div class="sidebar-cta">
    <h4>Need Help?</h4>
    <p>Our experts are standing by to help with your HVAC & plumbing needs.</p>
    <a href="tel:+12018243272" class="btn-cta" style="width: 100%; margin-bottom: 12px;">
        <?php echo jmheights_icon('phone'); ?>
        Call Now
    </a>
    <a href="<?php echo home_url('/contact/'); ?>" class="btn-cta btn-outline" style="width: 100%; border-color: var(--color-orange); color: var(--color-orange);">
        Free Estimate
    </a>
</div>

<!-- Emergency Widget -->
<div class="sidebar-widget" style="margin-top: 24px;">
    <div class="sidebar-widget-title" style="background: var(--color-orange);">
        24/7 Emergency Service
    </div>
    <div style="padding: 20px; text-align: center;">
        <p style="font-size: 14px; color: var(--color-gray-600); margin-bottom: 12px;">
            No heat? No AC? We're here around the clock.
        </p>
        <a href="tel:+12018243272" style="font-size: 20px; font-weight: 700; color: var(--color-orange);">
            (201) 824-3272
        </a>
    </div>
</div>
