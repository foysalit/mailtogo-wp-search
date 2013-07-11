<?php
	/*half column shortcode*/
	add_shortcode("half-col", "half_col_style");
	
	function half_col_style($atts, $cont){
		$pos = (isset($atts['pos']) && !empty($atts['pos'])) ? $atts['pos'] : "left";
		
		return '<div class="half group '.$pos.'">'.do_shortcode($cont).'</div>';
	}
?>