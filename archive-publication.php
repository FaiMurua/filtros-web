<?php
    /* Template Name: Publications */
    get_header();
?>

        <!-- Section Intro -->
        <section class="section-intro">
            <div class="section-intro-info">
                <h1 class="section-intro-title">Publications</h1>
                <p class="section-intro-text">Explore our research publications and insights.</p>
            </div>
            <img class="section-intro-image" src="<?php echo get_template_directory_uri(); ?>/img/green-arrow.svg" width="50" alt="">
            <div class="section-intro-bar solid-green-bg"></div>
            <div class="section-intro-full-bar solid-green-bg"></div>
        </section>
        <!-- End Section Intro -->

        <!-- News -->
        <section>
            <div class="search-grid">
                <div class="search-filter">
                    <h3 class="search-filter-title">Filter by:</h3>
                    <div id="selected-filters"></div>
                    <button id="clear-filters" class="clear-filters-button">Clear All Filters</button>
                    <div class="extra-information">

                    <form class="form-filters" id="filter-form" method="get">
                        <label for="order-by">Order by:</label>
                        <select name="order_by" id="order-by">
                            <option value="date_desc" <?php selected($_GET['order_by'], 'date_desc'); ?>>Newest first</option>
                            <option value="date_asc" <?php selected($_GET['order_by'], 'date_asc'); ?>>Oldest first</option>
                            <option value="title_asc" <?php selected($_GET['order_by'], 'title_asc'); ?>>A-Z</option>
                            <option value="title_desc" <?php selected($_GET['order_by'], 'title_desc'); ?>>Z-A</option>
                        </select>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Research Clusters:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="research_cluster" value="" <?php checked($_GET['research_cluster'], ''); ?>>
                                            All Research Clusters
                                        </label>
                                    </li>
                                <?php
                                // Obtener los términos de la taxonomía "research_cluster"
                                $research_clusters = get_terms(array(
                                    'taxonomy' => 'research_cluster',
                                    'hide_empty' => true,
                                ));
                                if (!empty($research_clusters) && !is_wp_error($research_clusters)) {
                                    foreach ($research_clusters as $research_cluster) : ?>
                                        <li>
                                            <label>
                                            <img class="icon-filter" src="<?php echo esc_url(get_field('research_cluster_icon', $research_cluster)); ?>" width="15" alt="">
                                                <input type="radio"
                                                name="research_cluster"
                                                value="<?php echo esc_attr($research_cluster->slug); ?>"
                                                <?php checked($_GET['research_cluster'], $research_cluster->slug); ?>>
                                                <?php echo esc_html($research_cluster->name); ?>
                                            </label>
                                        </li>
                                    <?php endforeach;
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">ICMPD's Thematic Areas:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="thematic_area" value="" <?php checked($_GET['thematic_area'], ''); ?>>
                                            All Thematic Areas
                                        </label>
                                    </li>
                                <?php
                                // Obtener los términos de la taxonomía "topic"
                                $thematic_areas = get_terms(array(
                                    'taxonomy' => 'topic',
                                    'hide_empty' => true,
                                ));
                                if (!empty($thematic_areas) && !is_wp_error($thematic_areas)) {
                                    foreach ($thematic_areas as $thematic_area) : ?>
                                        <li>
                                            <label>
                                                <input type="radio"
                                                name="thematic_area"
                                                value="<?php echo esc_attr($thematic_area->slug); ?>"
                                                <?php checked($_GET['thematic_area'], $thematic_area->slug); ?>>
                                                <?php echo esc_html($thematic_area->name); ?>
                                            </label>
                                        </li>
                                    <?php endforeach;
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Publication type:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                <?php
                                // Obtener los valores del campo select de ACF
                                if (function_exists('acf_get_field')) {
                                    $field = acf_get_field('publication_type');
                                    if ($field && isset($field['choices'])) {
                                        foreach ($field['choices'] as $value => $label) : ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox"
                                                    name="publication_type[]"
                                                    value="<?php echo esc_attr($value); ?>"
                                                    <?php checked(in_array($value, (array) $_GET['publication_type'])); ?>
                                                    class="filter-checkbox" value="<?php echo esc_attr($value); ?>">
                                                    <?php echo esc_html($label); ?>
                                                </label>
                                            </li>
                                        <?php endforeach;
                                    }
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Year:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="published_year" value="" <?php checked($_GET['published_year'], ''); ?>>
                                            All Years
                                        </label>
                                    </li>
                                    <?php
                                    // Obtener valores únicos del campo ACF "published_year"
                                    global $wpdb;
                                    $years = $wpdb->get_col("
                                        SELECT DISTINCT meta_value
                                        FROM {$wpdb->postmeta}
                                        WHERE meta_key = 'published_year_number'
                                        ORDER BY meta_value DESC
                                    ");

                                    if (!empty($years)) {
                                        foreach ($years as $year) : ?>
                                            <li>
                                                <label>
                                                    <input type="radio" name="published_year" value="<?php echo esc_attr($year); ?>" <?php checked($_GET['published_year'], $year); ?>>
                                                    <?php echo esc_html($year); ?>
                                                </label>
                                            </li>
                                        <?php endforeach;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Region:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="region" value="" <?php checked($_GET['region'], ''); ?>>
                                            All Regions
                                        </label>
                                    </li>
                                <?php
                                // Obtener los términos de la taxonomía "region"
                                $regions = get_terms(array(
                                    'taxonomy' => 'region',
                                    'hide_empty' => true,
                                ));
                                if (!empty($regions) && !is_wp_error($regions)) {
                                    foreach ($regions as $region) : ?>
                                        <li>
                                            <label>
                                                <input type="radio"
                                                name="region"
                                                value="<?php echo esc_attr($region->slug); ?>"
                                                <?php checked($_GET['region'], $region->slug); ?>>
                                                <?php echo esc_html($region->name); ?>
                                            </label>
                                        </li>
                                    <?php endforeach;
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Country:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="country" value="" <?php checked($_GET['country'], ''); ?>>
                                            All Countries
                                        </label>
                                    </li>
                                <?php
                                // Obtener los términos de la taxonomía "country"
                                $countrys = get_terms(array(
                                    'taxonomy' => 'country',
                                    'hide_empty' => true,
                                ));
                                if (!empty($countrys) && !is_wp_error($countrys)) {
                                    foreach ($countrys as $country) : ?>
                                        <li>
                                            <label>
                                                <input type="radio"
                                                name="country"
                                                value="<?php echo esc_attr($country->slug); ?>"
                                                <?php checked($_GET['country'], $country->slug); ?>>
                                                <?php echo esc_html($country->name); ?>
                                            </label>
                                        </li>
                                    <?php endforeach;
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <div class="extra-information-group">
                            <h3 class="filter-title">Authors:</h3>
                            <div class="dropdown-filter">
                                <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="img/dropdown-arrow.svg" width="13" alt=""></a>
                                <ul class="dropdown-filter-menu">
                                    <li>
                                        <label>
                                            <input type="radio" name="author" value="" <?php checked($_GET['author'], ''); ?>>
                                            All Authors
                                        </label>
                                    </li>
                                    <?php
                                    // Obtener los autores del CPT "author-profile"
                                    $authors = get_posts(array(
                                        'post_type' => 'author-profile',
                                        'posts_per_page' => -1,
                                        'orderby' => 'title',
                                        'order' => 'ASC',
                                    ));
                                    if (!empty($authors)) {
                                        foreach ($authors as $author) : ?>
                                            <li>
                                                <label>
                                                    <input type="radio"
                                                        name="author"
                                                        value="<?php echo esc_attr($author->ID); ?>"
                                                        <?php checked($_GET['author'], $author->ID); ?>>
                                                    <?php echo esc_html($author->post_title); ?>
                                                </label>
                                            </li>
                                        <?php endforeach;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <button class="button" type="submit">Apply filters</button>
                    </form>


                    </div>
                </div>

                <div class="slider-posts search-posts">
                    <div id="no-results-message">No results have been found for your search.</div>

                    <?php
                        // Obtener los valores de los filtros
                        $research_cluster = isset($_GET['research_cluster']) ? sanitize_text_field($_GET['research_cluster']) : '';
                        $thematic_area = isset($_GET['thematic_area']) ? sanitize_text_field($_GET['thematic_area']) : '';
                        $order_by = isset($_GET['order_by']) ? sanitize_text_field($_GET['order_by']) : 'date_desc';
                        $publication_types = isset($_GET['publication_type']) ? array_map('sanitize_text_field', (array) $_GET['publication_type']) : [];
                        $published_year = isset($_GET['published_year']) ? sanitize_text_field($_GET['published_year']) : '';
                        $region_filter = isset($_GET['region']) ? sanitize_text_field($_GET['region']) : '';
                        $country_filter = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '';
                        $author_filter = isset($_GET['author']) ? sanitize_text_field($_GET['author']) : '';


                        // Configurar argumentos de la consulta
                        $args = array(
                            'post_type' => 'publication',
                            'orderby'   => 'date', // Valor por defecto
                            'order'     => 'DESC', // Valor por defecto
                        );

                        // Ordenar según el filtro seleccionado
                        switch ($order_by) {
                            case 'date_asc':
                                $args['orderby'] = 'date';
                                $args['order'] = 'ASC';
                                break;
                            case 'date_desc':
                                $args['orderby'] = 'date';
                                $args['order'] = 'DESC';
                                break;
                            case 'title_asc':
                                $args['orderby'] = 'title';
                                $args['order'] = 'ASC';
                                break;
                            case 'title_desc':
                                $args['orderby'] = 'title';
                                $args['order'] = 'DESC';
                                break;
                        }

                        // Filtro por research cluster
                        if (!empty($_GET['research_cluster'])) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'research_cluster',
                                    'field'    => 'slug',
                                    'terms'    => sanitize_text_field($_GET['research_cluster']),
                                ),
                            );
                        }

                        // Filtro por thematic area
                        if (!empty($_GET['thematic_area'])) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'topic',
                                    'field'    => 'slug',
                                    'terms'    => sanitize_text_field($_GET['thematic_area']),
                                ),
                            );
                        }

                        // Filtro por tipos de publicación
                        if (!empty($publication_types)) {
                            $args['meta_query'][] = array(
                                'key'     => 'publication_type',
                                'value'   => $publication_types,
                                'compare' => 'IN', // Permite comparar múltiples valores
                            );
                        }

                        // Filtro por año de publicación
                        if (!empty($_GET['published_year'])) {
                            $args['meta_query'][] = array(
                                'key'     => 'published_year',
                                'value'   => intval($_GET['published_year']),
                                'compare' => '=',
                                'type'    => 'NUMERIC', // Asegura que el tipo sea numérico
                            );
                        }

                        // Filtro por región
                        if (!empty($region_filter)) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'region',
                                    'field'    => 'slug',
                                    'terms'    => $region_filter,
                                ),
                            );
                        }

                        // Filtro por país
                        if (!empty($country_filter)) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'country',
                                    'field'    => 'slug',
                                    'terms'    => $country_filter,
                                ),
                            );
                        }

                        // Filtro por autor
                        if (!empty($author_filter)) {
                            $args['meta_query'][] = array(
                                'key'     => 'authors', // Asegúrate de que coincide con el nombre exacto del campo en ACF
                                'value'   => intval($author_filter), // Convertir el valor recibido en entero
                                'compare' => '='
                            );
                        }

                        // Consulta de publicaciones
                        $query = new WP_Query($args);

                        // Verificar si hay publicaciones
                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();

                            // Obtener la imagen personalizada o la por defecto
                            $card_image = get_field('card_image');

                            if (!$card_image) {
                                $card_image = get_template_directory_uri() . '/img/default-card-image.svg';
                                $is_default_image = true; // Indicador de imagen por defecto
                            } else {
                                $is_default_image = false; // Indicador de imagen personalizada
                            }

                            $publication_type = get_field('publication_type');

                            ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="post-card card">
                                <div class="card-image-container">
                                    <img class="card-image" src="<?php echo esc_url($card_image); ?>" width="200" alt="">
                                    <?php if ($is_default_image): ?>
                                        <div class="card-overlay-gradient-green-gray multiply-100"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <div class="tag white-green-tag"><?php echo esc_html($publication_type); ?></div>
                                    <p class="card-text"><?php echo esc_html(get_the_title()); ?></p>
                                </div>
                            </a>
                            <?php
                            endwhile;

                            // Restaurar los datos originales de la consulta
                            wp_reset_postdata();
                        else :
                            ?>
                            <div id="no-results-message" style="display: block;">No results have been found for your search.</div>
                    <?php endif; ?>
                </div>

            </div>

        </section>
        <!-- End News -->


        <section class="newsletter bg-gris-claro-claro">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Subscribe</h2>
                <p class="newsletter-text">Keep up to date on the latest research efforts</p>
                <form class="newsletter-form" action="">
                    <div class="column-form">
                        <label class="label-form" for="">Name</label>
                        <input class="input-form" type="text" name="name" id="name" placeholder="Your name">
                    </div>
                    <div class="column-form">
                        <label class="label-form" for="">Email</label>
                        <input class="input-form" type="email" name="email" id="email" placeholder="Your email">
                    </div>
                    <button class="button" type="submit">Subscribe</button>
                </form>
            </div>

            <img class="newsletter-image" width="250" src="<?php echo get_template_directory_uri(); ?>/img/gradient-arrow.svg" alt="">
        </section>

<?php
    get_footer();
?>