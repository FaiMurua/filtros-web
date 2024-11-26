<?php
    /* Template Name: Search */
    get_header();
?>

    <!-- Section Intro -->
    <section class="section-intro">
        <div class="section-intro-info">
            <h1 class="section-intro-title">Search</h1>
            <p class="section-intro-text"><?php printf('Results for: <strong>%s</strong>', get_search_query()); ?></p>
        </div>
        <img class="section-intro-image" src="<?php echo get_template_directory_uri(); ?>/img/gradient-arrow.svg" width="50" alt="">
        <div class="section-intro-bar solid-gradient-bg"></div>
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
                    <div class="extra-information-group">
                        <h3 class="filter-title">Single choice:</h3>
                        <div class="dropdown-filter">
                            <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="<?php echo get_template_directory_uri(); ?>/img/dropdown-arrow.svg" width="13" alt=""></a>
                            <ul class="dropdown-filter-menu">
                                <li>
                                    <label for="option-1-a">
                                        <input type="radio" name="region" class="filter-checkbox" id="option-1-a" value="option-1"> Option 1
                                    </label>
                                </li>
                                <li>
                                    <label for="option-2-a">
                                        <input type="radio" name="region" class="filter-checkbox" id="option-2-a" value="option-2"> Option 2
                                    </label>
                                </li>
                                <li>
                                    <label for="option-3-a">
                                        <input type="radio" name="region" class="filter-checkbox" id="option-3-a" value="option-3"> Option 3
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="extra-information-group">
                        <h3 class="filter-title">Multiple choice:</h3>
                        <div class="dropdown-filter">
                            <a class="tag white-gray-tag filter-option-text border-bottom">All <img class="dropdown-arrow" src="<?php echo get_template_directory_uri(); ?>/img/dropdown-arrow.svg" width="13" alt=""></a>
                            <ul class="dropdown-filter-menu">
                                <li>
                                    <label for="option-1-b">
                                        <input type="checkbox" class="filter-checkbox" id="option-1-b" value="Option 1"> Option 1
                                    </label>
                                </li>
                                <li>
                                    <label for="option-2-b">
                                        <input type="checkbox" class="filter-checkbox" id="option-2-b" value="Option 2"> Option 2
                                    </label>
                                </li>
                                <li>
                                    <label for="option-3-b">
                                        <input type="checkbox" class="filter-checkbox" id="option-3-b" value="Option 3"> Option 3
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-posts search-posts">
                <?php
                // Verificar si hay publicaciones en la consulta principal
                if (have_posts()) :
                    while (have_posts()) : the_post();

                        // Obtener el tipo de post
                        $post_type = get_post_type();

                        // Configurar valores específicos por tipo de post
                        switch ($post_type) {
                            case 'publication':
                                $overlay_class = 'card-overlay-gradient-green-gray multiply-100';
                                $tag_class = 'tag white-green-tag';
                                $tag_text = get_field('publication_type');
                                break;
                            case 'project':
                                $overlay_class = 'card-overlay-gradient-blue-gray multiply-100';
                                $tag_class = 'tag white-blue-tag';
                                $tag_text = 'Project';
                                break;
                            case 'news-post':
                                $overlay_class = 'card-overlay-gradient-yellow multiply-100';
                                $tag_class = 'tag white-yellow-tag';
                                $tag_text = 'News';
                                break;
                            default:
                                $overlay_class = '';
                                $tag_class = '';
                                $tag_text = '';
                        }

                        // Obtener la imagen o usar imagen por defecto
                        $card_image = get_field('card_image');
                        if (!$card_image) {
                            $card_image = get_template_directory_uri() . '/img/default-card-image.svg';
                            $is_default_image = true;
                        } else {
                            $is_default_image = false;
                        }
                        ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="post-card card">
                            <div class="card-image-container">
                                <img class="card-image" src="<?php echo esc_url($card_image); ?>" width="200" alt="">
                                <?php if ($is_default_image): ?>
                                    <div class="<?php echo esc_attr($overlay_class); ?>"></div>
                                <?php endif; ?>
                            </div>
                            <div class="card-content">
                                <div class="<?php echo esc_attr($tag_class); ?>"><?php echo esc_html($tag_text); ?></div>
                                <p class="card-text"><?php echo esc_html(get_the_title()); ?></p>
                            </div>
                        </a>
                        <?php
                    endwhile;

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

        <img class="newsletter-image" width="250" src="<?php echo get_template_directory_uri(); ?>/img/pc-mockup.png" alt="">
    </section>

<?php get_footer(); ?>
