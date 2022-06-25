let use_datalists = false;

window.onload = function () {
	let last_class_change = 0;
	use_datalists = category_field.is( "input" );

	class_field.change( function () {//optimizing ajax function call
		current_class = class_field.val();
		let defined = typeof sorting_data[ current_class ] !== "undefined";

		if ( ! defined )
			class_updated( current_class, false );

		else if ( last_class_change !== 0 && Date.now() - last_class_change < 1 ) {
			let interval = setInterval( function () {
				if ( Date.now() - last_class_change > 1 ) {
					clearInterval( interval );
					class_updated( current_class, false );
				}
			}, 250 );
		} else {
			last_class_change = Date.now();
			class_updated( current_class, true );
		}
	} );

	category_field.change( function () {
		let current_category = category_field.val();

		if ( use_datalists ) {
			let datalist = $( "#" + theme_field.attr( "list" ) );
			$.each( sorting_data[ current_class ], function ( category_id, category_data ) {
				if ( category_data[ "name" ] === current_category ) {
					current_category = category_id;
					return false;
				}
			} );
			datalist.find( "option:not(:first-child)" ).remove();
			$.each( sorting_data[ current_class ][ current_category ], function ( theme_id, theme_name ) {
				if ( theme_id !== "name" )
					datalist.append( "<option>" + theme_name + "</option>" );
			} );
		} else {
			theme_field.find( "option:not([value=\"-1\"])" ).remove();
			$.each( sorting_data[ current_class ][ current_category ], function ( theme_id, theme_name ) {
				if ( theme_id !== "name" )
					theme_field.append( "<option value=\"" + theme_id + "\">" + theme_name + "</option>" );
			} );
		}
	} );

};

function class_updated( class_value, defined ) {

	current_class = class_value;

	if ( ! defined ) {

		if ( ! navigator.onLine ) {
			alert( text[ "no_internet" ] );
			return false;
		}

		$.ajax( {
			method : "POST",
			url : site_url + "post/get/categories/" + class_value,
		} ).done( function ( msg ) {
			msg = JSON.parse( msg );
			if ( msg.error !== 0 && msg.error !== "0" ) {
				alert( text[ "error_while_getting_data" ] );
				mail_error( "Unable to get categories. Ajax failed", [ msg, class_value, sorting_data ] );
			} else {
				delete msg.error;
				sorting_data[ class_value ] = msg;
				category_change();
			}
		} );
	} else
		category_change();

}

function category_change() {
	if ( use_datalists ) {
		let datalist = $( "#" + category_field.attr( "list" ) );
		datalist.find( "option:not(:first-child)" ).remove();
		$( "#" + theme_field.attr( "list" ) + " option:not(:first-child)" ).remove();

		$.each( sorting_data[ current_class ], function ( category_id, category_data ) {
			datalist.append( "<option>" + category_data[ "name" ] + "</option>" );
		} );
	} else {
		category_field.find( "option:not([value=\"-1\"])" ).remove();
		theme_field.find( "option:not([value=\"-1\"])" ).remove();
		$.each( sorting_data[ current_class ], function ( category_id, category_data ) {
			category_field.append( "<option value=\"" + category_id + "\">" + category_data[ "name" ] + "</option>" );
		} );
	}

}