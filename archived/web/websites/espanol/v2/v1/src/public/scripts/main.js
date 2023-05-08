let needCaptcha = true;
let html_keys = ['&amp;', '&#038;', '&lt;', '&gt;', '&quot;', '&#039;'];
let html_values = ['&', "&", '<', '>', '"', "'"];

//let captcha = null;

function htmlspecialchars(text) {
	return text.replace(/[&<>"']/g, function(m) {
		return html_keys[html_values.indexOf(m)];
	});
}

function htmlspecialchars_decode(text) {
	return text.replace(/&[\w\d#]{2,5};/g, function(m) {
		return html_values[html_keys.indexOf(m)];
	});
}

function preg_match(a, b) {
	return new RegExp(a).test(b);
}

function checkForCaptcha(captcha, captcha_validation_url) {
	needCaptcha = false;
	$.ajax({
		method: "POST",
		url: captcha_validation_url
	}).done(function(msg) {
		if( msg !== "0" ){
			needCaptcha = true;
			$(captcha).parent().removeClass('d-none');
		}
		else
			needCaptcha = false;
	});
}

function forming(button, post_url, success_url, failure_function, captchaLocal = null, captcha_validation_url = null) {
	let captcha = captchaLocal;
	if( captcha !== null && captcha_validation_url === null ){
		alert('CAPCHA_VALIDATION_URL was not specified');
		throw new Error('CAPCHA_VALIDATION_URL was not specified');
	}

	if( typeof captcha === 'string' )
		captcha = $(captcha);

	if( typeof success_url === 'function' )
		setValidator(button, success_url, failure_function, captcha, captcha_validation_url);
	else {
		setValidator(button, function() {
				let arr = getFieldsData(button, captcha);
				$.ajax({
					method: "POST",
					url: post_url,
					data: { arr }
				}).done(function(msg) {
					if( msg !== "" && msg !== "ok" ){
						if( msg.substring(0, 10) === 'Redirect: ' ){
							let link = msg.substring(10);
							window.location.replace(link);
						}
						if( msg.substring(0, 7) === 'Captcha' ){
							msg = msg.substring(8);
							needCaptcha = true;
							$(captcha).parent().removeClass('d-none');
						}
						if( msg.substring(0, 7) === 'Error: ' ){
							let receivedData = msg.split("\\n");
							let translation1 = receivedData[1];
							let translation2 = receivedData[2];
							raiseFormError(button, translation1, translation2);
						}
						else if( msg.substring(0, 7) === 'Field: ' )
							raiseFieldError(msg.substring(0, 7));
						else
							alert(msg);
					}
					else
						window.location = success_url;
				});
			}
			, failure_function, captcha, captcha_validation_url
		);
	}

}

function setValidator(button, success, failure, captcha = null, captcha_validation_url = null) {

	if( typeof success !== 'function' ){
		alert('Wrong function');
		throw new Error('Wrong function');
	}

	if( captcha instanceof jQuery )
		checkForCaptcha(captcha, captcha_validation_url);

	let form = button.closest("form");

	$(form).on('submit',function() {
		if( validInputs(button, captcha) )
			success();
		else if( typeof failure === 'function' )
			failure();
	});

}

function getFieldsData(button, captcha) {
	let fields = $(button).parent().parent().find('[data-regex]');
	let data = [];

	if( captcha instanceof jQuery && needCaptcha === true ){
		let name = 'g-recaptcha-response';
		let value = $('#g-recaptcha-response').val();
		data.push([name, value]);
	}

	fields.each(function() {
		let name = $(this).attr('name');
		let value = $(this).val();
		let regex = $(this).attr('data-regex');

		data.push([name, value, regex]);
	});

	return data;
}

function raiseFormError(button, translation1 = '', translation2 = '') {

	let form = $(button).parent().parent();

	let bufStr = '';
	if( translation2.length > 0 )
		bufStr = ' title="' + translation2 + '"';

	form.prepend('<div class="alert alert-danger alert-form" ' + bufStr + '>' + translation1 + '</div>');
}

function raiseFieldError(fieldName, translation1 = '', translation2 = '') {

	let el;
	if( typeof fieldName !== 'object' )
		el = $('[name="' + fieldName + '"]');
	else
		el = fieldName;

	if( translation1.length < 1 )
		translation1 = el.attr('data-regex_warning1');
	if( translation2.length < 1 )
		translation2 = el.attr('data-regex_warning2');

	let bufStr = '';
	if( translation2.length > 0 )
		bufStr = ' title="' + translation2 + '"';

	el.parent().append('<div class="alert alert-danger alert-regex" ' + bufStr + '>' + translation1 + '</div>');
}

function validInputs(button, captcha = null) {
	let fields = $(button).parent().parent().find('[data-regex]');
	let validity = true;

	$(button).parent().parent().find('.alert').remove();

	if( captcha instanceof jQuery && needCaptcha === true ){
		captcha.parent().find('.alert').remove();
		if( grecaptcha.getResponse().length === 0 ){
			validity = false;
			raiseFieldError(captcha);
		}
	}

	fields.each(function() {
		let el = $(this);
		let regex = el.attr('data-regex');
		regex = htmlspecialchars_decode(regex);
		let translation1 = el.attr('data-regex_warning1');
		let translation2 = el.attr('data-regex_warning2');
		let value = el.val();
		el.parent().find('.alert').remove();

		if( !preg_match(regex, value) ){
			validity = false;
			raiseFieldError(el, translation1, translation2);
		}

	});

	return validity;

}

function is_touch_device() {
	try {
		document.createEvent("TouchEvent");
		return true;
	} catch( e ) {
		return false;
	}
}

if( is_touch_device() ){
	$('*[title]:not(a)').click(function() {
		let el = $(this);
		let translation = el.attr('title');
		el.attr('title', el.text());
		el.text(translation);
	});
}

let zoomable = $('#zoomable');

$('.zoomable').click(function() {
	let img = $(this);
	let src = img.css('background-image');
	if( src == null || src.length < 1 )
		src = img.attr('src');
	else {
		src = src.substring(4, src.length - 1);
		if( src.substring(0, 1) === "'" || src.substring(0, 1) === '"')
			src = src.substring(1, src.length - 1);
	}

	zoomable.show();
	zoomable.find('img').attr('src', src);
});

zoomable.hide();

zoomable.click(function() {
	$(this).hide();
});

$('.user_profile_edit').click(function() {
	$(this).parent(".section").toggleClass('editing');
});