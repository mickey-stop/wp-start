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
            do_action('print_title');//call school_print_title
        }
    }
    // Reset the post data to the current post in main query.
    wp_reset_postdata();
}

function school_print_title(){
    if(in_category('voce') && !(in_category('povrce'))){
        echo "<h1>Ovo je voce: ";
    }
    else if(in_category('povrce')){
        echo "<h1>Ovo je povrce: ";
    }
    echo get_the_title().'</h1>';
}
add_action('print_title', 'school_print_title');

//paginacija
function moja_paginacija($my_query,$pozdrav) {
    echo $pozdrav;
    if( is_singular() )
   	 return;

    //global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $my_query->max_num_pages <= 1 )
   	 return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $my_query->max_num_pages );

    /**    Add current page to the array */
    if ( $paged >= 1 )
   	 $links[] = $paged;

    /**    Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
   	 $links[] = $paged - 1;
   	 $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
   	 $links[] = $paged + 2;
   	 $links[] = $paged + 1;
    }

    echo '<div class="navigation"><ul>' . "\n";

    /**    Previous Post Link */
    if ( get_previous_posts_link() )
   	 printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /**    Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
   	 $class = 1 == $paged ? ' class="active"' : '';

   	 printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

   	 if ( ! in_array( 2, $links ) )
   		 echo '<li>…</li>';
    }

    /**    Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
   	 $class = $paged == $link ? ' class="active"' : '';
   	 printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /**    Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
   	 if ( ! in_array( $max - 1, $links ) )
   		 echo '<li>…</li>' . "\n";

   	 $class = $paged == $max ? ' class="active"' : '';
   	 printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /**    Next Post Link */
    if ( get_next_posts_link() )
   	 printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";
}
add_action('school_pagination','moja_paginacija',10,2);
//obavezno dodati da bi paginacija na određenoj archive ili category strani bila drugačija od one u WP podešavanjima
add_action( 'pre_get_posts',  'change_posts_number_home_page'  );
function change_posts_number_home_page( $query ) {

   if (is_category('povrce') && $query->is_main_query() && !is_admin() ) {
        $query->set( 'posts_per_page', 1 );

    return $query;
    }
}