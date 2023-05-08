<?php

class ErrorsController {

	public function action404($uri){
		$uri = base64_decode($uri);
		echo '<br><br><br>404<br>';var_dump($uri);

		return true;
	}
}