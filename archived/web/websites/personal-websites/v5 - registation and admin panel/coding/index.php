<!DOCTYPE html>
<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<style>
			header {
				padding: 2vw;
				background: #222;
				color: #666 !important;
				font-size: 3vw;
				font-family: cursive;
			}
			*:not(textarea) {
				text-align: center !important;
			}
			textarea {
				width: 60vw;
				height: 30vh;
				max-width: 85vw;
			}
			select {
				width: auto !important;
				display: inline !important;
			}
			p {
				margin: 1.2vh;
				font-weight: 600;
			}
		</style>
		<?php
			$a=array('UCS-4','UCS-4BE','UCS-4LE','UCS-2','UCS-2BE','UCS-2LE','UTF-32','UTF-32BE','UTF-32LE','UTF-16','UTF-16BE','UTF-16LE','UTF-7','UTF7-IMAP','UTF-8','ASCII','EUC-JP','SJIS','eucJP-win','SJIS-win','ISO-2022-JP','ISO-2022-JP-MS','CP932','CP51932','SJIS-mac','MacJapanese','SJIS-Mobile#DOCOMO','SJIS-DOCOMO','SJIS-Mobile#KDDI','SJIS-KDDI','SJIS-Mobile#SOFTBANK','SJIS-SOFTBANK','UTF-8-Mobile#DOCOMO','UTF-8-DOCOMO','UTF-8-Mobile#KDDI-A','UTF-8-Mobile#KDDI-B','UTF-8-KDDI','UTF-8-Mobile#SOFTBANK','UTF-8-SOFTBANK','ISO-2022-JP-MOBILE#KDDI','ISO-2022-JP-KDDI','JIS','JIS-ms','CP50220','CP50220raw','CP50221','CP50222','ISO-8859-1','ISO-8859-2','ISO-8859-3','ISO-8859-4','ISO-8859-5','ISO-8859-6','ISO-8859-7','ISO-8859-8','ISO-8859-9','ISO-8859-10','ISO-8859-13','ISO-8859-14','ISO-8859-15','ISO-8859-16','byte2be','byte2le','byte4be','byte4le','BASE64','HTML-ENTITIES','7bit','8bit','EUC-CN','CP936','GB18030','HZ','EUC-TW','CP950','BIG-5','EUC-KR','UHC','CP949','ISO-2022-KR','Windows-1251','CP1251','Windows-1252','CP1252','CP866IBM866','KOI8-R','KOI8-U','ArmSCII-8','ArmSCII8');
			function o($name,$i=0){
				echo '<option value="'.$name.'"';
				if(($_POST['charset']==$name && $i==0) || ($_POST['charset2']==$name && $i))
					echo ' selected';
				echo '>'.$name.'</option>';
			}

		?>
	</head>
	<body>
		<header>Encoding &#38; Decoding text</header>
		<p>ENTER TE<span>X</span>T:</p>
		<form action="http://mambo.in.ua/coding/" method="post">
			<textarea id="a1" name="input"><?=$_POST['input']?></textarea><br>
			<select class="form-control" name="charset">
				<?php for($i=0;$a[$i];$i++){
					o($a[$i]);
				} ?>
			</select>
			<i class="glyphicon glyphicon-chevron-right"></i>
			<select class="form-control" name="charset2">
				<?php for($i=0;$a[$i];$i++){
					o($a[$i],1);
				} ?>
			</select>
			<button class="btn btn-info">Go</button>
			<p>OUTPUT:</p>
			<textarea id="a2" name="output"><?php
				echo mb_convert_encoding($_POST['input'],$_POST['charset2'],$_POST['charset']);
				?></textarea>
			<script>
				new MutationObserver( function () { $('textarea').width($('#a1').width()); $('textarea').height($('#a1').height()); } ).observe(a1, {
						attributes: true, attributeFilter: [ "style" ]
				})
				new MutationObserver( function () { $('textarea').width($('#a2').width()); $('textarea').height($('#a2').height()); } ).observe(a2, {
					attributes: true, attributeFilter: [ "style" ]
				})
				$('span').click( function(){ $('header, p').hide();
					$('textarea').css('width','100vw');
					$('textarea').css('height','40vh');
					$('textarea').css('max-width','100vw');
					$('*').css('text-align','left');
				});
			</script>
		</form>
	</body>
</html>