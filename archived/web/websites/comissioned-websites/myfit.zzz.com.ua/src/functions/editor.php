<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once 'main.php';
			head(NULL,NULL,'Адміністування',1);
			if(isset($_POST['htmlCode']))
				$edited=1; ?>
		<script src="https://cdn.ckeditor.com/4.9.2/full-all/ckeditor.js"></script>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body class="un" style="padding-top: 0px;">
		<div class="container" style="padding-top: 0px;"> <?php
			if($split==6)
				echo '<div class="row"><div class="col-xs-12">';
			if(_TYPE_!=2){
				alert('Доступ заборонений','danger');
				exit();
			}
			if($edited){ ?><?php
				que('UPDATE '._MV_.' SET value="'.htmlspecialchars($_POST['htmlCode']).'" WHERE name="'.$name.'"');
				alert('Сторінку успішно змінено','success');
			}
			que('SELECT value FROM '._MV_.' WHERE name="'.$name.'"');
			$row=mysql_fetch_assoc($res); ?>
			<div class="actionButtons btn-group">
				<button id="save" class="btn btn-success">Зберегти зміни</button>
				<a href="<?=LINK?>" id="specialButton" class="btn btn-warning">На головну</a>
				<a href="<?=LINK?>" id="specialButton" class="btn btn-danger">Скасувати зміни</a>
			</div>
			<textarea cols="80" id="editor2" name="editor2" rows="10"><?=htmlspecialchars_decode($row['value'])?></textarea>
			<?php if($split==6)
				echo '</div></div>'; ?>
		</div>
		<script>
			function escapeHtml(text) {
					return text
						.replace(/&/g, "&amp;")
						.replace(/</g, "&lt;")
						.replace(/>/g, "&gt;")
						.replace(/"/g, "&quot;")
						.replace(/'/g, "&#039;");
			}
			$('#save').click(function(){
				if(!$('#cke_18').hasClass('cke_button_on'))
					$('#cke_18').click();
				setTimeout(function(){
					var parrent = $('#cke_1_contents');
					var textarea = parrent.find('textarea');
					var value = textarea.val();

					var formHTML=`<form method="post" id="autoSubmittedForm" class="hidden">
						<textarea name="htmlCode">`+escapeHtml(value)+`</textarea>
						<input name="autoSubmitting" type="submit" name="submittedForm" value>
					</form>`;
					$('body').append(formHTML);
					var submitButton = $('body').find('#autoSubmittedForm');
					submitButton.submit();
				},100);
			});
		</script>
		<script>
			CKEDITOR.replace( 'editor2', {
				height: 260,
				contentsCss: [ 'https://cdn.ckeditor.com/4.9.2/full-all/contents.css', 'https://sdk.ckeditor.com/samples/assets/css/classic.css' ]
			} );
		</script>
	</body>
</html>