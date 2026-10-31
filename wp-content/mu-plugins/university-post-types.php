<?php

////////////////////////////////////
// Add new CPT
////////////////////////////////////
function university_post_types()
{
    register_post_type('event', array(
        'public' => true,
        'rewrite' => array(
            'slug' => 'events',
        ),
        'show_in_rest' => true,
        'has_archive' => true,
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
