<?php

$site_link = 'https://maxxxxxdlp.ml/';

$url = $_SERVER['REQUEST_URI'];

//extract get parameters
$param_pos = strpos($url, '?');
if($param_pos !== FALSE){
	$params_string = substr($url, $param_pos + 1);//?a=b
	$url = substr($url, 0, $param_pos);           //dir/file

	$params = explode('&', $params_string);
	foreach($params as $param){

		$data = explode('=', $param);
		if(count($data) == 0)
			$_GET[$data[0]] = '';
		else
			$_GET[$data[0]] = $data[1];
	}

}

$url_parts = explode('/', $url);
$last_part = count($url_parts) - 1;


function get_file(){

	global $file_to_include;
	global $file_extension;

	$mime_type = 'application/octet-stream';
	$mime_types = [

		'txt'  => 'text/plain',
		'html' => 'text/html',
		'php'  => 'text/html',
		'css'  => 'text/css',
		'js'   => 'application/javascript',
		'json' => 'application/json',
		'xml'  => 'application/xml',

		// images
		'png'  => 'image/png',
		'jpeg' => 'image/jpeg',
		'jpg'  => 'image/jpeg',
		'gif'  => 'image/gif',
		'bmp'  => 'image/bmp',
		'ico'  => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif'  => 'image/tiff',
		'svg'  => 'image/svg+xml',

		// archives
		'zip'  => 'application/zip',
		'rar'  => 'application/x-rar-compressed',

		// audio/video
		'mp3'  => 'audio/mpeg',
		'mov'  => 'video/quicktime',

		// adobe
		'pdf'  => 'application/pdf',
		'psd'  => 'image/vnd.adobe.photoshop',

		// ms office
		'doc'  => 'application/msword',
		'rtf'  => 'application/rtf',
		'xls'  => 'application/vnd.ms-excel',
		'ppt'  => 'application/vnd.ms-powerpoint',

		// open office
		'odt'  => 'application/vnd.oasis.opendocument.text',
		'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
	];

	if(array_key_exists($file_extension, $mime_types))
		$mime_type = $mime_types[$file_extension];
	elseif($file_extension != '' && function_exists('finfo_open')) {
		$file_info = finfo_open(FILEINFO_MIME);
		$mime_type = finfo_file($file_info, $file_to_include);
		finfo_close($file_info);
	}

	header('Content-Type: ' . $mime_type);
	header("Content-Length: " . filesize($file_to_include));
	readfile($file_to_include);

}

function page_404(){

	require '404.php';
	die();
}

$file_specified = !(substr($url, -1) == '/');
$file_name = '';
if($file_specified){

	$file_name = $url_parts[$last_part];
	unset($url_parts[$last_part]);
	$url = implode('/', $url_parts) . '/';
}

$routes = [
	//FULL STRING MATCH

	//shop
	'/taxa/front_end/'   => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxa/front_end'    => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxons/front_end/' => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxons/front_end'  => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxons/'           => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxons'            => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxa/'             => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxa'              => ['301', 'https://specify.maxxxxxdlp.ml/taxa_itis/front_end/'],
	'/taxa2/'            => ['301', 'https://specify.maxxxxxdlp.ml/taxa_col/'],
	'/taxa2'             => ['301', 'https://specify.maxxxxxdlp.ml/taxa_col/'],
	'/taxons2/'          => ['301', 'https://specify.maxxxxxdlp.ml/taxa_col/'],
	'/taxons2'           => ['301', 'https://specify.maxxxxxdlp.ml/taxa_col/'],

	//main website
	'/'                  => '',
	'/game/'             => '',

	//	'_' => '', //BEGINNING MATCH
	//	'/public/'

	//regex matches
	//['301','index.php] > permament redirect
	//['include', 'index.php']
	//'404' > summons 404
];

$do_regex = FALSE;
$file_to_include = '';
$file_extension = '';

foreach($routes as $key => $value){

	if($key === '_')
		$do_regex = TRUE;
	else {

		if($file_specified && $key == $url . $file_name . '/'){
			$file_specified = FALSE;
			$url .= $file_name . '/';
		}
		elseif(
			( //does not match regex
				$do_regex &&
				!preg_match($key, $url)
			) || (
				!$do_regex &&
				(
					!( //does not match url with a file
						$file_specified &&
						$key == $url . $file_name
					) &&
					$key != $url // does not match url without a file
				)
			)
		)
			continue;

		if(is_array($value) && $value[0] == '301'){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $value[1]);
			die();

		}
		elseif($value == '') {

			$file_to_include = '';

			if($file_specified){

				if(!is_file(__DIR__ . $url . $file_name))
					return FALSE;
				$file_to_include = __DIR__ . $url . $file_name;

				$file_extension = strrchr($file_name, '.');
				if($file_extension === FALSE)
					$file_extension = '';
				else
					$file_extension = substr($file_extension, 1);


			}
			elseif(file_exists(__DIR__ . $url . 'index.php')) {
				$file_to_include = __DIR__ . $url . 'index.php';
				$file_extension = 'php';

			}
			elseif(file_exists($url . 'index.html')) {
				$file_to_include = __DIR__ . $url . 'index.html';
				$file_extension = 'html';
			}

			if($file_to_include == '')
				page_404();

			elseif($file_extension == 'php') {

				$_SERVER['CUSTOM_INCLUDED_DOCUMENT_PATH'] = $file_to_include;
				unset($param_pos, $url_parts, $last_part, $url, $file_specified, $file_name, $routes, $do_regex,
					$file_to_include, $file_extension, $site_link, $value, $key
				);
				require $_SERVER['CUSTOM_INCLUDED_DOCUMENT_PATH'];

			}
			else
				get_file();
		}

		break;
	}
}
