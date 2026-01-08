<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="header">
        <div class="header__container container container--middle">
            <div class="header__inner">
                <div class="header__logo logo">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo Klimat Standart">
                    </a>
                </div>

                <nav class="header__menu main-menu">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'header_menu', // Має співпадати з назвою в functions.php
                        'container'      => false,         // Не створювати зайвих обгорток div
                        'menu_class'     => 'main-menu__list',            // Клас для тегу <ul>, якщо треба (поки пустий)
                        'fallback_cb'    => '__return_false', // Якщо меню не створено, нічого не виводити
                    ]);
                    ?>
                </nav>

            </div>
        </div>
    </header>