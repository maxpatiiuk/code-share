<?php

const CSS = 'main';
const JS = 'main';
require_once ('components/header.php');
require_once ('library/grid/body.php');

$grid_rows = 100;
$grid_cols = 100;
$grid = [];
$tiles = ['grass','sand','stone'];
$tiles_variations = ['dark','regular','light'];

for($i = 0; $i < $grid_rows; $i++){

	$row = [];
	for($ii=0;$ii<$grid_cols;$ii++){

		$tile = $tiles[rand(0,count($tiles)-1)];
		//$variation = $tiles_variations[rand(0,count($tiles_variations)-1)];
		//$row[] = $tile.' '.$variation;
		$row[] = $tile;

	}

	$grid[] = $row;

} ?>


<script>
	let grid_width = 100;
	let grid_height = 100;
	let grid_layout = JSON.parse('<?=json_encode($grid)?>');

	let vertical_tiles = 31;
	let position_horizontal = false;
	let position_vertical = false;
	//let empty_cell_params = ['#0f0',];
	//let empty_cell_params = [random_color];
	let empty_cell_params = [];
	let refresh_empty_cell = true;
	let movement_speed = 0.1;
</script> <?php


require_once ('components/footer.php');