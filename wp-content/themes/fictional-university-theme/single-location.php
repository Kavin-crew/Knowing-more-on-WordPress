
<?php get_header();
pageBanner(); ?>

<?php
while (have_posts()) :
    the_post();
    $location_id = get_the_ID();
    // Retrieve ACF coordinates
    $latitude = get_field('location_latitude', $location_id);
    $longitude = get_field('location_longitude', $location_id);
    $address = get_field('location_address', $location_id);

    $has_coordinates = is_numeric($latitude) && is_numeric($longitude);
    ?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('location'); ?>">
            <i class="fa fa-map-marker" aria-hidden="true"></i> All Locations</a>
        <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

        <?php if ($address) : ?>
            <p><?php echo esc_html($address); ?></p>
        <?php endif; ?>

        <div class="location-content">
            <?php the_content(); ?>
        </div>

        <?php if ($has_coordinates) : ?>

            <div
                id="single-location-map"
                style="height: 450px; width: 100%; margin-top: 40px;"
            ></div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {

                const latitude = <?php echo wp_json_encode((float) $latitude); ?>;
                const longitude = <?php echo wp_json_encode((float) $longitude); ?>;

                const mapElement = document.getElementById('single-location-map');

                if (!mapElement || typeof L === 'undefined') {
                    return;
                }

                const map = L.map('single-location-map').setView(
                    [latitude, longitude],
                    15
                );

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup(<?php echo wp_json_encode(get_the_title()); ?>)
                    .openPopup();

            });
            </script>

        <?php else : ?>
            <p>Location coordinates are not available.</p>
        <?php endif; ?>

        <?php $relatedPrograms = new WP_Query(array(
        'post_per_page' => -1,
        'post_type' => 'program',
        'order' => 'ASC',
        'orderby' => 'title',
        'meta_query' => array(
            array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
            ),
        ),
    ));

    if ($relatedPrograms->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Programs available at ' . get_the_title() . '</h2>';
        echo '<ul class="min-list link-list">';
        while ($relatedPrograms->have_posts()) {
            $relatedPrograms->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>

    <?php } echo '</ul>';?>
    <?php } ?>
</div>

<?php endwhile;

get_footer();
?>
