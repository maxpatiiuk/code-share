<?php $sql = new \Api\sql('MYSQL_HOST', 'MYSQL_USER', 'MYSQL_PASSWORD', 'MYSQL_DATABASE', Site::$tables,
	Site::$specialSymbol, Site::$createTables);