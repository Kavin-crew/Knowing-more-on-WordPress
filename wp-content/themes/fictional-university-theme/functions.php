<?php

////////////////////////////////////
// Add new custom field in results of rest api request
////////////////////////////////////

function university_custom_rest(){
    register_rest_field('post', 'authorName', array(
        'get_callback' => function (){
            return get_the_author();
        }
    ));
}
add_action('rest_api_init','university_custom_rest');

////////////////////////////////////
// Reusable page banner function
////////////////////////////////////

function pageBanner($args = null)
{
    // if the title is not set, then use page title
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    // if the subtitle is not set, then use custom field subtitle
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    // if the photo is not set, then use custom field background image or default
    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

    ?>
    <div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url('<?php echo $args['photo']; ?>');">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
        </div>
    </div>
</div>
<?php } ?>

<?php
////////////////////////////////////
// Load scripts, stylesheets, and fonts
////////////////////////////////////

function university_files()
{
    // add the style.css to the list of files from university_files
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_css', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('university_secondary_css', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_localize_script('main-university-js', 'universityData', array(
        'root_url'=> get_site_url(),
    ));

    // leaflet
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array('jquery'), '1.9.4', true);
}
// hook to load the files in the theme from university_files()
add_action('wp_enqueue_scripts', 'university_files');

////////////////////////////////////
// Enable adding page title in address bar of the browser
////////////////////////////////////

function university_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);

    register_nav_menu('HeaderMenuLocation', 'Header Menu');
    register_nav_menu('FooterExploreMenuLocation', 'Footer Explore Menu');
    register_nav_menu('FooterLearnMenuLocation', 'Footer Learn Menu');
}
add_action('after_setup_theme', 'university_features');

////////////////////////////////////
// Adjusting queries
////////////////////////////////////

function university_adjust_queries($query)
{
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric',
            ),
        ), );
    }

    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('post_per_page', -1);
    }

    if (!is_admin() && is_post_type_archive('location') && $query->is_main_query()) {
        $query->set('post_per_page', -1);
    }
}
add_action('pre_get_posts', 'university_adjust_queries');

////////////////////////////////////
// Leaflet metabox
////////////////////////////////////

function add_location_map_metabox()
{
    add_meta_box(
        'location_map_picker',
        'Select Location on Map',
        'location_map_metabox_callback',
        'location',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_location_map_metabox');

function location_map_metabox_callback()
{
    ?>
    <div id="location-admin-map" style="height: 400px; width: 100%;"></div>
    <p>Click on the map or drag the marker to select your location.</p>
    <?php
}

function admin_leaflet_assets($hook)
{
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'location') {
        return;
    }

    wp_enqueue_style('leaflet-admin-css','https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',array(),'1.9.4');
    wp_enqueue_script('leaflet-admin-js','https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',array('jquery'),'1.9.4',true);

    $script = <<<'JS'
    jQuery(function($) {

    var mapElement = document.getElementById('location-admin-map');

    if (!mapElement || typeof L === 'undefined') return;

    var latInput = $('.acf-field[data-name="location_latitude"] input');
    var lngInput = $('.acf-field[data-name="location_longitude"] input');
    var addressInput = $('.acf-field[data-name="location_address"] input');

    var lat = parseFloat(latInput.val());
    var lng = parseFloat(lngInput.val());

    var hasCoordinates = Number.isFinite(lat) && Number.isFinite(lng);

    var initialPosition = hasCoordinates
        ? [lat, lng]
        : [10.3157, 123.8854];

    var initialZoom = hasCoordinates ? 15 : 13;

    var map = L.map('location-admin-map').setView(
        initialPosition,
        initialZoom
    );

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = null;
    var addressTimer = null;
    var requestController = null;
    var requestId = 0;

    function updateCoordinates(position) {
        latInput.val(position.lat.toFixed(6)).trigger('change');
        lngInput.val(position.lng.toFixed(6)).trigger('change');
    }

    function getAddress(position) {
        clearTimeout(addressTimer);
        if (requestController) {
            requestController.abort();
        }

        var currentRequest = ++requestId;

        addressInput.val('Retrieving address...').trigger('change');

        addressTimer = setTimeout(function() {

            requestController = new AbortController();

            var params = new URLSearchParams({
                format: 'jsonv2',
                lat: position.lat,
                lon: position.lng,
                addressdetails: 1,
                'accept-language': 'en'
            });

            fetch(
                'https://nominatim.openstreetmap.org/reverse?' + params.toString(),
                {
                    signal: requestController.signal,
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            )
            .then(function(response) {

                if (!response.ok) {
                    throw new Error('Unable to retrieve address.');
                }

                return response.json();

            })
            .then(function(data) {

                if (currentRequest !== requestId) return;

                if (data.display_name) {

                    addressInput
                        .val(data.display_name)
                        .trigger('change');

                } else {

                    addressInput.val('').trigger('change');

                    alert('No address found for this location.');

                }

            })
            .catch(function(error) {

                if (error.name === 'AbortError') return;

                if (currentRequest !== requestId) return;

                console.error('Reverse geocoding error:', error);

                addressInput.val('').trigger('change');

                alert('Unable to retrieve the address. Please try again.');

            });

        }, 1100);

    }

    function placeMarker(position) {
        if (marker) {
            marker.setLatLng(position);
        } else {
            marker = L.marker(position, {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function() {
                var newPosition = marker.getLatLng();
                updateCoordinates(newPosition);
                getAddress(newPosition);
            });
        }
        updateCoordinates(position);
        getAddress(position);
    }

    if (hasCoordinates) {
        placeMarker({
            lat: lat,
            lng: lng
        });
    }

    map.on('click', function(event) {
        placeMarker(event.latlng);
    });

    setTimeout(function() {
        map.invalidateSize();
    }, 300);

});
JS;

    wp_add_inline_script('leaflet-admin-js', $script);
}
add_action('admin_enqueue_scripts', 'admin_leaflet_assets');

function location_map_data()
{
    if (!is_post_type_archive('location')) {
        return;
    }

    $locations = get_posts(array(
        'post_type' => 'location',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));

    $map_data = array();

    foreach ($locations as $location) {
        $lat = get_field('location_latitude', $location->ID);
        $lng = get_field('location_longitude', $location->ID);

        if ($lat === '' || $lat === false ||
            $lng === '' || $lng === false ||
            !is_numeric($lat) || !is_numeric($lng)) {
            continue;
        }

        $map_data[] = array(
            'title' => get_the_title($location->ID),
            'lat' => (float) $lat,
            'lng' => (float) $lng,
            'address' => get_field('location_address', $location->ID),
            'url' => get_permalink($location->ID),
        );
    }

    wp_localize_script(
        'leaflet-js',
        'locationMapData',
        $map_data
    );

    $script = <<<'JS'
    document.addEventListener('DOMContentLoaded', function() {

        var mapElement = document.getElementById('locations-map');

        if (!mapElement || typeof L === 'undefined') return;

        var locations = window.locationMapData || [];

        var defaultCenter = [20, 0];

        var map = L.map('locations-map').setView(defaultCenter, 2);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var bounds = [];

        locations.forEach(function(location) {

            var marker = L.marker([
                location.lat,
                location.lng
            ]).addTo(map);

            var popup = '<strong>' +
                document.createTextNode(location.title).textContent +
                '</strong>';

            if (location.address) {
                popup += '<br>' +
                    document.createTextNode(location.address).textContent;
            }

            popup += '<br><a href=\"' +
                location.url.replace(/&/g, '&amp;').replace(/\"/g, '&quot;') +
                '\">View Location</a>';

            marker.bindPopup(popup);

            bounds.push([
                location.lat,
                location.lng
            ]);

        });

        if (bounds.length === 1) {
            map.setView(bounds[0], 14);
        } else if (bounds.length > 1) {
            map.fitBounds(bounds, {
                padding: [40, 40]
            });
        }

    });
    JS;

    wp_add_inline_script('leaflet-js', $script);
}
add_action('wp_enqueue_scripts', 'location_map_data', 20);
