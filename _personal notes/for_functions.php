hook list
wp_enqueue_scripts - we load files css/js and so on, works as an arguement

add_action(); - adding actions, ask for 2 arguements

wp_enqueue_style(); - load css files


retrieve the file from the theme folder, works as an arguement
get_theme_file_uri('/build/style-index.css')


retrieve the file from external source
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


wp_enqueue_script(); - load js files

get_stylesheet_uri(); retrieve the default style.css file in our theme