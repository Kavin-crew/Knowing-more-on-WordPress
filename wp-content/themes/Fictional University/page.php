<?php
while (have_posts()) {
    the_post(); ?>
    <h2>
        <?php the_title(); ?>
    </h2>
    <p>
        <?php the_content(); ?>
    </p>
    <a href="<?php echo home_url(); ?>">Back</a>
    <?php
}
?>