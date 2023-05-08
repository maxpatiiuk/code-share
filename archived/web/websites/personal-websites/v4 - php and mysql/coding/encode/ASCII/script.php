<!-- ASCII Encode -->
<!DOCTYPE html">
<html>
	<head>
		<?php
		$result=$_POST['textfield'];
		$lang = $_GET['lang'];
		include "../../data.php";
		if($lang=="ua"){
			include "../head_ua.php";
			top_ua(9);
			$l=0;
		}
		else {
			include "../head_en.php";
			top_en(9);
			$l=1;
		}
		head("../../");
		?>
			<script>
			var m_sRusB = "ЙЦУКЕНГШЗХФЫВАПРОЛДЖЭЧСМИТЬБЪ";
			var m_sLatB = "ICUKENGWZHFYVAPROLDJE4SMIT^B&";
			var m_sRusBX  = "ЩЯЮЁ";
			var m_asLatBX = new Array("TSH", "YA", "YU","YO");
			var m_sRusS = "йцукенгшзхфывапролджэчсмитьбъ";
			var m_sLatS = "icukengwzhfyvaproldje4smit^b&";
			var m_sRusSX = "щяюё";
			var m_asLatSX = new Array("tsh", "ya", "yu", "yo");

			function RusLatTranliter()
			{
			  var sTextRu = document.formCyrToLat.elements["txtBoxCyr"].value;
			  var nLen = sTextRu.length;
			  var ni=0, nj=0;
			  var nLenB = m_sRusB.length;  
			  var nLenBX = m_sRusBX.length; 
			  var sTextLat = "";
			  for (ni=0; ni<nLen; ni++)
			  {
				var chi = sTextRu.charAt(ni);
				var bFind = false;
				for (nj=0; nj<nLenB; nj++)
				{
				  if (chi == m_sRusS.charAt(nj))
				  {
				  sTextLat += m_sLatS.charAt(nj);
					bFind = true;
					break;
				  }
				}
				if (bFind) continue;
				for (nj=0; nj<nLenBX; nj++)
				{
				  if (chi == m_sRusSX.charAt(nj))
				  {
					sTextLat += m_asLatSX[nj];
					bFind = true;
					break;
				  }
				}
				if (bFind) continue;
				for (nj=0; nj<nLenB; nj++)
				{
				  if (chi == m_sRusB.charAt(nj))
				  {
					sTextLat += m_sLatB.charAt(nj);
					bFind = true;
					break;
				  }
				}
				if (bFind) continue;
				for (nj=0; nj<nLenBX; nj++)
				{
				  if (chi == m_sRusBX.charAt(nj))
				  {
					sTextLat += m_asLatBX[nj];
					bFind = true;
					break;
				  }
				}
				if (bFind) continue;
				sTextLat += chi; 
			  }
			  document.formCyrToLat.elements["txtBoxLat"].value = sTextLat;
			}
		</script>
		
	</head>
	
	<body>
		<div class="content">
			<center>

			<form name="formCyrToLat"> 
				<h1><?=$cont[6][$l]?></h1><br><br> 
				<textarea name="txtBoxCyr" rows="16" cols="64"></textarea><br><br>
				<input class="button default" type="button" name="RusLat" value="<?=$cont[7][$l]?>" onclick="RusLatTranliter();"> 
				<input class="button default" type="reset" name="Reset" value="<?=$cont[8][$l]?>"> 
				<br><br>
				<b><?=$cont[9][$l]?></b><br>
				<br>
				<textarea name="txtBoxLat" rows="16" cols="64" id="Textarea1"></textarea>  <br><br>
			</form>
			</table>
			</div>
			<?php
	
			/*
			
			
			<textarea name="name"cols="30" rows="10"></textarea>
			<br><a href="#">Трансформувати</a>
			<div></div>
			
			
			echo $result;
			var_dump($result);
			<form name="form1" method="post" action="script.php">
				<textarea name="textarea" cols="40" rows="10"></textarea>
				<input class="but" type="button" value="<?=$cont[7][$l]?>" /> 
				<input class="but" type="reset" value="<?=$cont[8][$l]?>" /> 
			</form>
			
			
			
			<form name="formCyrToLat"> 
				<textarea name="txtBoxCyr" rows="16" cols="64"></textarea> 
				<input class="button default" type="button" name="RusLat" value="<?=$cont[7][$l]?>" onclick="RusLatTranliter();" /> 
				<input class="button default" type="reset" name="Reset" value="<?=$cont[8][$l]?>" /> 
				<b><?=$cont[9][$l]?></b>
				<textarea name="txtBoxLat" rows="16" cols="64" id="Textarea1"></textarea>
			</form>


			<form method="post" action="script.php">
				<h1><?=$cont[6][$l]?></h1>
				<textarea class="content" name="transfer"></textarea>
				<input class="button default" type="button" onclick="save();" name="RusLat" value="<?=$cont[7][$l]?>" /> 
				<input class="button default" type="reset" name="Reset" value="<?=$cont[8][$l]?>" /> 
			</form>
			*/
			?>
			</center>
		</div>
	</body>
</html>