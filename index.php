<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content"><?php the_excerpt(); ?></div>
        </article>
        <?php
    endwhile;
else :
    echo '<p>' . esc_html__( 'No content found.', 'personal-site' ) . '</p>';
endif;

get_footer();
