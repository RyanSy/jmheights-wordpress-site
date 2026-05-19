<?php
/**
 * Template Name: Contact Page
 */
get_header();
?>

<div class="page-header-banner">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Get in touch with North Jersey's trusted HVAC & plumbing experts</p>
        <?php jmheights_breadcrumbs(); ?>
    </div>
</div>

<?php get_template_part('template-parts/contact-form'); ?>

<?php get_footer(); ?>
