<?php


use Carbon_Fields\Container;
use Carbon_Fields\Field;

// =========================================================================
// 1. ПІДКЛЮЧЕННЯ CARBON FIELDS
// =========================================================================

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    // Перевіряємо, чи існує файл (щоб уникнути помилок, якщо папки vendor немає)
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once(__DIR__ . '/vendor/autoload.php');
        \Carbon_Fields\Carbon_Fields::boot();
    }
}

// =========================================================================
// 2. НАЛАШТУВАННЯ ТЕМИ (Меню, Лого, Картинки)
// =========================================================================

add_action('after_setup_theme', 'klimat_standart_theme_setup');
function klimat_standart_theme_setup()
{
    // Реєструємо місця для меню
    register_nav_menus(array(
        'header_menu' => 'Меню в шапці',
        'footer_menu' => 'Меню в підвалі'
    ));

    // Динамічний заголовок вкладки браузера
    add_theme_support('title-tag');

    // Логотип, який можна міняти з адмінки
    add_theme_support('custom-logo');

    // !!! ВАЖЛИВО: Підтримка мініатюр (обкладинок) для статей блогу
    add_theme_support('post-thumbnails');
}

// =========================================================================
// 3. ПІДКЛЮЧЕННЯ СТИЛІВ ТА СКРИПТІВ
// =========================================================================

add_action('wp_enqueue_scripts', 'klimat_standart_theme_scripts');
function klimat_standart_theme_scripts()
{
    // Основний файл стилів вашої верстки
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css');

    // Стандартний style.css (обов'язковий для WP)
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

// =========================================================================
// 4. РЕЄСТРАЦІЯ ПОЛІВ CARBON FIELDS
// =========================================================================

add_action('carbon_fields_register_fields', 'crb_register_custom_fields');
function crb_register_custom_fields()
{
    // Отримуємо ID сторінки, яка встановлена як "Головна" в налаштуваннях WP
    $front_page_id = get_option('page_on_front');

    Container::make('post_meta', 'Секція Про компанію')
        // Показувати ці поля тільки на тій сторінці, яка вибрана головною
        ->where('post_id', '=', $front_page_id)

        ->add_fields(array(
            // Логотип (Зберігає ID картинки)
            Field::make('image', 'about_logo', 'Логотип'),

            // Заголовок
            Field::make('text', 'about_title', 'Заголовок'),

            // Текст (Rich Text)
            Field::make('rich_text', 'about_text', 'Текст'),

            // Велике зображення (Зберігає ID картинки)
            Field::make('image', 'about_image', 'Зображення')
        ));
}
