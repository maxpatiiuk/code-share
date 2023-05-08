<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			head(0,0,'Адміністування',1);
			global $row,$res;
		?>
	</head>
	<body>
		<?php top();
		if(preg_match('/[a-z0-9]/', $_COOKIE['hesh'])){
			que('SELECT id,type FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			$id=$row['id'];
			$g_id=$row['id'];
			$type=$row['type'];
			if($u!=1)
				$err=1;
		}
		else
			$err=1;
		if($err==1)
			echo '<div class="alert alert-danger">Доступ заборонений</div>';
		else {
			que('SELECT content FROM '._POSTS_.' WHERE name="d3"');
			$row=mysql_fetch_array($res);
			?><form action="../index.php?a=d3" method="post">
				<br><div class="form-group">
					<label class="control-label col-sm-2" for="a2u_date">На коли задано:</label>
					<div class="col-sm-9">
						<input class="form-control" id="a2u_date" type="date" name="date" value="<?=date('Y-m-d')?>" placeholder="мм/дд/рррр" min="<?=date('Y-m-d')?>" max="<?=date("Y-m-d", strtotime('+50 days'))?>" pattern="[^\\\$\^\&amp;\?\*\{\}\'\[\]]" requiered>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="a2u_content">Завдання:</label>
					<div class="col-sm-9">
						<textarea class="form-control" rows="5" maxlength="1000" id="a2content" name="content" placeholder="Завдання"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="a2u_content"></label>
					<div class="col-sm-9">
						<input type="submit" class="btn btn-submit" value="Додати">
					</div>
				</div>
			</form>
			<?php
		}
		down();?>
		<script>function redir(where) {window.location.href = where;}</script>
	</body>
<html>