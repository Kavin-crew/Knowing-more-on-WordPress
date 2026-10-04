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
<p>
    <?php bloginfo('description'); ?>
</p>

<!-- basic structure of while loop using array -->
<?php
$names = ['dog', 'cat', 'bird', 'fish', 'hamster', 'rabbit', 'turtle'];
$count = 0;

while ($count < count($names)) {
    echo "<li>$names[$count]</li>";
    $count++;
}

// lets wordpress place scripts file before the closing body tag, so we can use wp_footer() function in footer.php file
// also helps add black admin bar on top of the page when logged in as admin
wp_footer();

// retrieve images from our theme folder, we can use get_theme_file_uri() function
// style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?-->)"

//////////////////////////////////////////////
// adding script in function.php file
//////////////////////////////////////////////
// for arguements.
// 1. any script name
// 2. get_theme_file_uri('/file path')
// 3. array of dependencies, if any. if None then null
// 4. version number
// 5. true or false, if load the script in footer, if false then load in header
wp_enqueue_script('carousel_slider_js', get_theme_file_uri('/build/js/index.js'), ['jquery'], '1.0', true);
// another example
wp_enqueue_script('carousel_slider_js', get_theme_file_uri('/build/js/index.js'), null, '1.0', true);
