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

                </div>
            </section>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>