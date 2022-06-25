<?= Data::$closing_tags ?>
<script src="<?= Site::link('public/scripts/main' . Data::$js_ext) ?>"></script>	</body></html>

<?php
global $sql;
$sql->disconect();
session_write_close();