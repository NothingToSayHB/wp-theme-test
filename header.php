<!doctype html>
<html lang="en">
  <head>
    <meta charset="<?php echo bloginfo('charset')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head();?>
  </head>
  <body <?php body_class();?>>
  <?php if(get_custom_header()->url && is_front_page()):?>
    <div class="header-image" style="background: url(<?php echo get_custom_header()->url;?>) center no-repeat; height: 50vh; background-size: cover;"></div>
  <?php endif;?> 
  <div class="wrapper">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <?php if (has_custom_logo()):?>
    <a href="<?php echo home_url();?>"><?php the_custom_logo();?></a>
  <?php else:?>
    <a class="navbar-brand" href="<?php echo home_url()?>"><?php echo bloginfo('name')?></a>
  <?php endif;?>
  <span><?php echo bloginfo('description')?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <?php wp_nav_menu([
    'theme_location'  => 'header-menu',
    'container' => '',
    'menu_class'      => 'navbar-nav mr-auto',
    'container_id' => 'navbarSupportedContent', 
    'walker' => new Test_Menu(),
    ]);?>
    <p class="test-phone"<?php if(false === get_theme_mod('test_show_phone')){echo "style='display:none;'";}?>>
    Телефон:<span><?php echo get_theme_mod('test_phone');?></span>
    </p>
    </div>
</nav>