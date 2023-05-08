let needCaptcha = true;

let html_keys = [ "&amp;", "&#038;", "&lt;", "&gt;", "&quot;", "&#039;" ];
let html_values = [ "&", "&", "<", ">", "\"", "'" ];

let zoomable = $( "#zoomable" );
let zoomable_used = false;
let modal_container = $( "#modal" );
let body = $( "body" );
let modal_edit_obj = null;

let supports_drag_and_drop = function () {
	let div = document.createElement( "div" );
	return ( ( "draggable" in div ) || ( "ondragstart" in div && "ondrop" in div ) ) && "FormData" in window && "FileReader" in window;
}();
let is_touch_device = is_touch_device_func();
let is_mobile_phone = /Android|webOS|iPhone|iPad|iPod|IEMobile|Opera Mini/i.test( navigator.userAgent );

function htmlspecialchars( text ) {
	return text.replace( /[&<>"']/g, function ( m ) {
		return html_keys[ html_values.indexOf( m ) ];
	} );
}

function htmlspecialchars_decode( text ) {
	return text.replace( /&[\w\d#]{2,5};/g, function ( m ) {
		return html_values[ html_keys.indexOf( m ) ];
	} );
}

function preg_match( a, b ) {
	return new RegExp( a ).test( b );
}

function checkForCaptcha( captcha, captcha_validation_url ) {
	needCaptcha = false;
	$.ajax( {
		method : "POST",
		url : captcha_validation_url,
	} ).done( function ( msg ) {
		if ( msg !== "0" ) {
			needCaptcha = true;
			$( captcha ).parent().removeClass( "d-none" );
		} else
			needCaptcha = false;
	} ).fail( function ( xhr, ajaxOptions, thrownError ) {
		needCaptcha = true;
		$( captcha ).parent().removeClass( "d-none" );
		mail_error( "Unable to check for captcha. Ajax failed", [ xhr, ajaxOptions, thrownError ] );
	} );

}

function forming( button, post_url, success_url, failure_function, captchaLocal = null, captcha_validation_url = null ) {
	let captcha = captchaLocal;
	if ( captcha !== null && captcha_validation_url === null ) {
		alert( "CAPCHA_VALIDATION_URL was not specified" );
		throw new Error( "CAPCHA_VALIDATION_URL was not specified" );
	}

	if ( typeof captcha === "string" )
		captcha = $( captcha );

	let success_action;
	if ( typeof success_url === "function" )
		success_action = success_url;
	else {
		success_action = function () {
			//let arr = getFieldsData( button, captcha );
			let data = new FormData( button.closest( "form" )[ 0 ] );
			$.ajax( {
				method : "POST",
				url : post_url,
				// data : { arr },
				data : data,
				cache : false,
				contentType : false,
				processData : false,
			} ).done( function ( msg ) {
					msg = JSON.parse( msg );
					if ( msg.error === 1 ) {
						$.each( msg, function ( key, value ) {
							if ( key === "error" )
								return true;

							else if ( key === "redirect" )
								window.location.replace( value );

							else if ( key === "custom" )
								raiseFormError( button, value[ 1 ], value[ 2 ] );

							else if ( key === "captcha" ) {
								needCaptcha = true;
								$( captcha ).parent().removeClass( "d-none" );
								raiseFieldError( captcha );
							} else
								raiseFieldError( value[ 0 ], value[ 1 ], value[ 2 ] );
						} );
					} else {
						if ( typeof msg[ "post_id" ] !== "undefined" )
							window.location = success_url + msg[ "post_id" ];
						else
							window.location = success_url;
					}
				} )
				.fail( function ( xhr, ajaxOptions, thrownError ) {
					alert( "Виникла помилка при зберігані змін. Спробуйте пізніше" );
					mail_error( "Unable to save data. Ajax failed", [ xhr, ajaxOptions, thrownError ] );
				} );
		};
	}
	setValidator( button, success_action, failure_function, captcha, captcha_validation_url );

}

function setValidator( button, success, failure, captcha = null, captcha_validation_url = null ) {

	if ( typeof success !== "function" ) {
		alert( "Wrong function" );
		throw new Error( "Wrong function" );
	}

	if ( captcha instanceof jQuery )
		checkForCaptcha( captcha, captcha_validation_url );

	let form = button.closest( "form" );

	$( form ).on( "submit", function ( e ) {

		let data = new FormData( this );

		e.preventDefault();
		if ( validInputs( button, captcha ) )
			success();
		else if ( typeof failure === "function" )
			failure();
	} );

}

// function getFieldsData( button, captcha ) {
// 	let fields = $( button ).parent().parent().find( "[data-regex]" );
// 	let data = [];
// 	let file = $( button ).parent().parent().find( "[type=file]" );
//
// 	if ( captcha instanceof jQuery && needCaptcha === true ) {
// 		let name = "g-recaptcha-response";
// 		let value = $( "#g-recaptcha-response" ).val();
// 		data.push( [ name, value ] );
// 	}
//
// 	fields.each( function () {
//
// 		let el = $( this );
// 		let name = el.attr( "name" );
// 		let value = el.val();
//
// 		data.push( [ name, value ] );
// 	} );
//
// 	file.each( function () {
//
// 		let el = $( this );
// 		let name = el.attr( "name" );
// 		let value = el[ 0 ].files[ 0 ];
//
// 		data.push( [ name, value ] );
//
// 	} );
//
// 	return data;
// }

function raiseFormError( button, translation1 = "", translation2 = "" ) {

	let form = $( button ).parent().parent();

	let bufStr = "";
	if ( translation2.length > 0 )
		bufStr = " title=\"" + translation2 + "\"";

	form.prepend( "<div class=\"alert alert-danger alert-form\" " + bufStr + ">" + translation1 + "</div>" );
}

function raiseFieldError( fieldName, translation1 = "", translation2 = "" ) {

	let el;
	if ( typeof fieldName !== "object" )
		el = $( "[name=\"" + fieldName + "\"]" );
	else
		el = fieldName;
	if ( el.length === 0 )
		el = $( "#a2" + fieldName + "" );

	if ( translation1.length < 1 )
		translation1 = el.attr( "data-regex_warning1" );
	if ( translation2.length < 1 )
		translation2 = el.attr( "data-regex_warning2" );

	let bufStr = "";
	if ( typeof translation2 !== "undefined" && translation2.length > 0 )
		bufStr = " title=\"" + translation2 + "\"";

	el.parent().append( "<div class=\"alert alert-danger alert-regex\" " + bufStr + ">" + translation1 + "</div>" );
}

function validInputs( button, captcha = null ) {
	let fields = $( button ).parent().parent().find( "[data-regex]" );
	let validity = true;

	$( button ).parent().parent().find( ".alert" ).remove();

	if ( captcha instanceof jQuery && needCaptcha === true ) {
		captcha.parent().find( ".alert" ).remove();
		if ( grecaptcha.getResponse().length === 0 ) {
			validity = false;
			raiseFieldError( captcha );
		}
	}

	fields.each( function () {
		let el = $( this );
		let regex = el.attr( "data-regex" );
		regex = htmlspecialchars_decode( regex );
		let value = el.val();
		el.parent().find( ".alert" ).remove();

		if ( ! preg_match( regex, value ) ) {
			validity = false;
			raiseFieldError( el );
		}
	} );

	return validity;

}

function is_touch_device_func() {
	try {
		document.createEvent( "TouchEvent" );
		return true;
	} catch ( e ) {
		return false;
	}
}

function modal_edit( edit_type, target_id ) {

	modal_container.html( `
		<div id="modal_edit_obj" class="modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" title="` + text[ "upload_file" ][ 1 ] + `">` + text[ "upload_file" ][ 0 ] + `</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
		</div>	
	` );

	modal_edit_obj = modal_container.find( "#modal_edit_obj" );
	modal_edit_obj.modal( "show" );

	modal_container.show();
	modal_edit_obj.on( "hidden.bs.modal", function () {
		modal_container.hide();
		modal_container.html( "" );
		modal_edit_obj.off( "hidden.bs.modal" );
		$( ".modal-backdrop.show" ).remove();
		body.removeClass( "modal-open" );
		modal_edit_obj = null;
	} );

	if ( edit_type === "image" ) {
		modal_container.find( ".modal-body" ).html( `
			<form class="box" method="post" enctype="multipart/form-data" action="` + edit_validate_url + `">
				<div class="box__input">
					<input class="box__file" type="file" name="files" id="file">
					<label for="file">
						<strong title="` + text[ "choose_file" ][ 1 ] + `">` + text[ "choose_file" ][ 0 ] + `</strong>
						<span class="box__dragndrop" title="` + text[ "or_drag_file" ][ 1 ] + `">` + text[ "or_drag_file" ][ 0 ] + `</span>.</label>
					<button class="box__button" type="submit">` + text[ "upload_file" ][ 0 ] + `</button>
				</div>
				<div class="box__uploading" title="` + text[ "file_uploading" ][ 1 ] + `">` + text[ "file_uploading" ][ 0 ] + `&hellip;</div>
				<div class="box__success" title="` + text[ "file_uploaded" ][ 1 ] + `">` + text[ "file_uploaded" ][ 0 ] + `!</div>
				<div class="box__error" title="` + text[ "error_uploading" ][ 1 ] + `">` + text[ "error_uploading" ][ 0 ] + `! <span></span></div>
			</form>
		` );

		let $form = modal_edit_obj.find( ".box" ),
			$input = $form.find( "input[type=\"file\"]" ),
			$label = $form.find( "label" ),
			$errorMsg = $form.find( ".box__error span" ),
			$restart = $form.find( ".box__restart" ),
			file = null,
			showFiles = function ( files ) {
				$label.append( "<br>" + files.length > 1 ? ( $input.attr( "data-multiple-caption" ) || "" ).replace( "{count}", files.length ) : files[ 0 ].name + "<br>" );
			};

		$form.append( "<input type=\"hidden\" name=\"type\" value=\"ava\" />" );

		//auto submit form
		$input.on( "change", function ( e ) {
			showFiles( e.target.files );
			$form.trigger( "submit" );
		} );

		if ( supports_drag_and_drop ) {
			$form
				.addClass( "has-advanced-upload" )//for css styling
				.on( "drag dragstart dragend dragover dragenter dragleave drop", function ( e ) {
					// preventing the unwanted behaviours
					e.preventDefault();
					e.stopPropagation();
				} )
				.on( "dragover dragenter", function () {
					$form.addClass( "is-dragover" );
				} )
				.on( "dragleave dragend drop", function () {
					$form.removeClass( "is-dragover" );
				} )
				.on( "drop", function ( e ) {
					file = e.originalEvent.dataTransfer.files;//dropped files
					showFiles( file );
					$form.trigger( "submit" );//submit form
				} );
		}

		//if the form was submitted
		$form.on( "submit", function ( e ) {
			//preventing the duplicate submissions if the current one is in progress
			if ( $form.hasClass( "is-uploading" ) )
				return false;

			if ( ! navigator.onLine ) {
				alert( text[ "no_internet" ] );
				return false;
			}

			$form.addClass( "is-uploading" ).removeClass( "is-error" );

			if ( supports_drag_and_drop ) {
				e.preventDefault();
				//let ajaxData = new FormData($form.get(0));
				let fileInput = $( "input#file" ).get( 0 );
				if ( fileInput.files.length !== 0 )
					file = fileInput.files;
				file = file[ 0 ];
				let form_data = new FormData();
				form_data.append( "type", "ava" );
				form_data.append( "files", file );
				let re = /(?:\.([^.]+))?$/;
				let image_ext = re.exec( file.name )[ 0 ];
				if ( image_ext[ 0 ] !== "." )
					image_ext = "." + image_ext;

				if ( file == null || file.type === null || file.type.substr( 0, 5 ) !== "image" ) {
					$form.addClass( "is-error" ).removeClass( "is-uploading" );
					file = null;
					return false;
				}

				$.ajax(
					{
						type : "POST",
						url : $form.attr( "action" ),
						data : form_data,
						dataType : "json",
						cache : false,
						contentType : false,
						processData : false,
					} )
					.always( function () {
						$form.removeClass( "is-uploading" );
					} )
					.done( function ( data ) {
						$form.removeClass( "is-uploading" );
						if ( data.error === 0 || data.error === "0" ) {
							$form.addClass( "is-success" );
							modal_edit_obj.trigger( "hidden.bs.modal" );
							let target = $( "#" + target_id );

							target.css( "background-image", "url(" + data.src + ")" );
						} else {
							$form.addClass( "is-error" );
							$errorMsg.text( data.error1 );
							$errorMsg.attr( "title", data.error2 );
						}
					} ).fail( function ( xhr, ajaxOptions, thrownError ) {
					alert( "Unable to upload photo. Ajax failed" );
					$form.addClass( "is-error" );
					mail_error( "Unable to upload photo. Ajax failed", [ xhr, ajaxOptions, thrownError ] );
				} );
			} else {//for older browsers
				let iframeName = "uploadiframe" + new Date().getTime(),
					$iframe = $( "<iframe name=\"" + iframeName + "\" style=\"display: none;\"></iframe>" );

				$( "body" ).append( $iframe );
				$form.attr( "target", iframeName );

				$iframe.one( "load", function () {
					let data = $.parseJSON( $iframe.contents().find( "body" ).text() );
					$form.removeClass( "is-uploading" ).addClass( data.success === true ? "is-success" : "is-error" ).removeAttr( "target" );
					if ( ! data.success )
						$errorMsg.text( data.error );
					$iframe.remove();
				} );
			}
		} );


		// restart the form if has a state of error/success
		$restart.on( "click", function ( e ) {
			e.preventDefault();
			$form.removeClass( "is-error is-success" );
			$input.trigger( "click" );
		} );

		//Firefox focus bug fix for file input
		$input
			.on( "focus", function () {
				$input.addClass( "has-focus" );
			} )
			.on( "blur", function () {
				$input.removeClass( "has-focus" );
			} );
	}

}

function section_edit( section ) {
	let fields = section.find( ".user_profile_edit_field" );
	let checkboxes = section.find( ".custom-control-input" );
	let data = [];
	let data_to_send = new FormData();
	let url;
	let valid = true;
	if ( section.is( "[data-action]" ) )
		url = section.attr( "data-action" );
	else
		url = section.parent().attr( "data-action" );

	data_to_send.append( "type", "profile_edit" );

	fields.each( function () {
		let el = $( this );
		let name = el.attr( "name" );
		let id;
		if ( name.substring( name.length - 5 ) === "_edit" )
			id = name.substr( 0, name.length - 5 );
		else
			id = name;
		let regex = el.attr( "data-regex" );
		regex = htmlspecialchars_decode( regex );

		let value = el.val();
		if ( name === "user_login_edit" && value[ 0 ] === "@" )
			value = value.substring( 1 );

		let display_field = $( "#" + id );
		if ( display_field.length === 0 )
			display_field = el.parent().find( ".section_field_value" );
		if ( display_field.length === 0 )
			display_field = el.parent().parent().find( ".section_field_value" );
		el.parent().find( ".alert" ).remove();

		if ( ! ( value.length === 0 && el.hasClass( "user_profile_input_optional" ) ) && ! preg_match( regex, value ) ) {
			valid = false;
			raiseFieldError( el );
			data = null;
			data_to_send = null;
			//return false;
		} else if ( valid === true ) {
			data.push( [ true, el, display_field, value, id ] );
			data_to_send.append( name, value );
		}
	} );

	if ( valid === true ) {
		checkboxes.each( function () {
			let el = $( this );
			let name = el.attr( "name" );
			let value = el.is( ":checked" ); // ?
			let el_to_hide = el.parent().parent();

			data.push( [ false, el, el_to_hide, value ] );
			data_to_send.append( name, value );

		} );
	}

	if ( ! navigator.onLine ) {
		alert( text[ "no_internet" ] );
		return false;
	}

	if ( ! valid )
		return false;

	let success_function;
	if ( typeof mono_success_function !== "undefined" ) {
		success_function = function ( result ) {
			if ( result.error === 0 || result.error === "0" ) {

				if ( data[ 0 ][ 4 ].search( "password" ) !== -1 ) {
					$.each( data, function ( key ) {
						data[ key ][ 1 ].val( "" );
					} );
				}

				let span = section.find( ".user_profile_edit" );
				let span_text = span.text();
				span.text( text[ "saved" ] );
				setTimeout( function () {
					span.text( span_text, "0" );
				}, 1000 );

			} else {

				//display error message
				$.each( result, function ( key, value ) {

					if ( key === "error" )
						return true;

					if ( key.substring( key.length - 5 ) === "_edit" )
						key = key.substr( 0, key.length - 5 );

					let index = find_with_attr( data, 4, key );
					if ( index === -1 ) {
						alert( text[ "error_while_saving" ] );
						mail_error( "Ajax returned unknown variables", [ data, data_to_send, result ] );
					}

					raiseFieldError( data[ index ][ 1 ], value[ 1 ], value[ 2 ] );
					return false;

				} );
			}
		};
	} else {
		success_function = function ( result ) {
			if ( result.error === 0 || result.error === "0" ) {
				//change real result on the page
				$.each( data, function ( key, row ) {
					if ( row[ 0 ] ) {//is field

						let is_covered = false;
						let is_changed = false;

						if ( row[ 4 ] === "user_name" ) {
							let index = find_with_attr( data, 4, key );

							if ( index !== -1 ) {

								is_covered = true;

								if ( row[ 3 ].length > 0 )
									data[ index ][ 2 ].show();
								else {
									data[ index ][ 2 ].hide();
									row[ 3 ] = "@" + data[ index ][ 3 ];
								}
							}


						}

						if ( row[ 4 ] === "class" ) {
							if ( row[ 3 ] === "0" )
								row[ 3 ] = text[ "class_undefined" ][ 0 ];
							if ( row[ 3 ] === "-1" )
								row[ 3 ] = text[ "graduated" ][ 0 ];
						}

						if ( row[ 4 ] === "user_login" )
							row[ 3 ] = "@" + row[ 3 ];

						if ( row[ 4 ] === "email" ) {
							is_changed = true;
							row[ 2 ].attr( "href", "mailto:" + row[ 3 ] );
						}

						if ( row[ 4 ] === "phone" ) {
							is_changed = true;
							row[ 2 ].attr( "href", "sms:" + row[ 3 ] );
						}

						if ( row[ 4 ] === "birth" )//Y-m-d > d.m.Y
							row[ 3 ] = row[ 3 ].substr( 8, 2 ) + "." + row[ 3 ].substr( 5, 2 ) + "." + row[ 3 ].substr( 0, 4 );

						if ( row[ 4 ].substring( 0, 2 ) === "sm" ) {
							let parent = $( row[ 2 ] ).parent();
							if ( row[ 3 ].length === 0 ) {
								if ( ! parent.hasClass( "user_profile_edit_hidden" ) )
									parent.addClass( "user_profile_edit_hidden" );
							} else {
								if ( parent.hasClass( "user_profile_edit_hidden" ) )
									parent.removeClass( "user_profile_edit_hidden" );
								if ( isValidURL( row[ 3 ] ) )
									row[ 2 ].attr( "href", row[ 3 ] );
								else
									row[ 2 ].attr( "href", row[ 1 ].attr( "data-sm_link" ) + row[ 3 ] );
							}

						} else {
							if ( ! is_changed )
								row[ 2 ].text( row[ 3 ] );
							if ( ! is_covered ) {
								let parent = row[ 2 ].parent();
								if ( parent.is( ".section_field" ) ) {
									if ( row[ 3 ].length === 0 )
										parent.addClass( "user_profile_edit_hidden" );
									else
										parent.removeClass( "user_profile_edit_hidden" );
								}
							}
						}


					} else {//is checkbox
						if ( row[ 3 ] )
							row[ 2 ].removeClass( "user_profile_edit_hidden" );
						else
							row[ 2 ].addClass( "user_profile_edit_hidden" );
					}

				} );

				section.removeClass( "editing" );

			} else {

				//display error message
				$.each( result, function ( key, value ) {

					if ( key === "error" )
						return true;

					if ( key.substring( key.length - 5 ) === "_edit" )
						key = key.substr( 0, key.length - 5 );

					let index = find_with_attr( data, 4, key );
					if ( index === -1 ) {
						alert( text[ "error_while_saving" ] );
						mail_error( "Ajax returned unknown variables", [ data, data_to_send, result ] );
					}

					raiseFieldError( data[ index ][ 1 ], value[ 1 ], value[ 2 ] );
					return false;

				} );
			}
		};
	}

	$.ajax( {
			type : "POST",
			url : url,
			data : data_to_send,
			dataType : "json",
			cache : false,
			contentType : false,
			processData : false,
		} )
		.done( success_function )
		.fail( function ( xhr, ajaxOptions, thrownError ) {
				alert( text[ "error_while_saving" ] );
				mail_error( "Unable to save profile data. Ajax failed", [ xhr.responseText, xhr.readyState, xhr.status, xhr.statusText, ajaxOptions, thrownError ] );
			},
		);
}

function mail_error( mail_head, variables ) {

	$.post( mail_url, { header : mail_head, data : JSON.stringify( variables ) } );

}

function find_with_attr( array, attr, value ) {
	for ( let i = 0; i < array.length; i += 1 )
		if ( array[ i ][ attr ] === value )
			return i;
	return -1;
}

// function src_to_preview( field_names, result_container ) {
//
// 	field_names = field_names.split( " " );
//
// 	if ( field_names.length === 0 )
// 		return 0;
//
// 	$.each( field_names, function ( k, field_name ) {
//
// 		let field = $( "[name=\"" + field_name + "\"]" );
// 		let parent = field.parent();
//
// 		if ( field.length === 0 )
// 			return 1;
//
// 		if ( field.attr( "type" ) === "file" ) {
//
// 			parent.on( "change", "[name=\"" + field_name + "\"]", function () {
//
// 				let reader = new FileReader();
// 				let container = $( "#" + result_container );
//
// 				reader.onload = function ( e ) {
//
// 					create_preview_from_src( null, e.target.result, container);
//
// 				};
//
// 				let image = $( "[name=\"" + field_name + "\"]" )[ 0 ];
//
// 				if(image.value!=='')
// 					reader.readAsDataURL( image.files[ 0 ] );
// 				else
// 					create_preview_from_src( null, null, container );
//
// 			} );
//
// 		} else {
//
// 			create_preview_from_src(field);
//
// 			field.on('input',function(){
// 				create_preview_from_src( field );
// 			});
// 			// parent.on( "change", "[name=\"" + field_name + "\"]", function () {
// 			// 	create_preview_from_src( field );
// 			// } );
//
// 		}
//
// 	} );
//
//
// }

// function create_preview_from_src( field, field_value = null, result_container = null ) {
//
// 	if(result_container!=null)
// 		result_container = $( result_container );
//
// 	if ( field != null ) {
//
// 		if ( typeof field_value == "undefined" || field_value==null || field_value.length < 1)
// 			field_value = "" + field.val();
//
// 		result_container = field.parent();
//
// 	}
//
// 	if(typeof result_container === "undefined" || result_container == null)
// 		return false;
//
// 	result_container.find( "img.src_preview" ).remove();
//
// 	if(field_value.length > 0){
// 		result_container.append( "<img class=\"src_preview zoomable\" src=\"" + field_value + "\" alt=\"" + text[
// "image_preview" ] + "\">" ); result_container.find( ".src_preview" ).click( function () { zoomable_click( $( this )
// ); } ); }  }

if ( is_touch_device ) {
	$( "*[title]:not(a):not(button)" ).click( function () {
		let el = $( this );
		let translation = el.attr( "title" );
		el.attr( "title", el.text() );
		el.text( translation );
	} );
}

$( ".sms_link" ).click( function () {
	if ( ! is_mobile_phone ) {
		alert( $( this ).attr( "href" ).substr( 4 ) );
		return false;
	}
} );

function isValidURL( str ) {
	let a = document.createElement( "a" );
	a.href = str;
	return ( a.host && a.host !== window.location.host );
}


$( ".zoomable" ).click( function () {
	zoomable_click( $( this ) );
} );

function zoomable_click( img = null ) {
	if ( img == null )
		return false;

	let src = img.css( "background-image" );
	if ( src == null || src.length < 1 || src === "none" )
		src = img.attr( "src" );
	else {
		src = src.substring( 4, src.length - 1 );
		if ( src.substring( 0, 1 ) === "'" || src.substring( 0, 1 ) === "\"" )
			src = src.substring( 1, src.length - 1 );
	}

	if ( ! zoomable_used ) {

		zoomable_used = true;

		zoomable.html( "<img src=\"" + src + "\" alt=\"zoomable image\">" );

	} else {
		zoomable.show();
		zoomable.find( "img" ).attr( "src", src );
	}
}

zoomable.hide();

zoomable.click( function () {
	$( this ).hide();
} );

$( ".user_profile_edit" ).click( function () {
	let parent_section = $( this ).parent( ".section" );

	if ( ! parent_section.hasClass( "editing" ) && ! $( this ).hasClass( "user_profile_mono_edit" ) )
		parent_section.toggleClass( "editing" );
	else
		section_edit( parent_section );
} );

$.fn.enter_key = function ( fnc, mod ) {
	return this.each( function () {
		$( this ).keypress( function ( ev ) {
			let key_code = ( ev.keyCode ? ev.keyCode : ev.which );
			if ( [ 13, "13", 10, "10" ].indexOf( key_code ) !== -1 && ( ! mod || ev[ mod + "Key" ] ) )
				fnc.call( this, ev );
		} );
	} );
};