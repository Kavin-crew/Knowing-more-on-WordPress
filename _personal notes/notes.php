<!-- retrieve site name -->
<h1><?php bloginfo('name'); ?></h1>

<!-- retrieve site tagline -->
<p>
    <?php bloginfo('description'); ?>
</p>

<!-- basic structure of while loop using array -->
<?php
$names = array("dog", "cat", "bird", "fish", "hamster", "rabbit", "turtle");
$count = 0;

while ($count < count($names)) {
    echo "<li>$names[$count]</li>";
    $count++;
}

