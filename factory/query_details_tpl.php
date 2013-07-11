<?php
global $wpdb;
?>
<style scoped>
	.one-third-col{
		float: left;
		width: 30%;
		margin: 1.5%;
	}
</style>
<?php
if( isset($categories) && is_array($categories) ){
	$cats_list = implode(', ', $categories);

	$query = "SELECT * FROM categories WHERE id IN(".$cats_list.")";
	$cats = $wpdb->get_results($query);

	echo '<div class="one-third-col"><h2>Categoria: </h2>';
	echo '<ul>';
	foreach($cats as $cat){
		echo '<li>'. $cat->Categoria .'</li>';
	}
	echo '</ul></div>';
}else{ 
?>
    <div class="one-third-col">
    	<h2>No Category Selected</h2>
    </div>
<?php 
}

if( isset($subcategories) && is_array($subcategories) ){
	$subcats_list = implode(', ', $subcategories);

	$query = "SELECT * FROM subcategories WHERE id IN(".$subcats_list.")";
	$subcats = $wpdb->get_results($query);

	echo '<div class="one-third-col"><h2>SottoCategoria: </h2>';
	echo '<ul>';
	foreach($subcats as $subcat){
		echo '<li>'. $subcat->Sottocategoria .'</li>';
	}
	echo '</ul></div>';
}else{ 
?>
    <div class="one-third-col">
    	<h2>No Subcategory Selected</h2>
    </div>
<?php 
}

if( isset($regions) && is_array($regions) ){
	$regions_list = implode(', ', $regions);

	$query = "SELECT * FROM regions WHERE id IN(".$regions_list.")";
	$regions = $wpdb->get_results($query);

	echo '<div class="one-third-col"><h2>Regione: </h2>';
	echo '<ul>';
	foreach($regions as $region){
		echo '<li>'. $region->Regione .'</li>';
	}
	echo '</ul></div>';
}else{ 
?>
    <div class="one-third-col">
    	<h2>No Regione Selected</h2>
    </div>
<?php 
}

echo '<div class="clearfix"></div>';

if( isset($zones) ){
	$provinces = explode(', ', $zones);

	echo '<div class="one-third-col"><h2>Provincia: </h2>';
	echo '<ul>';
	foreach($provinces as $province){
		echo '<li>'. $province .'</li>';
	}
	echo '</ul></div>';
}else{ 
?>
    <div class="one-third-col">
    	<h2>No Provincia Selected</h2>
    </div>
<?php 
}

echo '<div class="clearfix"></div>';

/*
*/