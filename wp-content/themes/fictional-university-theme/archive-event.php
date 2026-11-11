<?php get_header();
pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'All upcoming events that you can attend.',
));
?>

<div class="container container--narrow page-section">
    <?php while (have_posts()) {
        the_post();
        // either is correct
        // get_template_part('template-parts/content-event',);
        get_template_part('template-parts/content', 'event');
    } ?>

    <div class="pagination"><?php echo paginate_links(); ?></div>
    <hr class="section-break">
    <p>Looking for a recap of our past events? <a href="<?php echo site_url('/past-events'); ?>">View all past events</a>.</p>
</div>

<?php get_footer();?>
