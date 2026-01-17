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
// Дозвіл на завантаження SVG
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
// =========================================================================
// 3. ПІДКЛЮЧЕННЯ СТИЛІВ ТА СКРИПТІВ
// =========================================================================

add_action('wp_enqueue_scripts', 'klimat_standart_theme_scripts');
function klimat_standart_theme_scripts()
{
    // 1. СТИЛІ
    // Спочатку стилі бібліотеки
    wp_enqueue_style('glightbox-css', get_template_directory_uri() . '/assets/css/glightbox.min.css');
    // Потім ваші стилі (щоб ви могли перебити їх, якщо треба)
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // 2. СКРИПТИ
    // Спочатку бібліотека
    wp_enqueue_script('glightbox-js', get_template_directory_uri() . '/assets/js/glightbox.min.js', array(), null, true);

    // ВАШ СКРИПТ
    // array('glightbox-js') - це і є професійний секрет. 
    // Це гарантує, що main.js запуститься ТІЛЬКИ ПІСЛЯ glightbox.
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array('glightbox-js'), null, true);
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

    Container::make('post_meta', 'Секція Послуги')
        // Показувати ці поля тільки на тій сторінці, яка вибрана головною
        ->where('post_id', '=', $front_page_id)

        ->add_fields(array(

            Field::make('rich_text', 'service_standards', 'Стандарти роботи (список)'),

            Field::make('media_gallery', 'service_certificates', 'Сертифікати (галерея)'),

            Field::make('complex', 'service_directions', 'Напрямки діяльності')
                ->set_layout('tabbed-horizontal') // Вигляд в адмінці
                ->add_fields(array(
                    Field::make('image', 'dir_icon', 'Іконка'),
                    Field::make('text', 'dir_title', 'Назва напрямку'),
                    Field::make('text', 'dir_link', 'Посилання (URL)'),
                ))
                ->set_header_template('<%- dir_title %>') // Щоб в адмінці було видно назву

        ));
}
