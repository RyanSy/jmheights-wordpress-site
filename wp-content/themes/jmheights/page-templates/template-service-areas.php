<?php
/**
 * Template Name: Service Areas
 */
get_header();
?>

<div class="page-header-banner">
    <div class="container">
        <h1>Service Areas</h1>
        <p>Proudly serving Bergen County, Passaic County, and all of North Jersey</p>
        <?php jmheights_breadcrumbs(); ?>
    </div>
</div>

<section class="section section-light">
    <div class="container">
        <div class="section-label">Where We Serve</div>
        <h2 class="section-title">North Jersey's <span class="highlight">Trusted</span> HVAC & Plumbing Team</h2>
        <p class="section-subtitle">
            JM Heights Cooling Corp. has been proudly serving communities across Bergen County and Passaic County since 1969. No matter where you are in North Jersey, we're just a call away.
        </p>

        <div class="service-areas-grid">
            <!-- Bergen County -->
            <div class="area-card">
                <h3>Bergen County</h3>
                <ul>
                    <?php
                    $bergen_towns = [
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
                        'Wyckoff'
                    ];
                    foreach ($bergen_towns as $town):
                        $slug = sanitize_title($town);
                    ?>
                        <li><a href="<?php echo home_url("/service-areas/$slug/"); ?>"><?php echo esc_html($town); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Passaic County -->
            <div class="area-card">
                <h3>Passaic County</h3>
                <ul>
                    <?php
                    $passaic_towns = [
                        'Bloomingdale', 'Clifton', 'Hawthorne', 'Little Falls', 'Passaic',
                        'Paterson', 'Pompton Lakes', 'Ringwood', 'Totowa', 'Wanaque',
                        'Wayne', 'West Milford', 'Woodland Park'
                    ];
                    foreach ($passaic_towns as $town):
                        $slug = sanitize_title($town);
                    ?>
                        <li><a href="<?php echo home_url("/service-areas/$slug/"); ?>"><?php echo esc_html($town); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-label">Serving All of North Jersey</div>
        <h2>Your Local <span class="highlight">HVAC & Plumbing</span> Experts</h2>
        <p>Family owned & operated since 1969. Licensed, insured, and ready to help.</p>
        <div class="cta-buttons">
            <a href="tel:+12018243272" class="btn-cta">
                <?php echo jmheights_icon('phone'); ?>
                Call (201) 824-3272
            </a>
            <a href="<?php echo home_url('/contact/'); ?>" class="btn-cta btn-outline">
                Request Free Estimate
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
