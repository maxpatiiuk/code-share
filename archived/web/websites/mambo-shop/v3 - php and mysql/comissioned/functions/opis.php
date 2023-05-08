<?php	
function opis($name,$iframe,$img1,$img2,$img3,$img4,$link,$price) {
	echo "
	<div class=\"title33\"><font size=\"5\">$name</font></div>
	<div class=\"opis\">
		<iframe allowfullscreen=\"\" class=\"iframe\" frameborder=\"0\" src=\"$iframe\" ></iframe>
		<div class=\"images\">
			<div class=\"top_c\">
				<img class=\"img1\" align=\"bottom\" src=\"$img1\" />
				<img class=\"img2\" src=\"$img2\" />
				<img class=\"img3\" src=\"$img3\" />
			</div>
			<div class=\"bot_c\">
				<a class=\"buyy1 aw\" href=\"$link\">КУПИТИ</a>
				<div class=\"buyy2\"><br>$price<font size=\"2\"> грн</font></div>
				<img class=\"img4\" src=\"$img4\" />
			</div>
		</div>
	</div>
	<div class=\"cont\">
		<div class=\"desc\">
			<font color=\"black\" size=\"2\">
				<div class=\"tabs2\">
					<ul>
						<li>Опис</li>
						<li>Інструкція</li>
						<li>Системні вимоги</li>
					</ul>
					<div>
						<div>
							<div class=\"shotab1\">
							";	
}
?>