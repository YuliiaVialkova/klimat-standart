<?php get_header(); ?>

<main>
    <h1 class="visually-hidden"><?php bloginfo('name'); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <section id="about" class="about">
                <div class="about__container container container--middle">
                    <div class="about__content">

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
    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>