<?php
/*
Main functions.php file

@package school
 */

/* Added theme support for logo */

function school_logo()
{
    add_theme_support('custom-logo', array(
        'height' => 200,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}
add_action('after_setup_theme', 'school_logo');
//print custom logo
function school_custom_logo()
{
    if (function_exists('the_custom_logo')) {
        echo "ima logo";
        the_custom_logo();
    }
}
function school_custom_logo_custom()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (has_custom_logo()) {
        echo '<a href=' . get_site_url() . '>';
        echo '<img src="' . esc_url($logo[0]) . '" alt="logo">';
        echo '</a>';
    } else {
        echo '<h1>' . get_bloginfo('name') . '</h1>';
    }
}

/* Added theme support for post thumbnails */
add_theme_support('post-thumbnails');

/* Activate Nav Menu Option */
function school_register_nav_menu()
{
    register_nav_menu('main', 'Main Top Menu');
}
add_action('after_setup_theme', 'school_register_nav_menu');

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);

// Add a filter to remove srcset attribute from generated <img> tag
add_filter('wp_calculate_image_srcset_meta', '__return_null');

//remove surrounding p tag from content
remove_filter('the_content', 'wpautop');

//create date link in post
function school_get_date_link()
{
    $archive_year = get_the_time('Y');
    $archive_month = get_the_time('m');
    $archive_day = get_the_time('d');
    $output='<a href="' . get_day_link($archive_year, $archive_month, $archive_day) . '">' . get_the_date('Y/m/d') . '</a>';
    return $output;
}

//function for creating custom query based on category_name and number of posts
function school_custom_query($cat_name, $num){
    $args = array(
        'category_name' => $cat_name,
        'posts_per_page' => $num,
        'post_status'=>'publish'
    );
    $my_query = new WP_Query($args);
    if ( $my_query->have_posts()){
        while ( $my_query->have_posts()){
            $my_query->the_post();
            do_action('print_title');
            //get_template_part( 'content',$cat_name );
            // Post data goes here
            //the_title();
            //$output.= $templatePart;
        }
    }
    // Reset the post data to the current post in main query.
    wp_reset_postdata();
}

function school_print_title(){
    echo '<h1>'.the_title().'</h1>';
}
add_action('print_title', 'school_print_title');

