<!DOCTYPE html>
<html>
	<head>
		<title>TODOs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<style>
			.l {
				float: left;
			}
			.r {
				float: right;
			}
			header h1 {
				line-height: 5vh;
				margin: 2vh 0;
				font-size: 5vh;
			}
			#appendableContent {
				min-height: 84vh;
				padding-bottom: 1vh;
			}
			label {
				margin: 0;
				display: block;
				float: left;
			}
			input[type="checkbox"] {
				display: none;
			}
			span {
				width: 4vh;
				height: 4vh;
				margin: 0 !important;
				border: .2vh solid #ccc;
			}
			input:checked ~ span {
				background: #ccc;
			}
			.post {
				padding-bottom: 1vh;
				clear: both;
				position: relative;
				display: flex;
			}
			input[type="text"] {
				padding: 0 1VH 0 1vh;
				font-size: 3vh;
				line-height: 4vh;
				border: none;
				outline: none;
				position: relative;
				flex: 1 1 auto;
			}
			input:checked ~ input[type="text"] {
				text-decoration: line-through;
				color: #ccc;
			}
			::placeholder {
				color: #ccc;
				opacity: 1;
			}
			:-ms-input-placeholder {
				color: #ccc;
			}
			::-ms-input-placeholder {
				color: #ccc;
			}
			.btn-delete {
				width: 4vh;
				height: 4vh;
				margin: 0 !important;
				border: .2vh solid #ccc;
				display: block;
				float: left;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<header class="text-center">
				<h1>TODOs</h1>
			</header>
			<div class="row">
				<div class="col-xs-12" id="appendableContent"> <?php
					$d=array_filter(explode('>^',$_COOKIE['todos_data']));
					foreach($d as $data){
						$current=explode('^>',$data);
						if($current[2] && date('z',time())-date('z',$current[2])!=1){
							$buf1=true;
							$buf2=' post';
						}
						else
							$bif1=$buf2=NULL;
						if($current[0] && (!$current[2] || $buf1))
							$buf=' checked';
						else
							$buf=NULL; ?>
						<div class="post<?=$buf2?>">
							<input type="checkbox"<?=$buf?>>
							<span class="checkbox"></span>
							<input type="text" placeholder="To do something" value="<?=$current[1]?>">
							<button class="btn btn-delete">X</button>
						</div> <?php
					} ?>
				</div>
				<div class="fixedOnbottom">
					<button id="addT" class="l btn btn-lg">Add task</button>
					<button id="addR" class="r btn btn-lg">Add routine</button>
				</div>
			</div>
			<script>
				upd();
				function upd(){
					span=$('span');
				}
				function getEl(type=0){
					if(type)
						buf=' routine';
					else
						buf='';
					return `<div class="post`+buf+`">
						<input type="checkbox">
						<span class="checkbox"></span>
						<input type="text" placeholder="To do something">
						<button class="btn btn-delete">X</button>
					</div>`;
				}
				$('#addT').click(function(){
					$('#appendableContent').append(getEl());
					upd();
				})
				$('#addR').click(function(){
					$('#appendableContent').append(getEl(1));
					upd();
				})
				$('body').on('click','.btn-delete',function(){
					$(this).parent().remove();
					updateData();
				})
				$('body').on('change','input',function(){
					updateData();
				})
				function updateData(){
					upd();
					data='';
					var d = new Date();
					$('.post').each(function(){
						if($(this).find('input[type="checkbox"]').is(":checked"))
							buf=1;
						else
							buf=0;
						if($(this).hasClass('routine'))
							buf2='^>'+d.getTime();
						else
							buf2='';
						data+=buf+'^>'+$(this).find('input[type="text"]').val()+buf2+'>^';
					})
					d.setTime(d.getTime() + (366 * 24 * 60 * 60 * 1000));
					var expires = "expires="+d.toUTCString();
					document.cookie = "todos_data = " + data + ";" + expires;
				}
				$('body').on('click','span',function(){
					updateData();
					if($(this).prev().is(":checked"))
						$(this).prev().prop('checked', false);
					else
						$(this).prev().prop('checked', true);
				});
			</script>
		</div>
	</body>
</html>