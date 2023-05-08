<?php global $l;
$l=array(
	'close'=>array('Закрити','Закрить','Close','Test'),
	'sqlInjection'=>array('Будь ласка заберіть наступні слова','','Please remove this words',''),
	'basket'=>array('Корзина','','',''),
	'profile'=>array('Профіль','','',''),
	'logOut'=>array('Вийти','','',''),
	'logIn'=>array('Вхід','','',''),
	'register'=>array('Реєстрація','','',''),
	'aboutUs'=>array('ПРО НАС','','',''),
	'aboutUsText'=>array('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni,ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.','','',''),
	'tel'=>array('Телефони','','',''),
	'adress'=>array('Адреса','','',''),
	'socialM'=>array('Ми в соцмережах','','',''),
	'contacts'=>array('КОНТАКТИ','','',''),
	'feedback'=>array('ВІДГУКИ','','',''),
	'yourName'=>array('Ваше ім\'я','','',''),
	'yourEmail'=>array('Ваша електронна адреса','','',''),
	'message'=>array('Повідомлення','','',''),
	'welcome'=>array('Запрошуємо в','','',''),
	'commentError1'=>array('Помилка при додаванні коментаря. Спробуйте не використовувати латинські букви','','',''),
	'commentError2'=>array('Помилка при додаванні коментаря. Спробуйте не використовувати спеціальні символи','','',''),
	'commentSuccess'=>array('Коментарь успішно додано. Дякуємо!','','',''),
	'anonim'=>array('Анонімно','','',''),
	'sendMessage'=>array('Написати','','',''),
	'enterValidEmail'=>array('Вкажіть правильну email адресу','','',''),
	'enterValidName'=>array('Вкажіть правильне ім\'я','','',''),
	'enterValidMessage'=>array('Вкажіть правильний текст повідомлення. (захист від SQL інєкції наявний)','','',''),
	'sendSuccess'=>array('Ваше повідомлення надіслано успішно. Дякую!','','',''),
	'writeMessage'=>array('Написати повідомлення','','',''),
	'buy'=>array('Купити','','',''),
	'share'=>array('Поділитися','','',''),
	'showMore'=>array('Показати ще','','','')
);
function la($name){
	global $l;
	return $l[$name][_LANGUAGE_-1];
}?>