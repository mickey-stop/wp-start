<?php /*
@package school
 */

//include header
get_header();

if (have_posts()): while (have_posts()): the_post();
        the_title();
        the_post_thumbnail('medium');
        the_content();
        echo '<div>Kategorije: ' . get_the_category_list(' ') . '</div>';
        echo '<div>Tagovi: ' . get_the_tag_list() . '</div>';
        //echo get_the_date();
        echo school_get_date_link();
    endwhile;

endif;
?>
<hr>
<?php school_custom_query('voce',3); ?>
<?php
//include footer
get_footer();
