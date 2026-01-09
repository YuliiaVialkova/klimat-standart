<?php get_header(); ?>

<main>
    <h1 class="visually-hidden"><?php bloginfo('name'); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <section id="about" class="about">
                <div class="about__container container container--middle">
                    <div class="about__content">

                        <?php $sec_logo = get_field('about_logo');
                        if ($sec_logo) : ?>
                            <img src="<?php echo $sec_logo; ?>" alt="Logo Klimat Standart">
                        <?php endif; ?>

                        <h2><?php the_field('about_title'); ?></h2>

                        <div class="about__text">
                            <?php the_field('about_text'); ?>
                        </div>
                    </div>
                    <div class="about__image">

                        <?php $sec_image = get_field('about_image');
                        if ($sec_image) : ?>
                            <img src="<?php echo $sec_image; ?>" alt="image of section about">
                        <?php endif; ?>
                    </div>
                </div>
            </section>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>