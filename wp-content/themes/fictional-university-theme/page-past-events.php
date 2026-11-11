<!-- only works on Past Events page which has the 'past-events' slug -->

<?php get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our previous events.',
));
?>

<div class="container container--narrow page-section">

    <?php
    $today = date('Ymd');
$pastEvents = new WP_Query(array(
    // paged is used for pagination
    // get_query_var('paged', 1) gets the current page number, if not set then default to 1
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'order' => 'ASC',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'meta_query' => array(
        array(
            'key' => 'event_date',
            'compare' => '<=',
            'value' => $today,
            'type' => 'numeric',
        ),
    ),
));

while ($pastEvents->have_posts()) {
    $pastEvents->the_post();
    get_template_part('template-parts/content', 'event');
} ?>

    <div class="pagination">
          <?php echo paginate_links(array(
              'total' => $pastEvents->max_num_pages,
          )); ?>
     </div>
</div>

<?php get_footer();?>
