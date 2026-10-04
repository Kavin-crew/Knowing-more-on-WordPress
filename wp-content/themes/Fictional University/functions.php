<?php

// function to list files to be loaded in the theme
function university_files()
{
    // add the style.css to the list of files from university_files
    wp_enqueue_style('university_main_css', get_stylesheet_uri());
}

// hook to load the files in the theme from university_files()
add_action('wp_enqueue_scripts', 'university_files');
