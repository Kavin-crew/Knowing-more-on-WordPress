<!-- for fomatting and auto refresh page -->
 <!-- always add it to the root folder -->
.php-cs-fixer.dist.php
bs-config.js
.prettierrc.json
package.json
package-lock.json

npm run dev

<!-- retrieve site name -->
<h1><?php bloginfo('name'); ?></h1>

<!-- retrieve site tagline -->
<p><?php bloginfo('description'); ?></p>

<!-- retrieve page title -->
<h1 class="page-banner__title"><?php the_title(); ?></h1>

<!-- retrieve page content -->
<div class="generic-content"><?php the_content(); ?></div>

<!-- getting dynamic URLs -->
echo site_url(); - returns the root url
<li><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>

<!-- returns the current page id -->
get_the_ID()
<!-- returns the parent page id of the current page, if any. If no parent then returns 0/false -->
wp_get_post_parent_id(get_the_ID())

<!-- returns a list of pages -->
<!-- returns the list of pages in the form of unordered list, we can use it to create a menu for child pages. It takes arguements like child_of, title_li, sort_column, sort_order etc. -->
wp_list_pages()

<!-- If the result is 0/false, it will display it's own title -->
<?php echo get_the_title($has_parent_page)?>;

<!-- returns list of pages in memory -->
get_pages();


<!-- check if the current page has any child pages -->
<?php
    $has_children_page = get_pages(array(
        'child_of' => get_the_ID(),
    ));
?>


<!-- basic loop for posts -->
<?php
while (have_posts()) {
    the_post(); ?>

    <!-- implementation here -->
<?php } ?>

// lets wordpress place scripts file before the closing body tag, so we can use wp_footer() function in footer.php file
// also helps add black admin bar on top of the page when logged in as admin
wp_footer();

// retrieve images from our theme folder, we can use get_theme_file_uri() function
// style="background-image: url(<!--?php echo get_theme_file_uri('/images/library-hero.jpg'); ?-->)"

//////////////////////////////////////////////
// adding script in function.php file
//////////////////////////////////////////////
// for arguements.
// 1. any script name
// 2. get_theme_file_uri('/file path')
// 3. array of dependencies, if any. if None then null
// 4. version number
// 5. true or false, if load the script in footer, if false then load in header
wp_enqueue_script('carousel_slider_js', get_theme_file_uri('/build/js/index.js'), array('jquery'), '1.0', true);
// another example
wp_enqueue_script('carousel_slider_js', get_theme_file_uri('/build/js/index.js'), null, '1.0', true);
