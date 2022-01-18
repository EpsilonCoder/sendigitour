<?php
/**
 * Delicious Recipes Functions.
 *
 * @package Chic_Lite
 */

if( ! function_exists( 'chic_lite_recipe_category' ) ) :
/**
 * Difficulty Level.
 */
function chic_lite_recipe_category(){
    global $recipe;
    if ( ! empty( $recipe->ID ) ) : ?>
        <span class="post-cat">
            <?php the_terms( $recipe->ID, 'recipe-course', '', '', '' ); ?>
        </span>
    <?php endif;
}
endif;