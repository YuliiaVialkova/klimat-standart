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
                    Field::make('association', 'dir_page', 'Виберіть сторінку')
                        ->set_types(array(
                            array(
                                'type'      => 'post',
                                'post_type' => 'page', // Дозволяємо вибирати тільки Сторінки
                            )
                        ))
                        ->set_max(1), // Можна вибрати тільки одну сторінку
                ))
                ->set_header_template('<%- dir_title %>') // Щоб в адмінці було видно назву

        ));
    Container::make('post_meta', 'Секція Продукція')
        // Показувати ці поля тільки на тій сторінці, яка вибрана головною
        ->where('post_id', '=', $front_page_id)

        ->add_fields(array(
            Field::make('image', 'products_logo', 'Логотип'),

            Field::make('image', 'products_banner', 'баннер секції Продукція'),

            Field::make('complex', 'products_items', 'Види продукції')
                ->set_layout('tabbed-horizontal') // Вигляд в адмінці
                ->add_fields(array(
                    Field::make('image', 'prod_icon', 'Іконка'),
                    Field::make('text', 'prod_title', 'Назва напрямку'),
                    Field::make('text', 'prod_link', 'Посилання (URL)'),
                ))
                ->set_header_template('<%- prod_title %>') // Щоб в адмінці було видно назву

        ));



    Container::make('post_meta', 'Секція Наші Роботи (Банери)')
        ->where('post_id', '=', $front_page_id)
        ->add_fields(array(
            // Банер зверху
            Field::make('image', 'projects-banner_logo', 'Верхній банер: Лого'),
            Field::make('image', 'projects-banner_img', 'Верхній банер: Фон'),

            // Банер збоку (Aside)
            Field::make('image', 'projects-aside_logo', 'Боковий банер: Лого'),
            Field::make('image', 'projects-aside_img', 'Боковий банер: Фон'),
        ));
}
// =========================================================================
// 5 Реєстрація типу запису "Наші роботи"
// =========================================================================

add_action('init', 'register_works_post_type');
function register_works_post_type()
{
    register_post_type('klimat_works', array(
        'labels' => array(
            'name'               => 'Наші роботи', // Назва в меню
            'singular_name'      => 'Об\'єкт',
            'add_new'            => 'Додати об\'єкт',
            'add_new_item'       => 'Додати новий об\'єкт',
            'edit_item'          => 'Редагувати об\'єкт',
            'new_item'           => 'Новий об\'єкт',
            'view_item'          => 'Переглянути об\'єкт',
            'search_items'       => 'Шукати об\'єкти',
            'not_found'          => 'Об\'єктів не знайдено',
        ),
        'public'             => true, // Доступний публічно
        'has_archive'        => true, // Можна виводити список
        'menu_icon'          => 'dashicons-building', // Іконка будинку
        'supports'           => array('title', 'thumbnail'), // Підтримка: Заголовок, Мініатюра (головне фото)
        'rewrite'            => array('slug' => 'projects'), // Частина URL: site.com/projects/nazva
    ));
}
add_action('carbon_fields_register_fields', 'crb_register_works_fields');
function crb_register_works_fields()
{
    Container::make('post_meta', 'Конструктор сторінки')
        ->where('post_type', '=', 'klimat_works') // Показувати ТІЛЬКИ в "Наші роботи"
        ->or_where('post_type', '=', 'page')      // <--- ДОДАЛИ: Для звичайних сторінок

        ->add_fields(array(
            Field::make('complex', 'work_content', 'Вміст сторінки')
                ->set_layout('tabbed-vertical')

                // Блок 1: Просто текст
                ->add_fields('text_block', 'Текстовий блок', array(
                    Field::make('rich_text', 'text_content', 'Текст')
                ))

                // Блок 2: Одне велике зображення
                ->add_fields('image_block', 'Одне фото', array(
                    Field::make('image', 'single_image', 'Зображення')
                ))

                // Блок 3: Галерея (багато картинок)
                ->add_fields('gallery_block', 'Галерея', array(
                    Field::make('media_gallery', 'gallery_images', 'Фотографії')
                ))
        ));
}
// =========================================================================
// 6. ГЛОБАЛЬНІ НАЛАШТУВАННЯ ТЕМИ (Футер, Контакти)
// =========================================================================

add_action('carbon_fields_register_fields', 'crb_register_theme_options');
function crb_register_theme_options()
{
    // Тут ми прибрали \Carbon_Fields\ перед Container, бо він підключений зверху
    Container::make('theme_options', 'Налаштування сайту')
        ->add_fields(array(
            // І тут прибрали перед Field
            Field::make('rich_text', 'footer_address', 'Адреса (Текст)'),
            Field::make('text', 'footer_phone', 'Телефон'),
            Field::make('text', 'footer_email', 'Email'),
            Field::make('image', 'footer_logo', 'Логотип у футері'),
            Field::make('textarea', 'footer_map', 'Код карти Google (Iframe)')
                ->set_attribute('placeholder', 'Вставте сюди код <iframe>...'),
        ));
}
