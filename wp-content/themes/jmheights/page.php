<?php
/**
 * Default Page Template
 */
get_header();
?>

<div class="page-header-banner">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <?php if (has_excerpt()): ?>
            <p><?php the_excerpt(); ?></p>
        <?php endif; ?>
        <?php jmheights_breadcrumbs(); ?>
    </div>
</div>

<section class="section section-light">
    <div class="container">
        <div class="service-page-grid">
            <div class="service-main">
                <?php if (have_posts()): while (have_posts()): the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </div>

            <aside class="service-sidebar">
                <?php get_template_part('template-parts/sidebar-cta'); ?>
            </aside>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-label">Ready to Get Started?</div>
        <h2>We Pick Up. We Show Up. <span class="highlight">We Get It Done.</span></h2>
        <p>Whether it's a routine tune-up, an emergency breakdown, or a full system replacement — JM Heights Cooling Corp. is ready. Call or text us today!</p>
        <div class="cta-buttons">
            <a href="tel:+12018243272" class="btn-cta">
                <?php echo jmheights_icon('phone'); ?>
                Call (201) 824-3272
            </a>
            <a href="sms:+12018243272" class="btn-cta btn-outline">
                <?php echo jmheights_icon('text'); ?>
                Text Us
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
