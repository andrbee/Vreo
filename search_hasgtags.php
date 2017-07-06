<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/pluggable.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );

global $wpdb;
$term = strtolower( $_GET['term'] );

$term=explode(',', $term);
$count=count($term);
if($count>=2){
//    print_r($term);
    $term=$term[$count-1];
} else {
    $term=$term[0];
}

//$newtable = (array)$wpdb->get_results( "SELECT DISTINCT slug FROM wp_terms WHERE slug LIKE '".$term."%';",OBJECT_K  );
$args = array(
    'number'        => 0,
    'name__like'   => "#".$term
);
$tags = get_tags($args);
$s=array();
foreach ($tags as $tag) {
    $s[]=$tag->slug;
}



echo json_encode($s);
?>
