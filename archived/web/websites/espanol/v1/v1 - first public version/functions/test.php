<!DOCTYPE html>
<html>
	<head>
		<?php
		global $res,$row;
		require_once 'main.php';
		que('SELECT * FROM '._POSTS_.' WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
		$pRow=mysql_fetch_array($res);
		head(0,1,$pRow['name'],1);
		?>
	</head>
	<body>
		<?php top(1);
		$cr=$pRow['creator_name'];
		if(_ID_!=$cr){
			if(!$pRow['views'])
				$pRow['views']=0;
			que('UPDATE '._POSTS_.' SET views="'.($pRow['views']+1).'" WHERE id="'.$pRow['id'].'"');
		}
		if($type==2)
			echo '<a style="color:#fff" class="btn btn-success" href="'.LINK.'adm/maerial.php?a=editPost&id='.$pRow['id'].'">Редагувати тест</a><a style="color:#fff" class="btn btn-danger" href="'.LINK.'adm/maerial.php?tab=5&r=deleted&id='.$pRow['id'].'">Видалити тест</a><br>';
		que('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$cr.'"');
		$row=mysql_fetch_array($res);
		if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
			$creator_name=$row['u_name'].' '.$row['u_surname'];
		else
			$creator_name=str_rot13($row['login']);
		$lsrc=LINK.'images/p/'.str_rot13($row['login']).'.';
		if (@getimagesize($lsrc.'jpg'))
			$srr=$lsrc.'jpg';
		else if (@getimagesize($lsrc.'png'))
			$srr=$lsrc.'png';
		else if (@getimagesize($lsrc.'tiff'))
			$srr=$lsrc.'tiff';
		else if (@getimagesize($lsrc.'gif'))
			$srr=$lsrc.'gif';
		else
			$srr="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";
		echo '<h1>'.htmlspecialchars_decode($pRow['name']).'</h1>';
		$c=preg_replace('/\\\\\|\/</','<',htmlspecialchars_decode(preg_replace('/<br>/','',$pRow['content'])));
		$test = new DOMDocument('1.0');
		$test->preserveWhiteSpace = FALSE;
		$test->loadXML($c);
		$test->formatOutput = TRUE;
		$c=simplexml_import_dom($test);
		if($c->g!=0)
			$buf=$c->g;
		else
			$buf='для всіх класів';
		echo '<p>
			Клас: '.$c->g;
			if(strlen($pRow['category'])>0)
				echo ', Категорія: '.$pRow['category'];
		echo '</p>';
		$i=1;
		foreach ($c->t as $test) {
			echo '<br><hr><br>
			<div class="addableContentDiv">
				'.$i.'. '.$test->q.'
				<div class="questions">';
				$ii=1;
					foreach ($test->v as $var) {
						$ansv.=$var->c;
						echo '<div class="input-group">
							<input type="checkbox" class="l" name="test_'.$i.'_select_'.$ii.'" value="1">
							<label class="control-label" for="test_'.$i.'_select_'.$ii.'">
								'.$var->d.'
							</label>
						</div>';
						$ii++;
					}
					$ansv.='2';
				echo '</div>
			</div>';
			$i++;
		}
		echo '<input type="hidden" name="base" value="'.base_convert($ansv,3,36).'">';?>
		<input type="button" onclick="check()" class="btn btn-success" value="Перевірити">
		<input type="button" onclick="reset()" class="btn btn-success" value="Скинути">
		<div class="form-group" id="result"></div>
		<script>
			base2=parseInt($('input[name="base"]').val(),36).toString(3);
			base=new Array();
			for(count=0,real=0,start=0,i=0;i<base2.length;i++){
				if(count!=0 && base2[i]=='2'){
					base[real]=base2.substring(start,start+count);
					real++;
					count=0;
					start=i+1;
				}
				else
					count++;
			}
			error=0;
			function check(){
				error=0;
				$('label').css('color','#000');
				for(i=1;i<=real;i++){
					buf=$('.addableContentDiv:nth-of-type('+i+') .questions .input-group').length;
					correct=true;
					was=false;
					for(ii=1;ii<=buf;ii++){
						buf2=$('input[name="test_'+i+'_select_'+ii+'"]').prop("checked");
						if(base[i-1][ii-1]==1 && buf2)
							$('label[for="test_'+i+'_select_'+ii+'"]').css('color','#0a2');
						else if(buf2) {
							$('label[for="test_'+i+'_select_'+ii+'"]').css('color','#a02');
							correct=false;
						}
						if(buf2)
							was=true;
					}
					if(!correct || !was)
						error++;
				}
				$('#result').html(real-error+' відповідей з '+real+' є правильними - ('+Math.round((100*(real-error)/real) * Math.pow(10, 2)) / Math.pow(10, 2)+'%)');
			}
			function reset(){
				$('.input-group input').prop('checked', false);
				$('#result').html('');
				$('label').css('color','#000');
			}
		</script>
		<?php echo '<br><hr>
		<a href="'.LINK.'profile/?id='.$cr.'">
			<div class="chip">
  		<img class="l" src="'.$srr.'">
  		'.$creator_name.' / '.$pRow['date'].'
			</div>
		</a>
		<p class="text-right">Перегляди: '.$pRow['views'].'</p>';
		echo '</div>';
		down();?>
	</body>
<html>