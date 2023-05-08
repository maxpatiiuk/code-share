<?php

include_once ROOT.'models'.DIRECTORY_SEPARATOR.'News.php';

class NewsController {

	public function actionView($id){
		if($id){
			$newsItem = News::getListById($id);
			echo var_dump($newsItem);
			if($newsItem === false){
				require_once(Helper::root("controllers/ErrorsController.php"));
				$error = new ErrorsController();
				$error->action404(base64_encode("news/" . $id));
			}
		}

		return true;
	}

	public function actionIndex(){
		$newsList = News::getNewsList();
		echo var_dump($newsList);

		return true;

	}
}