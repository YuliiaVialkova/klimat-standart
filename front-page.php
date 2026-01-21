<?php get_header(); ?>

<main>
    <h1 class="visually-hidden"><?php bloginfo('name'); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <section id="about" class="about">
                <div class="about__container container container--middle">
                    <div class="about__content">
                        <h2 class="visually-hidden">Про компанію</h2>
                        <?php
                        // === 1. ЛОГОТИП СЕКЦІЇ ===
                        // Отримуємо ID картинки через carbon_get_post_meta (бо це мета-поля поста/сторінки)
                        $logo_id = carbon_get_post_meta(get_the_ID(), 'about_logo');
                        // Перетворюємо ID на посилання
                        $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                        ?>

                        <?php if ($logo_url) : ?>
                            <img src="<?php echo $logo_url; ?>" class="about__logo" alt="Logo Klimat Standart">
                        <?php endif; ?>

                        <?php
                        // === 2. ЗАГОЛОВОК ===
                        // Замість the_field() використовуємо echo carbon_get_post_meta()
                        ?>
                        <h2 class="about__title"><?php echo carbon_get_post_meta(get_the_ID(), 'about_title'); ?></h2>

                        <?php
                        // === 3. ТЕКСТ ===
                        // Для Rich Text іноді треба додати обробку, але зазвичай echo працює
                        ?>
                        <div class="about__text">
                            <?php // Отримуємо сирий текст
                            $raw_text = carbon_get_post_meta(get_the_ID(), 'about_text');

                            // Перетворюємо відступи на параграфи <p>
                            echo wpautop($raw_text); ?>
                        </div>
                    </div>
                    <div class="about__image">
                        <?php
                        // === 4. ВЕЛИКЕ ЗОБРАЖЕННЯ ===
                        $image_id = carbon_get_post_meta(get_the_ID(), 'about_image');
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
                        ?>

                        <?php if ($image_url) : ?>
                            <img src="<?php echo $image_url; ?>" alt="image of section about">
                        <?php endif; ?>
                    </div>
                </div>

            </section>
            <section id="services" class="services">
                <div class="services__container container container--middle">
                    <div class="services__content">
                        <h2 class="visually-hidden">Послуги</h2>
                        <div class="services__standards">
                            <h3 class="visually-hidden">Стандарти роботи</h3>
                            <div class="services__list">
                                <?php echo wpautop(carbon_get_post_meta(get_the_ID(), 'service_standards')) ?>
                            </div>
                        </div>
                        <div class="services__certificates certificates">
                            <h3 class="visually-hidden">Сертифікати</h3>
                            <div class="certificates__gallery">
                                <?php
                                // 1. Отримуємо масив ВСІХ ID картинок
                                $all_cert_ids = carbon_get_post_meta(get_the_ID(), 'service_certificates');
                                if (!empty($all_cert_ids)) :
                                    // 2. Отримуємо тільки останні 4 для показу (беремо зріз масиву)
                                    // array_slice(масив, звідки почати, скільки взяти)
                                    $visible_certs = array_slice($all_cert_ids, 0, 4);
                                    // 3. Отримуємо решту (приховані)
                                    $hidden_certs = array_slice($all_cert_ids, 4);
                                    // --- ЦИКЛ 1: ВИВОДИМО ВИДИМІ СЕРТИФІКАТИ ---
                                    foreach ($visible_certs as $cert_id) :
                                        $thumb_url = wp_get_attachment_image_url($cert_id, 'medium'); // Маленька
                                        $full_url = wp_get_attachment_image_url($cert_id, 'full');   // Велика
                                ?>
                                        <a href="<?php echo $full_url; ?>" class="certificates__item glightbox" data-gallery="certificates">
                                            <img src="<?php echo $thumb_url; ?>" alt="Сертифікат">
                                        </a>
                                    <?php
                                    endforeach;
                                    // --- ЦИКЛ 2: ВИВОДИМО ПРИХОВАНІ ПОСИЛАННЯ ДЛЯ СЛАЙДЕРА ---
                                    // Вони не мають картинки всередині, тому на сторінці їх не видно,
                                    // але GLightbox знайде їх по класу та data-gallery і додає в слайдер.
                                    foreach ($hidden_certs as $cert_id) :
                                        $full_url = wp_get_attachment_image_url($cert_id, 'full');
                                    ?>
                                        <a href="<?php echo $full_url; ?>" class="glightbox visually-hidden" data-gallery="certificates"></a>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="services__directions services-directions">
                            <h3 class="visually-hidden">Напрямки діяльності</h3>
                            <div class="services-directions__list">
                                <?php
                                $directions = carbon_get_post_meta(get_the_ID(), 'service_directions');
                                if (!empty($directions)) :
                                    foreach ($directions as $item) :
                                        // Отримуємо картинку іконки
                                        $icon_url = wp_get_attachment_image_url($item['dir_icon'], 'thumbnail');
                                ?>
                                        <a href="<?php echo $item['dir_link']; ?>" class="services-directions__item scroll-item">
                                            <div class="services-directions__icon-wrapper">
                                                <?php
                                                // Отримуємо шлях до файлу на сервері
                                                $file_path = get_attached_file($item['dir_icon']);

                                                // Перевіряємо, чи це SVG і чи файл існує
                                                if (file_exists($file_path) && 'image/svg+xml' === get_post_mime_type($item['dir_icon'])) {
                                                    // Виводимо код SVG прямо в HTML
                                                    echo file_get_contents($file_path);
                                                } elseif ($icon_url) {
                                                    // Якщо це старий PNG, виводимо як раніше
                                                    echo '<img src="' . $icon_url . '" alt="' . $item['dir_title'] . '">';
                                                }
                                                ?>
                                            </div>

                                            <p class="services-directions__title"><?php echo $item['dir_title']; ?></p>
                                        </a>
                                <?php endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="products" class="products">
                <h2 class="visually-hidden">Продукція</h2>
                <div class="products__banner products-banner">
                    <div class="products-banner__container container container--middle">
                        <div class="products-banner__content">
                            <?php
                            // 1. Отримуємо ID картинок
                            $logo_id = carbon_get_post_meta(get_the_ID(), 'products_logo');
                            $banner_id = carbon_get_post_meta(get_the_ID(), 'products_banner');

                            // 2. Отримуємо посилання (URL) на картинки
                            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                            $banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : '';
                            ?>
                            <?php if ($logo_url) : ?>
                                <img src="<?php echo $logo_url; ?>" class="products-banner__logo" alt="Klimat Standart Logo">
                            <?php endif; ?>
                            <?php if ($banner_url) : ?>
                                <img src="<?php echo $banner_url; ?>" class="products-banner__bg" alt="Products Banner">
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
                <div class="products__list products-list">
                    <div class="products-list__container container container--middle">
                        <div class="product-list__content">
                            <?php
                            $prod_items = carbon_get_post_meta(get_the_ID(), 'products_items');
                            if (!empty($prod_items)) :
                                foreach ($prod_items as $item) :
                                    // Отримуємо URL звичайної картинки (про всяк випадок)
                                    $icon_url = wp_get_attachment_image_url($item['prod_icon'], 'thumbnail');
                                    // Шлях до файлу для SVG
                                    $file_path = get_attached_file($item['prod_icon']);
                            ?>
                                    <a href="<?php echo $item['prod_link']; ?>" class="products__item scroll-item">
                                        <div class="products__icon-wrapper">
                                            <?php
                                            // Логіка для SVG (як у попередній секції)
                                            if (file_exists($file_path) && 'image/svg+xml' === get_post_mime_type($item['prod_icon'])) {
                                                echo file_get_contents($file_path);
                                            } elseif ($icon_url) {
                                                echo '<img src="' . $icon_url . '" alt="' . $item['prod_title'] . '">';
                                            }
                                            ?>
                                        </div>
                                        <p class="products__title"><?php echo $item['prod_title']; ?></p>
                                    </a>
                            <?php endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <section id="projects" class="projects">
                <h2 class="visually-hidden">Наші роботи</h2>
                <div class="projects__banner projects-banner">
                    <div class="projects-banner__container container container--middle">
                        <div class="projects-banner__content">
                            <?php
                            // 1. Отримуємо ID картинок
                            $logo_id = carbon_get_post_meta(get_the_ID(), 'projects-banner_logo');
                            $banner_id = carbon_get_post_meta(get_the_ID(), 'projects-banner_img');

                            // 2. Отримуємо посилання (URL) на картинки
                            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                            $banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : '';
                            ?>
                            <?php if ($logo_url) : ?>
                                <img src="<?php echo $logo_url; ?>" class="projects-banner__logo" alt="Klimat Standart Logo">
                            <?php endif; ?>
                            <?php if ($banner_url) : ?>
                                <img src="<?php echo $banner_url; ?>" class="projects-banner__img" alt="projects banner">
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
                <div class="projects__content container container--middle">
                    <div class="projects__wrapper">
                        <div class="projects__aside projects-aside">
                            <div class="projects-aside__content">
                                <?php
                                // 1. Отримуємо ID картинок
                                $logo_id = carbon_get_post_meta(get_the_ID(), 'projects-aside_logo');
                                $banner_id = carbon_get_post_meta(get_the_ID(), 'projects-aside_img');
                                // 2. Отримуємо посилання (URL) на картинки
                                $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                                $banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : '';
                                ?>
                                <?php if ($logo_url) : ?>
                                    <img src="<?php echo $logo_url; ?>" class="projects-aside__logo" alt="Klimat Standart Logo">
                                <?php endif; ?>
                                <?php if ($banner_url) : ?>
                                    <img src="<?php echo $banner_url; ?>" class="projects-aside__img" alt="projects banner">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="projects__list">
                            <?php
                            // Робимо запит до бази даних: "Дай мені 3 останні роботи"
                            $works_query = new WP_Query(array(
                                'post_type'      => 'klimat_works',
                                'posts_per_page' => 8, // Кількість карток
                                'order'          => 'DESC',
                                'orderby'        => 'date'
                            ));
                            if ($works_query->have_posts()) :
                                while ($works_query->have_posts()) : $works_query->the_post();
                                    // Отримуємо посилання на картинку (Мініатюра запису)
                                    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            ?>
                                    <a href="<?php the_permalink(); ?>" class="projects__link">
                                        <h3 class="projects__name"><?php the_title(); ?></h3>
                                        <div class="projects__image">
                                            <?php if ($thumb_url) : ?>
                                                <img src="<?php echo $thumb_url; ?>" alt="<?php the_title(); ?>">
                                            <?php endif; ?>
                                        </div>

                                        <p class="projects__button">Детальніше</p>
                                    </a>
                            <?php
                                endwhile;
                                wp_reset_postdata(); // Обов'язково скидаємо запит після циклу!
                            else :
                                echo '<p>Роботи ще не додані.</p>';
                            endif;
                            ?>
                        </div>
                        <div class="projects__footer projects-footer">
                            <a href="<?php echo get_post_type_archive_link('klimat_works'); ?>" class="projects-footer__button">
                                Показати всі
                            </a>
                        </div>
                    </div>
                </div>
            </section>
    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>