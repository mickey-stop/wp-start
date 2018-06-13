<?php

if (is_single()) {
    $cats = get_the_category();
    $cat = $cats[0]; // let's just assume the post has one category
} else { // category archives
    $cat = get_category(get_query_var('cat'));
}
$cat_id = $cat->cat_ID;
$cat_name = $cat->name;
$cat_slug = $cat->slug;
echo '<h1>' . $cat_name . '</h1><hr>';

//get sticky post
/* Get all sticky posts */
$sticky = get_option('sticky_posts');
/* Sort the stickies with the newest ones at the top */
rsort($sticky);

/* Get the 2 newest stickies (change 2 for a different number) */
$sticky = array_slice($sticky, 0, 2);
/* Query sticky posts */
$query_args = array(
    'post__in' => $sticky,
    //'posts_per_page'=> 2,
    'ignore_sticky_posts' => 1,
    'category_name'=>$cat_name,
    //'category__in' => array('meals'),
);
$my_query = new WP_Query($query_args);?>
 <?php while ($my_query->have_posts()): $my_query->the_post();
    echo '<br>Sticky početak';
    echo '<h1>' . get_the_title() . '</h1>';
    echo get_the_date('Y/m/d \a\t g:ia');
    echo '<br>Sticky kraj';
endwhile;
wp_reset_postdata();
?>
<?php
//get ordinary post
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$args = array(
    'category_name' => $cat_name,
    'ignore_sticky_posts' => 1,
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'post__not_in'=>$sticky,
    'paged'=>$paged
);
$my_query2 = new WP_Query($args);
if ($my_query2->have_posts()) {
    while ($my_query2->have_posts()) {
        $my_query2->the_post();
        // Post data goes here
        echo '<br>Običan početak';
        echo '<h1>' . get_the_title() . '</h1>';
        echo get_the_date('Y/m/d \a\t g:ia');
        echo '<br>Običan kraj';
    }
}
// Reset the post data to the current post in main query.
wp_reset_postdata();
do_action('school_pagination',$my_query2, '<h1>Pozdrav iz do_action</h1>');