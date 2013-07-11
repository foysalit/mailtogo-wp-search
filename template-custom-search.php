<?php
/*
Template name: Custom Search
*/
?>
<?php get_header(); ?>
<?php global $woo_options; ?>
       
    <div id="content" class="page col-full">
        <div id="main" class="col-left">
                   
        <?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
            <?php woo_breadcrumbs(); ?>  
        <?php } ?>              

        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <div <?php post_class(); ?>>

                <h1 class="title"><?php the_title(); ?></h1>

                <div class="entry">
                    <?php the_content(); ?>

                    
                    <div class="full-wrapper">
                        <div class="progress-wrapper">
                            <div class="prg-line"></div>
                            <div class="prg-line notifier"></div>

                            <ul class="prg-circles-wrapper group">
                                <li class="prg-circle" data-level="1">1</li>
                                <li class="prg-circle" data-level="2">2</li>
                                <li class="prg-circle" data-level="3">3</li>
                            </ul>
                            
                        </div>
                        <div class="form-filters-wrapper group">
                            <div class="form-filter centered" data-item="categories"></div>
                            <div class="form-filter on-right"></div>
                        </div>
                    </div>

                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
                </div><!-- /.entry -->

                <?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
                
            </div><!-- /.post -->
            
            <?php $comm = $woo_options[ 'woo_comments' ]; if ( ($comm == "page" || $comm == "both") ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
                                                
        <?php endwhile; else: ?>
            <div <?php post_class(); ?>>
                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ) ?></p>
            </div><!-- /.post -->
        <?php endif; ?>  
        
        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
        
<?php get_footer(); ?>