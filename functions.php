<?php

function klimat_standart_theme_scripts()
{
    // 1. Підключаємо наш головний файл стилів (який ми зараз створимо)
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css');

    // 2. Підключаємо основний style.css (де опис теми), про всяк випадок
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

// "Вішаємо" нашу функцію на гачок WordPress, який відповідає за завантаження скриптів
add_action('wp_enqueue_scripts', 'klimat_standart_theme_scripts');

// 2. Функція для налаштування теми (меню, підтримка лого і т.д.)
function klimat_standart_theme_setup()
{
    // Реєструємо місця для меню
    register_nav_menus(array(
        'header_menu' => 'Меню в шапці',
        'footer_menu' => 'Меню в підвалі'
    ));

    // До речі, тут же зазвичай додають підтримку динамічного заголовка (title tag)
    add_theme_support('title-tag');

    // І підтримку логотипу, щоб міняти його з адмінки (на майбутнє)
    add_theme_support('custom-logo');
}
// Вішаємо на гачок налаштування теми
add_action('after_setup_theme', 'klimat_standart_theme_setup');
