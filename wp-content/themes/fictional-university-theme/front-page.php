<?php get_header();?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div>
    <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
    </div>
</div>

<div class="full-width-split group">
    <div class="full-width-split__one">
    <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

        <?php
$today = date('Ymd');
$recentEvents = new WP_Query(array(
    // 'posts_per_page' => -1, -1 means display all
    'posts_per_page' => 2,
    'post_type' => 'event',
    // 'order'=> 'DESC', DESC is default
    'order' => 'ASC',
    // for custom field, we need to use meta_query
    'meta_key' => 'event_date',
    // 'orderby'=> 'meta_value_num', meta_value is a string, meta_value_num is a number
    'orderby' => 'meta_value_num',
    'meta_query' => array(
        array(
            // this means we are going to compare the value of the custom field with the current date, and only show the events that are in the future
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            // numeric is optional, since were comparing dates
            'type' => 'numeric',
        ),
    ),
));

while ($recentEvents->have_posts()) {
    $recentEvents->the_post(); ?>

        <div class="event-summary">
        <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
        <span class="event-summary__month"><?php
        $eventDate = new DateTime(get_field('event_date'));
    echo $eventDate->format('M');?>
        </span>
        <span class="event-summary__day"><?php echo $eventDate->format('d');?></span></a>

        <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <p><?php
    if (has_excerpt()) {
        echo get_the_excerpt();
    } else {
        echo wp_trim_words(get_the_content(), 18);
    } ?> <a href="<?php the_permalink(); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
        </div>
        </div>

<?php } ?>

        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
    </div>
    </div>
    <div class="full-width-split__two">
    <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
        <?php
$recentPosts = new WP_Query(array(
    'posts_per_page' => 2,
)); ?>

        <?php
while ($recentPosts->have_posts()) {
    $recentPosts->the_post(); ?>

        <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php the_time('M') ?></span>
            <span class="event-summary__day"><?php the_time('d'); ?></span>
        </a>
        <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <p style="display: inline-block;"><?php
            if (has_excerpt()) {
                echo get_the_excerpt();
            } else {
                echo wp_trim_words(get_the_content(), 18);
            } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
        </div>
        </div>
        <?php } wp_reset_postdata(); ?>

        <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
    </div>
</div>

<div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg');?>)">
        <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
            </div>
        </div>
        </div>
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg');?>">
        <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
            </div>
        </div>
        </div>
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg');?>)">
        <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
            </div>
        </div>
        </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
    </div>
</div>

<?php get_footer();?>
