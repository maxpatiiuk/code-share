		<?php
		if(Data::formatData('container') === true)
			echo '</div>';
		?>
		<script src="<?=Site::link('public/scripts/main'.Data::$jsExt)?>"></script>
	</body>
</html>

<?php
global $sql;
$sql->disconect();
session_write_close();