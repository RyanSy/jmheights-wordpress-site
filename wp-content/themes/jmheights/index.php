<?php
/**
 * Default template
 */
get_header();
?>

<div class="page-header-banner">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<section class="section section-light">
    <div class="container">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; endif; ?>
    </div>
</section>

<?php get_footer(); ?>
