<?php get_header(); ?>
<main>
    <section class="archive-works">
        <div class="archive-works__container container container--middle">
            <h1 class="visually-hidden">Всі наші роботи</h1>
            <div class="projects__list">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post();
                        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    ?>
                        <a href="<?php the_permalink() ?>" class="projects__link">
                            <div class="projects__image">
                                <?php if ($thumb_url) : ?>
                                    <img src="<?php echo $thumb_url; ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <h3 class="projects__name"><?php the_title(); ?></h3>
                            <p class="projects__button">Детальніше</p>
                        </a>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Роботи ще не додані.</p>
                <?php endif; ?>
            </div>
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '&laquo; Назад',
                    'next_text' => 'Вперед &raquo;',
                ));
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>