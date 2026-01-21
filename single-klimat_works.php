<?php get_header(); ?>

<main class="single-work">
    <div class="container container--middle">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <h1 class="single-work__title"><?php the_title(); ?></h1>

                <div class="single-work__content">
                    <?php
                    // Отримуємо блоки конструктора
                    $blocks = carbon_get_the_post_meta('work_content');

                    if (!empty($blocks)) {
                        foreach ($blocks as $block) {

                            // --- ВАРІАНТ 1: ТЕКСТ ---
                            if ($block['_type'] === 'text_block') {
                                echo '<div class="work-block work-block--text">';
                                echo wpautop($block['text_content']);
                                echo '</div>';
                            }

                            // --- ВАРІАНТ 2: ОДНЕ ФОТО ---
                            elseif ($block['_type'] === 'image_block') {
                                $img_url = wp_get_attachment_image_url($block['single_image'], 'full');
                                echo '<div class="work-block work-block--image">';
                                echo '<img src="' . $img_url . '" alt="Фото об\'єкту">';
                                echo '</div>';
                            }

                            // --- ВАРІАНТ 3: ГАЛЕРЕЯ ---
                            elseif ($block['_type'] === 'gallery_block') {
                                $gallery_ids = $block['gallery_images'];
                                echo '<div class="work-block work-block--gallery gallery-grid">';
                                foreach ($gallery_ids as $photo_id) {
                                    $photo_url = wp_get_attachment_image_url($photo_id, 'large');
                                    $full_url = wp_get_attachment_image_url($photo_id, 'full');
                    ?>
                                    <a href="<?php echo $full_url; ?>" class="glightbox" data-gallery="post-gallery">
                                        <img src="<?php echo $photo_url; ?>" alt="Галерея об'єкту">
                                    </a>
                    <?php
                                }
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>

        <?php endwhile;
        endif; ?>

    </div>
</main>

<?php get_footer(); ?>