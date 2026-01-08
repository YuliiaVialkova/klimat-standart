<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="header">
        <div class="container">
            <div class="header__inner">
                <div class="logo">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo">
                    </a>
                </div>

                <nav class="main-menu">
                    <ul>
                        <li><a href="#">Головна</a></li>
                        <li><a href="#">Каталог</a></li>
                        <li><a href="#">Про нас</a></li>
                        <li><a href="#">Контакти</a></li>
                    </ul>
                </nav>

            </div>
        </div>
    </header>