<!DOCTYPE html>
<html>
	<head>
		<style>
			* {
				text-align: center;
			}
			.c {
				border: 1px solid #bbb;
				float: left !important;
				box-sizing: border-box !important;
			}
			.now {
				-webkit-animation: blank 1s 999999999 linear;
			}
			@-webkit-keyframes blank {
				0% {
					border-color: #000;
				}
				50% {
					border-color: #000;
				}
				51% {
					border-color: #fff;
				}
				100% {
					border-color: #fff;
				}
			}
			.p1 {
				background: #3f0;
			}
			.p2 {
				background: #f30;
			}
			.p3 {
				background: #0ff;
			}
			.p4 {
				background: #ff0;
			}
			.win {
				padding: 107px;
				line-height: 48vw;
				height: 30vw;
				font-size: 10vw;
				margin: 50vh 0;
			}
			img.menu {
				cursor: pointer;
				width: 210px;
				height: 210px;
				border: 5px solid #777;
			}
			img.menu.cur {
				border-color: #f00;
			}
			form {
				margin: auto;
			}
			.controls {
				padding: 2px 0;
			}
		</style>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>
	<body>
		<?php if(isset($_POST['pl']) && isset($_POST['sz']) && isset($_POST['pl']) && isset($_POST['go'])){
			$pl=$_POST['pl']+1;
			$sz=$_POST['sz'];
			$pla=$_POST['pla']+1;
			if($sz==0)
				$sz=5;
			else if($sz==1)
				$sz=9;
			else if($sz==2)
				$sz=14;
			else if($sz==3)
				$sz=19;
			if($pla>=3 && ($pl==2 || $pl==4))
				$pla=2;
			else if($pla==4 && $pl==3)
				$pla=3;
			if($sz+1==6)
				$vw=4;
			else if($sz+1==10)
				$vw=3;
			else if($sz+1==15)
				$vw=2;
			else if($sz+1==20)
				$vw=1.5;
			echo '<style> .c { font-size:'.$vw.'vw; } </style>';
			$_POST['pl']=$_POST['sz']=NULL;
			for($i=1;$i<$sz+2;$i++){
			echo '<div class="a" id="a'.$i.'">';
			for($ii=1;$ii<$sz+2;$ii++){
				if($i==2 && $ii==2 && $pl!=2)
					echo '<div class="c p1 now" id="c'.$ii.'">O</div>';
				else if(($i==2 && $ii==2) || ($i==2 && $ii==$sz && $pl==2))
					echo '<div class="c p2 now" id="c'.$ii.'">O</div>';
				else if($i==$sz && $ii==2 && ($pl==1 || $pl==3))
					echo '<div class="c p2" id="c'.$ii.'">O</div>';
				else if($i==$sz && $ii==2 && $pl==2)
					echo '<div class="c p3" id="c'.$ii.'">O</div>';
				else if(($i==$sz && $ii==2 && $pl==4) || ($i==$sz && $ii==$sz && $pl==3) || ($i==2 && $ii==$sz && $pl==4))
					echo '<div class="c" id="c'.$ii.'"></div>';
				else if($i==$sz && $ii==$sz && $pl!=3)
					echo '<div class="c p3" id="c'.$ii.'">O</div>';
				else if($i==2 && $ii==$sz && ($pl==1 || $pl==3))
					echo '<div class="c p4" id="c'.$ii.'">O</div>';
				else
					echo '<div class="c" id="c'.$ii.'"></div>';
			}
			echo '</div>';
		} ?>
		<p id="debug" style="position: absolute;"></p>
		<p id="debug2" style="position: absolute;bottom:0;"></p>
		<p id="debug3" style="text-align:right;position: absolute;right:0;"></p>
		<script>
		$(document).ready(function(){
			pl=<?=$pl?>;
			plB=pl;
			player=<?=$pla?>;
			if(pl!=2)
				pl=1;
			sz=100/<?=$sz+1?>;
			$('.c').css({'height':sz+'vh','width':sz+'vw','line-height':sz+'vh'});
			$('.c').click( function(){
				if(pl==pla() && $(this).hasClass('p'+pl)){
					$(this).append('O');
					cont(this,'p'+pl);
					pla(1);
					$('#debug3').append(pl);
					$('.p'+pl).addClass('now');
				}
			});
		});
		function bot(pl=2){

		}
		function pla(ii=0){
			i=pl;
			while($('.p'+i).length==0){
				i=i%4+1;
				if(player<=1 && i==2){
					bot(2);
					pl=i;
					pla(1);
				}
				if(player<=2 && i==3){
					bot(3);
					pl=i;
					pla(1);
				}
				if(player<=3 && i==4 && plB!=2 && plB!=4){
					bot(4);
					pl=i;
					pla(1);
				}
			}
			if(ii==1){
				i=i%4+1;
				$('#debug2').append('i'+i);
				if(player<=1 && i==2){
					bot(2);
					pl=i;
					if(plB==2)
						pl=2;
					else
						pla(1);
				}
				else if(player<=1 && i==3){
					bot(3);
					pl=1;
				}
				else if(player<=2 && i==3){
					bot(3);
					pl=i;
					if(plB==2 || plB==4)
						pl=2;
					else
						pla(1);
				}
				else if(player<=3 && i==4 && plB!=2 && plB!=4){
					bot(4);
					pl=i;
					pla(1);
				}
				$('#debug2').append('i'+i);
				while($('.p'+i).length==0){
					$('#debug2').append('i'+i);
					$('#debug2').append('p'+player);
					i=i%4+1;
				}
				$('#debug').append(i);
				pl=i;
			}
			else
				return i;
			if($('.p1,.p2,.p3').length==0)
				$('body').html('<span class="win p4">Yellow win!</span>');
			if($('.p4,.p2,.p3').length==0)
				$('body').html('<span class="win p1">Green win!</span>');
			if($('.p1,.p4,.p3').length==0)
				$('body').html('<span class="win p2">Red win!</span>');
			if($('.p1,.p2,.p4').length==0)
				$('body').html('<span class="win p3">Blue win!</span>');
		}
		function mac(el) {
			if($(el).html().length>3)
				return 1;
			else
				return 0;
		}
		function l(el,color){
			if($(el).length!=0){
				$(el).removeClass('p1 p2 p3 p4').addClass(color).append('O');
				if(mac(el))
					cont(el,color);
			}
		}
		function cont(side,color){
			if(mac(side)){
				$(side).removeClass('p1 p2 p3 p4').html('');
				sc=($(side).index())+1;
				sa=($(side).parent().index());
				sc1=sc-1;
				sc2=sc+1;
				sa1=sa-1;
				sa2=sa+1;
				var a=$('#a'+sa+' > #c'+sc1);
				var b=$('#a'+sa+' > #c'+sc2);
				var c=$('#a'+sa1+' > #c'+sc);
				var d=$('#a'+sa2+' > #c'+sc);
				l(a,color);
				l(b,color);
				l(c,color);
				l(d,color);
				cont(side,color);
			}
			$('.c:not(.p1,.p2,.p3,.p4)').html('');
			$('.c').removeClass('now');
		}
		</script>
		<?php } else { ?>
			<form method="post" action="d3_19.php">
				<div class="controls">
					<img class="menu pl cur" src="https://s8.hostingkartinok.com/uploads/images/2017/08/573e520d2a04dfdb66a4d553860eaa1e.png">
					<img class="menu pl" src="https://s8.hostingkartinok.com/uploads/images/2017/08/84aff465090229e4136f5612e5638dcf.png">
					<img class="menu pl" src="https://s8.hostingkartinok.com/uploads/images/2017/08/6726d15a03abd7b4d79b43908e579495.png">
					<img class="menu pl" src="https://s8.hostingkartinok.com/uploads/images/2017/08/a610393438951097f65531b4bdec119b.png">
				</div>
				<div class="controls">
					<img class="menu sz cur" src="https://s8.hostingkartinok.com/uploads/images/2017/08/4a8744eb21f03764cff93d348aca29d9.png">
					<img class="menu sz" src="https://s8.hostingkartinok.com/uploads/images/2017/08/82c7ac5786844293730f7bbb9f6c1ce9.png">
					<img class="menu sz" src="https://s8.hostingkartinok.com/uploads/images/2017/08/c52e552ee91b41b74bb9f6451a628283.png">
					<img class="menu sz" src="https://s8.hostingkartinok.com/uploads/images/2017/08/f3d942baecab2e06f3de0ee71f94a7b1.png">
				</div>
				<div class="controls">
					<img class="menu pla cur" src="https://s8.hostingkartinok.com/uploads/images/2017/11/c93f70c88b45b0c5ca586f21ae21aebb.png">
					<img class="menu pla" src="https://s8.hostingkartinok.com/uploads/images/2017/11/f29c51a7ea43643151328c488e98b7c1.png">
					<img class="menu pla" src="https://s8.hostingkartinok.com/uploads/images/2017/11/9d85e21ed263ccfe9e6892c96eb40f0b.png">
					<img class="menu pla" src="https://s8.hostingkartinok.com/uploads/images/2017/11/c67a807801797473fa211ec96a591d97.png">
					</label>
				</div>
				<input type="hidden" name="pl" id="pl" value="0">
				<input type="hidden" name="sz" id="sz" value="0">
				<input type="hidden" name="pla" id="pla" value="0">
				<button name="go" class="btn btn-lg btn-primary" id="go">Play</button>
			</form>
			<div class="debuging"></div>
		<script>
			elSz=$('img.menu.sz');
			elPl=$('img.menu.pl');
			elPla=$('img.menu.pla');
			$(elPl).eq(0).click(function(){
				$(elPla).show();
				$(elPl).removeClass('cur');
				$(elPl).eq(0).addClass('cur');
				$('#pl').val(0);
			})
			$(elPl).eq(1).click(function(){
				$(elPla).eq(2).hide();
				$(elPla).eq(3).hide();
				$(elPl).removeClass('cur');
				$(elPl).eq(1).addClass('cur');
				$('#pl').val(1);
				if($(elPla).eq(2).hasClass('cur') || $(elPla).eq(3).hasClass('cur')){
					$(elPla).removeClass('cur');
					$(elPla).eq(1).addClass('cur');
					$('#pla').val(1);
				}
			})
			$(elPl).eq(2).click(function(){
				$(elPla).eq(2).show();
				$(elPla).eq(3).hide();
				$(elPl).removeClass('cur');
				$(elPl).eq(2).addClass('cur');
				$('#pl').val(2);
				if($(elPla).eq(3).hasClass('cur')){
					$(elPla).removeClass('cur');
					$(elPla).eq(2).addClass('cur');
					$('#pla').val(2);
				}
			})
			$(elPl).eq(3).click(function(){
				$(elPla).eq(2).hide();
				$(elPla).eq(3).hide();
				$(elPl).removeClass('cur');
				$(elPl).eq(3).addClass('cur');
				$('#pl').val(3);
				if($(elPla).eq(2).hasClass('cur') || $(elPla).eq(3).hasClass('cur')){
					$(elPla).removeClass('cur');
					$(elPla).eq(1).addClass('cur');
					$('#pla').val(1);
				}
			})
			$(elSz).eq(0).click(function(){
				$(elSz).removeClass('cur');
				$(elSz).eq(0).addClass('cur');
				$('#sz').val(0);
			})
			$(elSz).eq(1).click(function(){
				$(elSz).removeClass('cur');
				$(elSz).eq(1).addClass('cur');
				$('#sz').val(1);
			})
			$(elSz).eq(2).click(function(){
				$(elSz).removeClass('cur');
				$(elSz).eq(2).addClass('cur');
				$('#sz').val(2);
			})
			$(elSz).eq(3).click(function(){
				$(elSz).removeClass('cur');
				$(elSz).eq(3).addClass('cur');
				$('#sz').val(3);
			})
			$(elPla).eq(0).click(function(){
				$(elPla).removeClass('cur');
				$(elPla).eq(0).addClass('cur');
				$('#pla').val(0);
			})
			$(elPla).eq(1).click(function(){
				$(elPla).removeClass('cur');
				$(elPla).eq(1).addClass('cur');
				$('#pla').val(1);
			})
			$(elPla).eq(2).click(function(){
				$(elPla).removeClass('cur');
				$(elPla).eq(2).addClass('cur');
				$('#pla').val(2);
			})
			$(elPla).eq(3).click(function(){
				$(elPla).removeClass('cur');
				$(elPla).eq(3).addClass('cur');
				$('#pla').val(3);
			})
			$('body').css({'display':'flex','background':'#ccc'});
			$('html, body').css('height','100%');
		</script>
		<?php } ?>
	</body>
</html>