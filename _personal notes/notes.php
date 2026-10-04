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
