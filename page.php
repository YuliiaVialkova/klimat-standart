<?php get_header(); ?>

<main class="default-page single-work">
    <div class="container container--middle">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <article class="default-page__wrapper">

                    <h1 class="default-page__title single-work__title"><?php the_title(); ?></h1>

                    <div class="default-page__content single-work__content">
                        <?php
                        // 1. СПРОБУЄМО ОТРИМАТИ БЛОКИ КОНСТРУКТОРА
                        $blocks = carbon_get_the_post_meta('work_content');

                        // === ВАРІАНТ А: ЯКЩО Є КОНСТРУКТОР (Виводимо як Об'єкт) ===
                        if (!empty($blocks)) {
                            foreach ($blocks as $block) {

                                // Блок ТЕКСТ
                                if ($block['_type'] === 'text_block') {
                                    echo '<div class="work-block work-block--text">';
                                    echo wpautop($block['text_content']);
                                    echo '</div>';
                                }

                                // Блок ОДНЕ ФОТО
                                elseif ($block['_type'] === 'image_block') {
                                    $img_url = wp_get_attachment_image_url($block['single_image'], 'full');
                                    echo '<div class="work-block work-block--image">';
                                    echo '<img src="' . $img_url . '" alt="Фото">';
                                    echo '</div>';
                                }

                                // Блок ГАЛЕРЕЯ (СІТКА)
                                elseif ($block['_type'] === 'gallery_block') {
                                    $gallery_ids = $block['gallery_images'];
                                    echo '<div class="work-block work-block--gallery gallery-grid">';
                                    foreach ($gallery_ids as $photo_id) {
                                        $photo_url = wp_get_attachment_image_url($photo_id, 'large');
                                        $full_url = wp_get_attachment_image_url($photo_id, 'full');
                        ?>
                                        <a href="<?php echo $full_url; ?>" class="glightbox" data-gallery="page-builder-gallery">
                                            <img src="<?php echo $photo_url; ?>" alt="Галерея">
                                        </a>
                                    <?php
                                    }
                                    echo '</div>';
                                }
                            }
                        }

                        // === ВАРІАНТ Б: ЯКЩО КОНСТРУКТОР ПУСТИЙ (Стандартний вивід) ===
                        else {
                            // Виводимо звичайний текст з редактора
                            the_content();

                            // Виводимо ту "розумну галерею" (слайдер), яку ми робили раніше
                            // Це на випадок, якщо ви не захочете користуватися конструктором на якійсь сторінці
                            $gallery_ids = carbon_get_post_meta(get_the_ID(), 'page_gallery');

                            if (!empty($gallery_ids)) :
                                $count = count($gallery_ids);
                                if ($count === 1) :
                                    $img_id = $gallery_ids[0];
                                    $show_url = wp_get_attachment_image_url($img_id, 'large');
                                    echo '<div class="default-page__image"><img src="' . $show_url . '"></div>';
                                else :
                                    ?>
                                    <div class="default-page__slider">
                                        <div class="default-page__slider-wrapper">
                                            <?php foreach ($gallery_ids as $img_id) :
                                                $thumb_url = wp_get_attachment_image_url($img_id, 'medium_large');
                                            ?>
                                                <div class="default-page__slider-item">
                                                    <img src="<?php echo $thumb_url; ?>" alt="Gallery">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="default-page__hint"><small>Гортайте вбік →</small></p>
                                    </div>
                        <?php
                                endif;
                            endif;
                        }
                        ?>
                    </div>

                </article>

        <?php endwhile;
        endif; ?>

    </div>
</main>

<?php get_footer(); ?>