<?php
/**
 * The template for displaying Archive pages.
 */
?>
<?php get_header(); ?>

	<?php 
		if ( have_posts() ) : 
			while ( have_posts() ) : 
				the_post(); 
	?>
	

	<?php endwhile; ?>

	<?php else : ?>

	<?php endif; ?>

<?php get_footer(); ?>