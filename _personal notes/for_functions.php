<?php
///////////////////////////////////////
//hook list
///////////////////////////////////////

// we load files css/js and so on, works as an arguement
wp_enqueue_scripts();

// we can add theme support, works as an arguement
after_setup_theme();

// add theme support, works as an arguement
add_theme_support();

// register a menu,  ask for 2 arguements
register_nav_menu();

// adding actions, ask for 2 arguements
add_action();

// load css files
wp_enqueue_style();

// retrieve the default style.css file in our theme
get_stylesheet_uri();

// load js files
wp_enqueue_script();


// retrieve the file from the theme folder, works as an arguement
get_theme_file_uri('/build/style-index.css')

// retrieve the file from external source
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


////////////////////////////////////
// Add new CPT
////////////////////////////////////
function university_post_types()
{
    register_post_type('event', array(
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
        ),
        'menu_icon' => 'dashicons-calendar-alt',
    ));
}
add_action('init', 'university_post_types');
