$(function() {
	$('.alert').click(function(e) {
		let el = $(this);
		let offset = el.offset();
		let relativeX = (e.pageX - offset.left);
		if(el.outerWidth()-relativeX>5 && el.outerWidth()-relativeX<40)
			el.remove();
	});
});

if ('serviceWorker' in navigator) {
	window.addEventListener('load', function() {//registration.scope
		navigator.serviceWorker.register(url+'serviceworker.js').then(function(registration) {

		}, function(err) {});
	});
}