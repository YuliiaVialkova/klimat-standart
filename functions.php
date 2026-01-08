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
