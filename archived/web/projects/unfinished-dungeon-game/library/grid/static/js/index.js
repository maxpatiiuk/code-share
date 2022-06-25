const body = $('body');
const grid = body.find('#grid');
const grid_styles = $('#grid_styles');

let previous_height = 0;

//width horizontal cols left right
//height vertical rows top bottom

function generate_cell(cell_data=[]){

	let result = '<dt';

	if(cell_data.length>0){

		result += ' class="'+cell_data+'"';

		// if(typeof cell_data[0] === 'function')
		// 	result += ' style="background: '+cell_data[0]()+'"';
		// else
		// 	result += ' style="background: '+cell_data[0]+'"';

		// if(typeof cell_data[0] !== "undefined")
		// 	result += ' class="'+cell_data[0]+'"';

	}

	result += '></dt>';
	return result;

}

function ceil_to_nearest_odd(number){

	let result = Math.ceil(number);

	if(result%2===0)
		result++;

	return result;

}

let cell_size;
function draw_grid(){

	const width = window.innerWidth;
	const height = window.innerHeight;

	if(height!==previous_height){

		if(vertical_tiles%2===0)
			vertical_tiles--;

		cell_size = height/vertical_tiles;

		grid_styles.text(`dl,#player { height: `+cell_size+`px }
			dt,#player { width: `+cell_size+`px }
			:root { --cell_size: `+cell_size+`px; --speed: `+movement_speed+`s }`);

		previous_height = height;

	}

	let visible_horizontal_tiles = width/cell_size;
	let horizontal_tiles = ceil_to_nearest_odd(visible_horizontal_tiles);

	const defined_rows = grid_layout.length;
	const defined_cols = grid_layout[0].length;

	let dataset_horizontal_offset;
	if(typeof position_horizontal==="undefined" || position_horizontal===false) {
		dataset_horizontal_offset = Math.floor( defined_cols / 2 );
		position_horizontal = dataset_horizontal_offset;
	}
	else
		dataset_horizontal_offset = position_horizontal;

	let dataset_vertical_offset;
	if(typeof position_vertical==="undefined" || position_vertical===false){
		dataset_vertical_offset = Math.floor(defined_rows/2);
		position_vertical = dataset_horizontal_offset;
	}
	else
		dataset_vertical_offset = position_vertical;


	let grid_horizontal_offset = Math.floor(horizontal_tiles/2);
	let grid_vertical_offset = Math.floor(vertical_tiles/2);

	let net_horizontal_offset = grid_horizontal_offset - dataset_horizontal_offset;
	let net_vertical_offset = grid_vertical_offset - dataset_vertical_offset;

	let result = '';
	for(let i=0;i<(vertical_tiles+2);i++){

		result += '<dl>';

		let dataset_position_vertical = i-net_vertical_offset;
		if(dataset_position_vertical>=0 && dataset_position_vertical<defined_rows)
			for(let ii=0;ii<(horizontal_tiles+2);ii++){

				let dataset_position_horizontal = ii-net_horizontal_offset;

				if(dataset_position_horizontal>=0 && dataset_position_horizontal<defined_cols)
					result += generate_cell(grid_layout[dataset_position_vertical][dataset_position_horizontal]);
				else
					result += generate_cell(empty_cell_params);

			}
		else
			result += generate_cell(empty_cell_params).repeat(horizontal_tiles+2);

		result += '</dl>';

	}

	grid.html(result);
	grid_styles.append('dl{width: '+((horizontal_tiles+2)*cell_size)+'px}');


}
window.onresize = draw_grid;
draw_grid();


let in_movement = false;
function move(direction){

	grid.addClass('go_'+direction);

	in_movement = true;
	setTimeout(function(){

		in_movement = false;
		grid.removeClass('go_'+direction);
		draw_grid();

	},movement_speed*1000);

}

document.onkeydown = function (e) {
	e = e || window.event;

	//TODO: allow for both directions at once
	//TODO: add controller support
	//TODO: use mouse for direction of breaking

	if(e.which===38 || e.which===87){ //up
		position_vertical--;
		move('up');
	}
	else if(e.which===37 || e.which===65){ //right
		position_horizontal--;
		move('right');
	}
	else if(e.which===39 || e.which===68){ // left
		position_horizontal++;
		move('left');
	}
	else if(e.which===40 || e.which===83){ // down
		position_vertical++;
		move('down');
	}
};


// $(document).on("keypress", function (e) {
// 	console.log(e.which);
// });