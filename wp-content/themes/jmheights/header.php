<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
        <?php if (has_custom_logo()): ?>
            <?php
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'thumbnail');
            ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>">
        <?php else: ?>
            <img src="<?php echo JMHEIGHTS_URI; ?>/images/logo-placeholder.svg" alt="<?php bloginfo('name'); ?>">
        <?php endif; ?>
        <div class="logo-text">
            JM Heights<span>Cooling Corp.</span>
        </div>
    </a>

    <nav class="primary-nav" id="primary-nav">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'fallback_cb'    => 'jmheights_fallback_menu',
        ]);
        ?>
    </nav>

    <div class="header-actions">
        <a href="tel:+12018243272" class="header-phone">
            <?php echo jmheights_icon('phone'); ?>
            (201) 824-3272
        </a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-cta">Free Estimate</a>
    </div>

    <button class="mobile-menu-toggle" aria-label="Toggle Menu" id="mobile-menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
</header>

<main id="main-content">
<?php
function jmheights_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . home_url('/') . '">Home</a></li>';
    echo '<li><a href="' . home_url('/about/') . '">About</a></li>';
    echo '<li class="menu-item-has-children"><a href="' . home_url('/plumbing/') . '">Services</a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . home_url('/plumbing/') . '">Plumbing</a></li>';
    echo '<li><a href="' . home_url('/hvac/') . '">HVAC</a></li>';
    echo '<li><a href="' . home_url('/heating/') . '">Heating</a></li>';
    echo '<li><a href="' . home_url('/commercial/') . '">Commercial</a></li>';
    echo '</ul></li>';
    echo '<li><a href="' . home_url('/financing/') . '">Financing</a></li>';
    echo '<li><a href="' . home_url('/contact/') . '">Contact</a></li>';
    echo '</ul>';
}
