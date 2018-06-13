<?php
/*
This is the template for the hedaer

@package school
 */
?>

<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="<?php bloginfo('charset');?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url');?>">
<title>
    <?php if(is_front_page() || is_home()){
        echo get_bloginfo('name');
    } else{
        echo wp_title('').' | '.get_bloginfo('name');
    }?>
</title>
<!-- Added icon -->
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
<link rel="icon" href="<?php echo get_stylesheet_directory_uri().'/favicon.ico'?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri().'/favicon.ico'?>" type="image/x-icon" />	
<?php endif; ?>
<?php wp_head();?>
</head>
<body>
<?php echo get_theme_mod( 'site_favicon' ); ?>
<div class="my-menu">
    <?php
        wp_nav_menu( array(
            'menu'=>'main',
            'container'=>'',
            'menu_id'=>'menu-items-container'
        ) ) ;
    ?>
</div>
<?php school_custom_logo(); ?>
<?php school_custom_logo_custom(); ?>
