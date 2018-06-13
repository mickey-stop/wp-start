<?php /*
@package school
 */

//include header
get_header();

if (have_posts()): while (have_posts()): the_post();
        the_title();
        echo '<br>';
        the_post_thumbnail('medium');
        echo '<br>';
        the_content();
        echo '<br>';
        echo '<div>Kategorije: ' . get_the_category_list(' ') . '</div>';
        echo '<div>Tagovi: ' . get_the_tag_list() . '</div>';
        //echo get_the_date();
        echo school_get_date_link();
        echo '<hr>';
    endwhile;

endif;

echo '<br>';

/* Get all sticky posts */
$sticky = get_option('sticky_posts');

/* Sort the stickies with the newest ones at the top */
rsort($sticky);

/* Get the 5 newest stickies (change 5 for a different number) */
$sticky = array_slice($sticky, 0, 5);

/* Query sticky posts */
$query_args = array(
    'post__in' => $sticky,
    'category_name'=>'voce'
    //'category__in' => array('meals'),
);
$my_query = new WP_Query($query_args);?>
 <?php while ($my_query->have_posts()): $my_query->the_post();
    echo '<h1>sticky</h1>';
    the_title();
endwhile;
wp_reset_postdata();
?>
<hr>
<?php school_custom_query('voce', 3);?>
<?php school_custom_query('povrce', 3);?>

<?php
//include footer
get_footer();
