<?php

require_once __DIR__ . '/Test_Menu.php';

function test_scripts() {
    wp_enqueue_style('test-bootsrapcss', // test-bootrap - индефикатор а не название файла! 
    get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css'
    );

    wp_enqueue_style('test-style',  get_stylesheet_uri());

    //wp_enqueue_script('jquery'); // рабочий кюери из комплекта вп

    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', [], null, false);
    wp_enqueue_script('jquery');

    wp_enqueue_script('test-popper', 
    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['jquery'], null, false);

    wp_enqueue_script('test-bootrrapjs', 
    get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js',  ['jquery'], null, false);
}

add_action('wp_enqueue_scripts', 'test_scripts');


// отключение нового дизайна эдитора
add_filter( 'use_block_editor_for_post_type', '__return_false' );

// подключение миниатюр
function test_setup() {
    add_theme_support( 'post-thumbnails' );

    add_image_size('some', 50 ,50);

    add_theme_support( 'title-tag' ); // замена и автовывод тегов title для каждой страницы

    add_theme_support( 'custom-logo', [
        'width' => 150,
        'height' => 40,
    ]); // добавление логотипа в костюмайзера

    add_theme_support( 'custom-background', [
        'default-color' => 'ffffff',
        'default-image' => get_template_directory_uri() . '/assets/image/123.png',
    ]); // смена бекграунда страницы из кастюмайзера

    add_theme_support( 'custom-header', [
        'default-image' => '',
        'width' => 150,
        'height' => 40,
    ]); // кастюмайзер хедера (цвет и или изображение)

    register_nav_menus([
        'header-menu' => __('Меню хедер1', 'test'),
        'footer-menu' => __('Меню футер2', 'test'),
    ]); // регистрация меню

    // Добавление локализации и поддержки перевода
    load_theme_textdomain('test', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'test_setup');

//изменение дефолтной пагинации - уибарение h2 тега
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );

function my_navigation_template( $template, $class ){
	return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>    
	';
}


// сайдбары

function test_widgets_init() {
    register_sidebar([
        'name' =>  __('Сайдбар справа', 'test'), // имя сайдбара
        'id' => 'right-sidbar', // индекс по которому можно вызывать сайдбар
        'description' => 'some',
    ]);
}
add_action('widgets_init', 'test_widgets_init');


/////// Кастомныей кастюмайзер (добавление в уже существующие секции)

function test_customize_register($wp_customize) {
    $wp_customize->add_setting('test_link_color', [
        'default-color' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color', // ф-я с помощью которой можно что-то провалидировать
        'transport'=>'postMessage', // настройка асинхронности
    ]); // добавлении возможности изменения цвета ссылок

    $wp_customize->add_control(new WP_Customize_Color_Control( // класс который это все добавит
        $wp_customize,
        'test_link_color',     // ид того что нужно добавить
        array(
            'label' => __('Цвет ссылок', 'test'), 
            'section' => 'colors',      // в какую секцию добавится настройка
            'setting' => 'test_link_color', // ид настройки что нужно добавить
        )                        // её настройки .. подпись и секция в которую нужно добавить
    ));

    // создание кастомной секции
    $wp_customize->add_section( 'test_site_data' , array(
        'title'      =>  __('Информация сайта', 'test'),
        'priority'   => 10,
    ) );

    $wp_customize->add_setting('test_phone', [
        'default' => '',
        'transport'=>'postMessage', 
    ]); 

    $wp_customize->add_control('test_phone',   
        array(
            'label' => __('Телефон', 'test'), 
            'section' => 'test_site_data',      
            'type' => 'text', // инпат
        )                    
    );

    $wp_customize->add_setting('test_show_phone', [
        'default' => true, // значит что это чекбокс
        'transport'=>'postMessage', 
    ]); 

    $wp_customize->add_control('test_show_phone',   
        array(
            'label' => __('Показывать телефон','test'), 
            'section' => 'test_site_data',      
            'type' => 'checkbox', 
        )                    
    );
}
add_action( 'customize_register', 'test_customize_register' );

// добавление самого стиля
function test_customize_css()
{
    ?>
         <style type="text/css">
             a { color: <?php echo get_theme_mod('test_link_color'); ?>; }
         </style>
    <?php
}
add_action( 'wp_head', 'test_customize_css');

// асинхронность для своих настроек

function test_customize_js() {
    wp_enqueue_script('test-customize', 
    get_template_directory_uri() . '/assets/js/test-customize.js', ['jquery','customize-preview'], 
    null, true);
}

add_action('customize_preview_init', 'test_customize_js');



