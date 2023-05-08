#include <iostream>
#include <time.h>
#include <locale.h>
#include <string>
#include <windows.h>
#include <conio.h>
#include <stdio.h>
#include <stdlib.h>
#include <fstream>
using namespace std;
bool ev_played, is_beta, is_main_b = 0, is_unemp = 0, is_inv = 0, is_1000 = 1, h_t[9], h_s[9], h_e[9], h_h[13], h_n[6], h_b[6], iiii;
__int16 nom_menu, nom_menu2, curs = 30, date[3], s_date[3], dif, s_dif = 1, l_dif, die = 0, food, nast, heard, botle = 5, amulet_d = 0, h_d2[6], h_date[10], upd[5], h_v_d[5];
__int64 money, s_money = 100, score, s_score = 0, money2, s_money2 = 0, botles, i, ii, iii;
const string save = "settings";
void menu();
void SetColor(int text, int background)
{
	HANDLE hStdOut = GetStdHandle(STD_OUTPUT_HANDLE);
	SetConsoleTextAttribute(hStdOut, (WORD)((background << 4) | text));
}
void title(char str[]) {
	for (ii = 0; ii<56; ii++)
		cout << ' ';
	cout << str << endl;
	for (ii = 0; ii<119; ii++)
		cout << '=';
	cout << endl;
}
void decor(char a) {
	for (ii = 0; ii<119; ii++)
		cout << a;
}
void g_save_p() {
	ifstream g_save(save);
	if (g_save.is_open() == 1 && ev_played == 1) {
		g_save >> ev_played >> is_beta >> is_main_b >> is_unemp >> is_inv >> is_1000 >> iiii >> nom_menu >> nom_menu2 >> curs >> dif >> s_dif >> l_dif >> die >> food >> nast >> heard >> botle >> money >> s_money >> score >> s_score >> money2 >> s_money2 >> botles >> i >> ii >> iii;
		money = money - 93758;
		money2 = money2 - 13526;
		score = score - 49637;
		for (i = 0; i < 8; i++) {
			g_save >> h_t[i];
		}
		for (i = 0; i < 9; i++) {
			g_save >> h_s[i];
		}
		for (i = 0; i < 9; i++) {
			g_save >> h_e[i];
		}
		for (i = 0; i < 13; i++) {
			g_save >> h_h[i];
		}
		for (i = 0; i < 10; i++) {
			g_save >> h_date[i];
		}
		for (i = 0; i < 6; i++) {
			g_save >> h_d2[i];
		}
		for (i = 0; i < 6; i++) {
			g_save >> h_b[i];
		}
		for (i = 0; i < 5; i++) {
			g_save >> h_n[i];
		}
		for (i = 0; i < 5; i++) {
			g_save >> upd[i];
		}
		for (i = 0; i < 5; i++) {
			g_save >> h_v_d[i];
		}
	}
	else {
		money = s_money;
		money2 = s_money2;
		date[1] = s_date[1];//рiк
		date[2] = s_date[2];//мiсяць
		date[3] = s_date[3];//день
		dif = s_dif;
		money = s_money;
		score = s_score;
		if (dif == 0) {
			heard = 100;
			food = 100;
			nast = 100;
		}
		if (dif == 1) {
			heard = 65;
			food = 65;
			nast = 65;
		}
		if (dif == 2) {
			heard = 50;
			food = 50;
			nast = 50;
		}
		if (dif == 3) {
			heard = 25;
			food = 25;
			nast = 25;
		}
		if (is_1000 == 0) {
			heard = 0;
			food = 0;
			nast = 0;
			money = 50;
		}
		botle = 7 + rand() % 2 - 1;
		for (i = 0; i<8; i++) {
			h_t[i] = 0;
		}
		for (i = 0; i<9; i++) {
			h_s[i] = 0;
		}
		for (i = 0; i<9; i++) {
			h_e[i] = 0;
		}
		for (i = 0; i<13; i++) {
			h_h[i] = 0;
		}
		for (i = 0; i<10; i++) {
			h_date[i] = 0;
		}
		for (i = 0; i<6; i++) {
			h_d2[i] = 0;
		}
		for (i = 0; i<6; i++) {
			h_b[i] = 0;
		}
		for (i = 0; i<5; i++) {
			h_n[i] = 0;
		}
		for (i = 0; i<5; i++) {
			upd[i] = 0;
		}
		for (i = 0; i<5; i++) {
			h_v_d[i] = 0;
		}
		is_main_b = 0;
		is_unemp = 0;
		is_inv = 0;
	}
	g_save.close();
}
void g_save_h() {
	ofstream g_save(save);
	g_save << ev_played << endl << is_beta << endl << is_main_b << endl << is_unemp << endl << is_inv << endl << is_1000 << endl << iiii << endl << nom_menu << endl << nom_menu2 << endl << curs << endl << dif << endl << s_dif << endl << l_dif << endl << die << endl << food << endl << nast << endl << heard << endl << botle << endl << money + 93758 << endl << s_money << endl << score + 49637 << endl << s_score << endl << money2 + 13526 << endl << s_money2 << endl << botles << endl << i << endl << ii << endl << iii << endl;
	for (i = 0; i<8; i++) {
		g_save << h_t[i] << endl;
	}
	for (i = 0; i<9; i++) {
		g_save << h_s[i] << endl;
	}
	for (i = 0; i<9; i++) {
		g_save << h_e[i] << endl;
	}
	for (i = 0; i<13; i++) {
		g_save << h_h[i] << endl;
	}
	for (i = 0; i<10; i++) {
		g_save << h_date[i] << endl;
	}
	for (i = 0; i<6; i++) {
		g_save << h_d2[i] << endl;
	}
	for (i = 0; i<6; i++) {
		g_save << h_b[i] << endl;
	}
	for (i = 0; i<5; i++) {
		g_save << h_n[i] << endl;
	}
	for (i = 0; i<5; i++) {
		g_save << upd[i] << endl;
	}
	for (i = 0; i<5; i++) {
		g_save << h_v_d[i] << endl;
	}
	g_save.close();
}
void first_menu() {
m:
	ifstream g_save(save);
	if (g_save.is_open())
		g_save >> ev_played;
	g_save.close();
	system("CLS");
	title("Меню");
	if (ev_played == 1) {
		cout << " 1. Продовжити гру" << endl;
		cout << " 2. Почати нову гру" << endl;
		cout << " 3. Зберегти гру" << endl;
		cout << " 4. Допомога" << endl;
		cout << " 5. Налаштування" << endl;
		cout << " 6. Про гру" << endl;
		cout << " 7. Вихiд" << endl;
	}
	else {
		cout << " 1. Почати нову гру" << endl;
		cout << " 2. Зберегти гру" << endl;
		cout << " 3. Допомога" << endl;
		cout << " 4. Налаштування" << endl;
		cout << " 5. Про гру" << endl;
		cout << " 6. Вихiд" << endl;
	}
	decor('=');
	cout << endl;
	cin >> nom_menu;
	if (ev_played == 1)
		nom_menu--;
	system("CLS");
	switch (nom_menu) {
	case 0:
		menu();
		break;
	case 1:
		ev_played = 0;
		menu();
		break;
	case 2:
		title("Збереження");
		g_save_h();
		cout << "Гра успiшно збережена." << endl;
		decor('=');
		system("pause");
		goto m;
		break;
	case 3:
		title("Довiдка");
		cout << endl << "Керування в данiй грi вiдбувається наступним чином:" << endl << "   1. Прочитайте пункти" << endl << "   2. Введiть номер потрiбного пункту" << endl << "   3. Нажмiть клавiшу ""Enter""." << endl;
		cout << endl << "Якщо ви побачите текст ''нажмiть любу клавiшу щоб продовжити'', або подiбне повiдомлення, вам потрiбно натиснути любу " << endl << "клавiшу (наприклад Enter), щоб продовжити грати, виконати певну дiю, або щось iнше (в залежностi вiд ситуацiї).\n\nСуть гри заключається в купiвлi всiх можливих бiзнесiв, транспортних засобiв, отримання 100 життя, 100 настрою та 100 \nситостi\n";
		decor('=');
		system("pause");
		goto m;
		break;
	case 4:
		system("CLS");
a:		title("Налаштування");
		cout << "1. Кiлькiсть грошей при стартi (вiд 0 до 5 000)(Зараз:  " << s_money << ")." << endl;
		cout << "2. Рiк при стартi (вiд 1980 до 2020)(Зараз: " << s_date[1] << ")." << endl;
		cout << "3. Мiсяць при стартi (вiд 3 до 9)(Зараз: " << s_date[2] << ")." << endl;
		cout << "4. День при стартi (вiд 1 до 30)(Зараз: " << s_date[3] << ")." << endl;
		cout << "5. Складнiсть (вiд 0 до 3)(Зараз: " << s_dif << ")." << endl;
		cout << "6. Ввести чит-код" << endl;
		cout << "7. Повернутися в меню" << endl;
		decor('=');
		cin >> nom_menu2;
		system("CLS");
		switch (nom_menu2) {
		case 1:
			system("CLS");
		b:
			cout << "Введiть суму грошей при стартi:" << endl;
			cin >> s_money;
			system("CLS");
			if (s_money < 0) {
				cout << "Мiнiмальна сума - 0" << endl;
				goto b;
			}
			else if (s_money > 5000) {
				cout << "Максимальна сума - 5 000" << endl;
				goto b;
			}
			else
				goto a;
			goto b;
			break;
		case 2:
			system("CLS");
		e:
			cout << "Введiть рiк при стартi:" << endl;
			cin >> s_date[1];
			system("CLS");
			if (s_date[1] < 1980) {
				cout << "Мiнiмальний рiк - 1980" << endl;
				goto e;
			}
			else if (s_date[1] > 2020) {
				cout << "Максимальний рiк - 2020" << endl;
				goto e;
			}
			else
				goto a;
			goto b;
			break;
		case 3:
			system("CLS");
		l:
			cout << "Введiть мiсяць при стартi:" << endl;
			cin >> s_date[2];
			system("CLS");
			if (s_date[2] < 3) {
				cout << "Мiнiмальний мiсяць - 3" << endl;
				goto l;
			}
			else if (s_date[2] > 9) {
				cout << "Максимальний мiсяць - 9" << endl;
				goto l;
			}
			else
				goto a;
			goto b;
			break;
		case 4:
			system("CLS");
		c:
			cout << "Введiть день при стартi:" << endl;
			cin >> s_date[3];
			system("CLS");
			if (s_date[3] < 1) {
				cout << "Мiнiмальнмй день - 1" << endl;
				goto c;
			}
			else if (s_date[3] > 30) {
				cout << "Максимальний день - 30" << endl;
				goto c;
			}
			else
				goto a;
			goto b;
			break;
		case 5:
			system("CLS");
		g:
			cout << "Виберiть складнiсть гри: \n0. Легко.\n1. Нормально.\n2. Важко.\n3. Неможливо. " << endl;
			cin >> s_dif;
			system("CLS");
			if (s_dif < 0) {
				cout << "Мiнiмальна складнiсть - 0" << endl;
				goto g;
			}
			else if (s_dif > 3) {
				cout << "Максимальна складнiсть - 3" << endl;
				goto g;
			}
			else
				goto a;
			goto b;
			break;
		case 6:
			__int16 cheat_k, cheats[3];
			cheats[1] = 3410;
			cheats[2] = 9990;
			cheats[3] = 1000;
			system("CLS");
			cin >> cheat_k;
			system("CLS");
			if (cheat_k == cheats[1]) {
				s_money = 5000;
				s_date[1] = 2020;
				s_date[2] = 3;
				s_date[3] = 30;
				s_dif = 1;
				cout << "Чит 3410 успiшно застосовано" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			if (cheat_k == cheats[2]) {
				s_money = 999999999999999;
				s_score = 5000000000;
				cout << "Чит 9990 успiшно застосовано" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			if (cheat_k == cheats[3]) {
				is_1000 = 0;
				cout << "Чит 1000 успiшно застосовано" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			else
				cout << "Чит не знайдено" << endl;
			system("pause");
			system("CLS");
			goto a;
			goto b;
			break;
		case 7:
			system("CLS");
			goto m;
			break;
		default:
			goto a;
			break;
		}
		break;
	case 5:
		system("CLS");
		title("Про гру");
		cout << "Гра ""S-LIFE Simulator"", створена MAMBO 2017 року. Саме тут ви маєте можливiсть пройти складний та цікавий шляг від бідного до міліардера" << endl << endl << "Версiя гри: 1.0" << endl << endl << "Програма та мова створення гри: Visual Studio 2012, Visual Studio 2015; C++" << endl << endl << "Веб сайт розробника:";
		SetColor(0, 7);
		cout << "www.mambo.zzz.com.ua; www.shop.mambo.zzz.com.ua";
		SetColor(7, 0);
		cout << endl << endl << "Насолоджуйтеся грою!" << endl << endl;
		decor('=');
		system("pause");
		goto m;
		break;
	case 6:
		system("CLS");
		exit(0);
		break;
	default:
		first_menu();
	}
}
void infbar() {
	cout << endl;
	decor('=');
	if (money<0)
		SetColor(12, 0);
	if (money >= 999999999)
		SetColor(11, 0);
	cout << "Гривень: " << money;
	SetColor(7, 0);
	if (money2<0)
		SetColor(12, 0);
	if (money2 == 999999999)
		SetColor(11, 0);
	cout << "\t Доларiв: ";
	SetColor(7, 0);
	cout << money2 << "\t Курс: " << curs << "\t  Цiна за бутилку: " << botle << endl;
	if (heard<20)
		SetColor(12, 0);
	if (heard == 100)
		SetColor(10, 0);
	cout << "Здоров'я: " << heard;
	SetColor(7, 0);
	if (food<20)
		SetColor(12, 0);
	if (food == 100)
		SetColor(10, 0);
	cout << "\t Ситiсть: " << food;
	SetColor(7, 0);
	if (nast<20)
		SetColor(12, 0);
	if (nast == 100)
		SetColor(10, 0);
	cout << "\t Настрiй: " << nast;
	SetColor(7, 0);
	cout << endl << "Дата: ";
	if (date[3] < 10)
		cout << 0;
	cout << date[3] << " : ";
	if (date[2] < 10)
		cout << 0;
	cout << date[2] << " : " << date[1] << "\t Рейтинг: " << score << endl;
	decor('=');
}
void i_gener_f(int r_l1) {
	i = 0;
	if (r_l1 == -3) {
		if (dif == 0) {
			i = rand() % 10 + 5;
		}
		if (dif == 1) {
			i = rand() % 10 + 4;
		}
		if (dif == 2) {
			i = rand() % 9 + 3;
		}
		if (dif == 3) {
			i = rand() % 7 + 3;
		}
		i = -i;
	}
	if (r_l1 == -2) {
		if (dif == 0) {
			i = rand() % 10 + 5;
		}
		if (dif == 1) {
			i = rand() % 7 + 4;
		}
		if (dif == 2) {
			i = rand() % 5 + 3;
		}
		if (dif == 3) {
			i = rand() % 4 + 2;
		}
		i = -i;
	}
	if (r_l1 == -1) {
		if (dif == 0) {
			i = rand() % 10 + 1;
		}
		if (dif == 1) {
			i = rand() % 7 + 2;
		}
		if (dif == 2) {
			i = rand() % 5 + 1;
		}
		if (dif == 3) {
			i = rand() % 3 + 1;
		}
		i = -i;
	}
	if (r_l1 == 1) {
		if (dif == 0) {
			i = rand() % 2;
		}
		if (dif == 1) {
			i = rand() % 3;
		}
		if (dif == 2) {
			i = rand() % 4;
		}
		if (dif == 3) {
			i = rand() % 5;
		}
	}
	if (r_l1 == 2) {
		if (dif == 0) {
			i = rand() % 2 + 1;
		}
		if (dif == 1) {
			i = rand() % 3 + 1;
		}
		if (dif == 2) {
			i = rand() % 4 + 1;
		}
		if (dif == 3) {
			i = rand() % 6 + 1;
		}
	}
	if (r_l1 == 3) {
		if (dif == 0) {
			i = rand() % 4 + 1;
		}
		if (dif == 1) {
			i = rand() % 5 + 1;
		}
		if (dif == 2) {
			i = rand() % 7 + 2;
		}
		if (dif == 3) {
			i = rand() % 10 + 3;
		}
	}
}
void i_gener_l(int vall) {
	if (vall <= 0) {
		die++;
		SetColor(12, 0);
		cout << endl << "Якщо так продовжувати, то ви помрете за декiлька днiв!" << endl;
		SetColor(7, 0);
	}
	if (die>5 && dif == 0 || die>4 && dif == 1 || die>3 && dif == 2 || die>2 && dif == 3) {
		ev_played = 0;
		SetColor(12, 0);
		system("CLS");
		cout << endl << "Ви померли!" << endl;
		SetColor(7, 0);
		system("pause");
		die = 0;
		first_menu();
	}
	if (vall > 100)
		vall = 100;
}
void i_gen(int r1, int r2, int r3) {
	if (money < 0) {
		die++;
	}
	if (money2 < 0) {
		die++;
	}
	if (score < 0) {
		die++;
	}
	if (money<0 || money2<0) {
		SetColor(12, 0);
		cout << endl << "Заробiть грошi, або ви помрете за декiлька днiв!" << endl;
		SetColor(7, 0);
	}
	if (score<0) {
		SetColor(12, 0);
		cout << endl << "Покращiть свiй рейтинг, або вас застрелять!" << endl;
		SetColor(7, 0);
	}
	i_gener_f(r1);
	food = food - i;
	i_gener_l(food);
	i_gener_f(r2);
	nast = nast - i;
	i_gener_l(nast);
	i_gener_f(r3);
	heard = heard - i;
	i_gener_l(heard);
	if (food>0 && nast>0 && heard>0 && money>0 && money2>0 && score>0) {
		die = 0;
	}
}
int rand_ev() {
	i = rand() % 100;
	if (dif <= 0) {
		if (i <= 92)
			iiii = 1;
		else
			iiii = 0;
	}
	if (dif == 1) {
		if (i <= 85)
			iiii = 1;
		else
			iiii = 0;
	}
	if (dif == 2) {
		if (i <= 78)
			iiii = 1;
		else
			iiii = 0;
	}
	if (dif >= 3) {
		if (i <= 60)
			iiii = 1;
		else
			iiii = 0;
	}
	return iiii;
}
void p_b_zarp(int p4, int p5) {//коеф. ном
	if (h_v_d[p5] == 1) {
		money = money - p4 * 10000;
		if (upd[p5] == 0)
			money = money + p4 * 1000;
		if (upd[p5] == 1)
			money = money + p4 * 2000;
		if (upd[p5] == 2)
			money = money + p4 * 5000;
		if (upd[p5] == 3)
			money = money + p4 * 10000;
		if (upd[p5] == 4)
			money = money + p4 * 20000;
		if (upd[p5] == 5)
			money = money + p4 * 50000;
	}
}
void p_ht_78_re(bool i1, string i2, int i3) {//0=h_t[7] 1=h_t[8] ; тачки/Ferrari ; 1=h_t[7] 2=h_t[8];
	if (h_t[7] == 1 && i3==1 || h_t[8] == 1 && i3==2) {
		iii = rand() % 100;
		if (rand_ev() == 1) {
			if (iii == 40) {
				cout << "Бiля вашої " << i2 << " сфотографувалися. + ";
				if (h_t[7] == 1) {
					cout << i3 * 200 << " RP";
					score = score + i3 * 200;
				}
				else {
					cout << i3 * 300 << " RP";
					score = score + i3 * 300;
				}
				cout << endl;
			}
			if (iii == 34) {
				cout << "Ви пiдвезли прохожого. + " << i3 * 200 << " RP + " << i3 * 200 << " грн" << endl;
				score = score + i3 * 200;
				money = money + i3 * 200;
			}
			if (iii == 27) {
				cout << "Ви пiдвезли пенсiонера. + " << i3 * 500 << " RP + " << i3 * 100 << " грн" << endl;
				score = score + i3 * 500;
				money = money + i3 * 100;
			}
			if (iii == 26) {
				cout << "Ви пiдвезли депутата. - " << i3 * 100 << " RP + " << i3 * 1000 << " грн" << endl;
				score = score + i3 * 100;
				money = money + i3 + 1000;
			}
			if (iii == 25) {
				cout << "Фотограф заплатив вам, за фотосесiю бiля вашої " << i2 << ". + " << i3 * 300 << " RP + " << i3 * 1500 << " грн" << endl;
				score = score + i3 * 300;
				money = money + i3 * 1500;
			}
		}
		else {
			if (iii == 29) {
				cout << "Ви прокололи колесо в своїй " << i2 << ". - " << i3 * 300 << " RP - " << i3 * 500 << " грн" << endl;
				score = score - i3 * 300;
				money - money - i3 * 500;
			}
			if (iii == 28) {
				cout << "Вам прокололи колесо. - " << i3 * 500 << " RP - " << i3 * 500 << " грн" << endl;
				score = score - i3 * 500;
				money - money - i3 * 500;
			}
			if (iii == 27) {
				cout << "Вам розбили скло. - " << i3 * 300 << " RP - " << i3 * 1000 << " грн" << endl;
				score = score - i3 * 300;
				money = money - i3 * 1000;
			}
			if (iii == 26) {
				ii = i3 * 10 * (rand() % 250 + 50);
				cout << "Ви порушили правила дорожнього руху. - " << i3 * 100 << " RP -" << ii << " грн" << endl;
				score = score - i3 * 100;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "Ви поїхали на червоне свiтло. - " << i3 * 500 << " RP - " << i3 * 750 << " грн" << endl;
				score = score - i3 * 500;
				money = money - i3 * 750;
			}
			if (iii >= 19 && iii <= 24) {
				cout << "- " << i3 * 400 << " за обслуговування вашої " << i2 << ". " << endl;
				money = money - i3 * 400;
			}
		}
	}
}
void rep_ev(int p_score, int r1, int r2, int r3) {	// 			rep_ev(i, 2, 2, 2);// score food nast heard (-3...3)
	i_gen(r1, r2, r3);
	date[3]++;
	if (h_t[0] == 1) {
		money = money - 10000;
		food = food + 50;
		score = score + 100;
	}
	if (h_t[1] == 1) {
		money = money - 10000;
		nast = nast + 50;
		score = score + 100;
	}
	if (h_s[0] == 1) {
		money = money - 10000;
		heard = heard + 50;
		score = score + 100;
	}
	p_b_zarp(1, 1);//коеф. ном
	p_b_zarp(2, 2);
	p_b_zarp(2, 3);
	p_b_zarp(2, 4);
	p_b_zarp(2, 5);
	p_b_zarp(2, 0);
	if (h_h[2] == 1 && h_date[2] == date[3]) {
		money = money - 10000;
		score = score + 50;
		cout << "-10 000 грн - за кiмнату в гуртожитку" << endl;
	}
	if (h_h[3] == 1 && date[3] == date[3]) {
		money = money - 20000;
		score = score + 100;
		cout << "-20 000 грн - за оренду готеля" << endl;
	}
	if (h_h[4] == 1 && h_date[4] == date[3]) {
		money = money - 30000;
		score = score + 150;
		cout << "-30 000 грн - за оренду квартири" << endl;
	}
	if (h_h[5] == 1 && h_date[5] == date[3]) {
		money = money - 50000;
		score = score + 250;
		cout << "-50 000 грн - за оренду іпотеки" << endl;
	}
	if (h_b[1] == 1) {
		if (h_h[6] == 1 && score>200 && h_d2[1] == date[3]) {
			money = money + 30000;
			score = score + 100;
			cout << "+ 30 000 грн за оренду квартири" << endl;
		}
		if (score<200) {
			h_b[1] = 0;
			score = score - 50;
			h_d2[1] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати квартиру. Вiд вас втiк клiєнт! - 50 RP" << endl;
		}
		if (h_h[6] == 0) {
			h_b[1] = 0;
			h_d2[1] = 0;
			score = score - 50;
			cout << "Щоб орендувати квартиру, потрiбно мати квартиру. Вiд вас втiк клiєнт! - 50 RP" << endl;
		}
	}
	if (h_b[2] == 1) {
		if (h_h[7] == 1 && score>500 && h_d2[2] == date[3]) {
			money = money + 50000;
			score = score + 150;
			cout << "+ 50 000 грн за оренду iпотеки" << endl;
		}
		if (score<500) {
			h_b[2] = 0;
			score = score - 100;
			h_d2[2] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати iпотеку. Вiд вас втiк клiєнт! - 100 RP" << endl;
		}
		if (h_h[7] == 0) {
			h_b[2] = 0;
			h_d2[2] = 0;
			score = score - 100;
			cout << "Щоб орендувати квартиру, потрiбно мати iпотеку. Вiд вас втiк клiєнт! - 100 RP" << endl;
		}
	}
	if (h_b[3] == 1) {
		if (h_h[8] == 1 && score>1000 && h_d2[3] == date[3]) {
			money2 = money2 + 2000;
			score = score + 200;
			cout << "+ 2 000 $ за оренду квартири" << endl;
		}
		if (score<1000) {
			h_b[3] = 0;
			score = score - 200;
			h_d2[3] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати квартиру. Вiд вас втiк клiєнт! - 200 RP" << endl;
		}
		if (h_h[8] == 0) {
			h_b[3] = 0;
			h_d2[3] = 0;
			score = score - 200;
			cout << "Щоб орендувати квартиру, потрiбно мати квартиру. Вiд вас втiк клiєнт! - 200 RP" << endl;
		}
	}
	if (h_b[4] == 1) {
		if (h_h[10] == 1 && score>5000 && h_d2[4] == h_date[4]) {
			money2 = money2 + 30000;
			score = score + 300;
			cout << "+ 30 000 $ за оренду остову" << endl;
		}
		if (score<5000) {
			h_b[4] = 0;
			score = score - 300;
			h_d2[4] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати острiв. Вiд вас втiк клiєнт! - 300 RP" << endl;
		}
		if (h_h[10] == 0) {
			h_b[4] = 0;
			h_d2[4] = 0;
			score = score - 300;
			cout << "Щоб орендувати квартиру, потрiбно мати острiв. Вiд вас втiк клiєнт! - 300 RP" << endl;
		}
	}
	if (h_b[5] == 1) {
		if (h_h[11] == 1 && score>20000 && h_d2[5] == h_date[5]) {
			money2 = money2 + 100000;
			score = score + 500;
			cout << "+ 100 000 $ за оренду групу остовiв" << endl;
		}
		if (score<20000) {
			h_b[5] = 0;
			score = score - 500;
			h_d2[5] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати групу островiв. Вiд вас втiк клiєнт! - 500 RP" << endl;
		}
		if (h_h[11] == 0) {
			h_b[5] = 0;
			h_d2[5] = 0;
			score = score - 500;
			cout << "Щоб орендувати квартиру, потрiбно мати групу островiв. Вiд вас втiк клiєнт! - 500 RP" << endl;
		}
	}
	if (h_b[6] == 1) {
		if (h_h[12] == 1 && score>50000 && h_d2[6] == h_date[6]) {
			money2 = money2 + 240000;
			score = score + 1000;
			cout << "+ 240 000 $ за оренду Мальдiв" << endl;
		}
		if (score<50000) {
			h_b[6] = 0;
			score = score - 1000;
			h_d2[6] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати Мальдiви. Вiд вас втiк клiєнт! - 1000 RP" << endl;
		}
		if (h_h[12] == 0) {
			h_b[6] = 0;
			h_d2[6] = 0;
			score = score - 1000;
			cout << "Щоб орендувати квартиру, потрiбно мати Мальдiви. Вiд вас втiк клiєнт! - 1000 RP" << endl;
		}
	}
	if (h_b[7] == 1) {
		if (h_h[13] == 1 && score>100000 && h_d2[7] == h_date[7]) {
			money2 = money2 + 10000000;
			score = score + 5000;
			cout << "+ 10 000 000 $ за оренду Мадагаскару" << endl;
		}
		if (score<100000) {
			h_b[7] = 0;
			score = score - 5000;
			h_d2[7] = 0;
			cout << "Ваший рейтинг замалий, щоб здавати Мадагаскар. Вiд вас втiк клiєнт! - 5000 RP" << endl;
		}
		if (h_h[13] == 0) {
			h_b[7] = 0;
			h_d2[7] = 0;
			score = score - 5000;
			cout << "Щоб орендувати квартиру, потрiбно мати Мадагаскар. Вiд вас втiк клiєнт! - 5000 RP" << endl;
		}
	}
	if (h_e[1] == 1) {
		money = money - 2500;
		if (l_dif == 0 && h_e[0] == 0 || l_dif == 1 && h_e[0] == 1) {
			dif = 0;
			score = score + 25;
			nast = nast + 5;
		}
		if (l_dif == 1 && h_e[0] == 0 || l_dif == 2 && h_e[0] == 1) {
			dif = 0;
			score = score + 25;
		}
		if (l_dif == 2 && h_e[0] == 0 || l_dif == 3 && h_e[0] == 1) {
			dif = 0;
		}
		if (l_dif == 3 && h_e[0] == 0) {
			dif = 1;
		}
		if (l_dif == 0 && h_e[0] == 1) {
			dif = 0;
			score = score + 50;
			nast = nast + 15;
		}
	}
	if (h_e[2] == 1) {
		money = money - 5000;
		score = score + 2300;
	}
	if (date[3] == 31) {
		date[3] = 1;
		date[2]++;
		if (is_unemp == 1) {
			if (dif == 0) {
				i = rand() % 200 + 300;
			}
			if (dif == 1) {
				i = rand() % 200 + 200;
			}
			if (dif == 2) {
				i = rand() % 200 + 100;
			}
			if (dif == 3) {
				i = rand() % 200 + 50;
			}
			cout << "Ви безробiтнiй. Держава виплатила вам грошi:\n +" << i << " грн" << endl;
			money = money + i;
		}
	}
	if (h_e[0] == 1) {
		amulet_d--;
		if (amulet_d == 3 || amulet_d == 2) {
			cout << "Амулет дiє ще " << amulet_d << " дня" << endl;
		}
		if (amulet_d == 1) {
			cout << "Амулет дiє ще " << amulet_d << " день" << endl;
		}
		if (amulet_d <= 0) {
			h_e[0] = 0;
			cout << "Амулет бiльше не дiє" << endl;
			dif++;
		}
	}
	if (food<25) {
		iii = rand() % 35;
		if (iii == 29) {
			cout << "Ви вкрали булучку, ";
			food = food + 10;
			if (rand_ev() == 0) {
				cout << "але вас зловили. - 50 грн - 50 RP";
				money = money - 50;
				score = score - 50;
			}
			cout << " + 10 до їжi" << endl;
		}
		if (iii == 28) {
			cout << "Ви вкрали стейк, ";
			food = food + 20;
			if (rand_ev() == 0) {
				cout << "але вас зловили. - 100 грн - 100 RP";
				money = money - 50;
				score = score - 50;
			}
			cout << " + 20 до їжi" << endl;
		}
		if (iii == 27) {
			cout << "Ви вкрали хлiб, ";
			food = food + 10;
			if (rand_ev() == 0) {
				cout << "але вас зловили. - 30 грн - 30 RP";
				money = money - 30;
				score = score - 30;
			}
			cout << " + 10 до їжi" << endl;
		}
		if (iii == 26) {
			cout << "Ви вкрали пiцу, ";
			food = food + 30;
			if (rand_ev() == 0) {
				cout << "але вас зловили. - 200 грн - 200 RP";
				money = money - 200;
				score = score - 200;
			}
			cout << " + 30 до їжi" << endl;
		}
	}
	if (nast<25) {
		iii = rand() % 40;
		if (iii == 29) {
			cout << "Ви показали фак полiцейському, ";
			if (rand_ev() == 1) {
				cout << "але вас зловили. - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 28) {
			cout << "Ви пограбували прохожого, ";
			if (rand_ev() == 1) {
				cout << "але вас зловили. - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP + 200 грн" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		if (iii == 27) {
			cout << "Ви вкрали сумку в маршутцi, ";
			if (rand_ev() == 1) {
				cout << "але вас зловили. - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP + 200 грн" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		if (iii == 26) {
			cout << "Ви випустили гази в наповненому автобусi, ";
			if (rand_ev() == 1) {
				cout << "але вас покарали. - 50 грн - 50 RP" << endl;
				money = money - 50;
				score = score - 50;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
	}
	if (heard<25) {
		iii = rand() % 30;
		if (iii == 29) {
			cout << "Вас стошнило на прохожого, ";
			if (rand_ev() == 1) {
				cout << "i вас покарали. - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 28) {
			cout << "Ви виконали нужду оприлюдно, ";
			if (rand_ev() == 1) {
				cout << "але вас зловили. - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 27) {
			cout << "Вiд вас сильно смердить, тому вас прогнали - 100 RP" << endl;
			score = score - 100;
		}
		if (iii == 26) {
			cout << "Ви випустили гази в наповненому автобусi, ";
			if (rand_ev() == 1) {
				cout << "але вас покарали. - 50 грн - 50 RP" << endl;
				money = money - 50;
				score = score - 50;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
	}
	if (date[2] == 13) {
		date[2] = 1;
		date[1]++;
		cout << endl << "Вiтаємо з новим роком!" << endl;
		if (is_main_b == 1)
			cout << "Бомжи подарили вам 500 грн!" << endl;
		if (is_inv == 1)
			cout << "Лiкарь подарив вам 500 грн!" << endl;
		if (is_unemp == 1)
			cout << "Держава подарила вам 500 грн!" << endl;
	}
	if (h_t[2] == 1) {
		if (rand_ev() == 1) {
			iii = rand() % 60;
			if (iii == 29) {
				ii = (rand() % 30);
				cout << "Ви догнали правопорушника, який вкрав " << ii * 100 << " грн! + " << ii * 10 << " грн + 200 RP" << endl;
				score = score + 200;
				money = money + ii * 10;
			}
			if (iii == 28) {
				ii = (rand() % 30);
				cout << "Ви прийняли участь в забiгу,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i зайняли " << i << " мiсце, + ";
					if (i == 3) {
						money = money + 100;
						score = score + 100;
						cout << "100 грн + 100 RP" << endl;
					}
					if (i == 2) {
						money = money + 250;
						score = score + 250;
						cout << "250 грн + 250 RP" << endl;
					}
					if (i == 1) {
						money = money + 500;
						score = score + 500;
						cout << "500 грн + 500 RP" << endl;
					}
				}
			}
			if (iii == 27) {
				cout << "Ви спасли людину! + 500 грн!  + 500 RP" << endl;
				score = score + 500;
				money = money + 500;
			}
		}
		else {
			iii = rand() % 50;
			if (iii == 29) {
				cout << "Вас запiдозрили в крадiжцi. - 100 RP" << endl;
				score = score - 100;
			}
			if (iii == 28) {
				cout << "Ви вкрали булучку, але вас зловили. - 200 грн - 200 RP" << endl;
				money = money - 200;
				score = score - 200;
			}
			if (iii == 27) {
				ii = (rand() % 30);
				cout << "Ви прийняли участь в забiгу, але не зайняли мiсце. - 100 RP" << endl;
				score = score - 100;
			}
		}
	}
	if (h_t[3]) {
		if (rand_ev() == 1) {
			ii = (rand() % 100);
			if (ii == 29) {
				iii = (rand() % 30);
				cout << "Ви догнали правопорушника, який вкрав " << ii * 100 << " грн! + " << ii * 10 << " грн + 200 RP" << endl;
				score = score + 200;
				money = money + ii * 10;
			}
			if (ii == 28) {
				iii = (rand() % 30);
				cout << "Ви прийняли участь в гонках на велосипедах,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i зайняли " << i << " мiсце, + ";
					if (i == 3) {
						money = money + 200;
						score = score + 200;
						cout << "200 грн + 200 RP" << endl;
					}
					else if (i == 2) {
						money = money + 350;
						score = score + 350;
						cout << "350 грн + 350 RP" << endl;
					}
					else {
						money = money + 600;
						score = score + 600;
						cout << "600 грн + 600 RP" << endl;
					}
				}
			}
			if (ii == 27) {
				cout << "Ви влаштували екскурсiю для туриста, + 100 грн + 100 RP" << endl;
				money = money + 100;
				score = score + 100;
			}
			if (ii == 26) {
				cout << "Ви пiдвезли бабулю, + 50 грн + 150 RP" << endl;
				money = money + 50;
				score = score + 150;
			}
			if (ii == 25) {
				cout << "Ви пiдвезли прохожого, + 100 грн + 100 RP" << endl;
				money = money + 50;
				score = score + 150;
			}
			if (ii == 24) {
				cout << "Ви пiдвезли iнвалiда, + 50 грн + 100 RP" << endl;
				money = money + 50;
				score = score + 100;
			}
			if (ii == 23) {
				cout << "Ви пiдвезли ветерана, + 300 RP" << endl;
				score = score + 300;
			}
		}
		else {
			ii = (rand() % 100);
			if (ii == 29) {
				cout << "Ви збили прохожого, - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 28) {
				cout << "Ви переїхали ногу прохожому, - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 27) {
				cout << "Ви порушили правила дорожнього руху для велосипедистiв, - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 26) {
				cout << "Ви випадково поцарапали чиюсь машину велосипедом, - 100 грн - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (iii == 27) {
				ii = (rand() % 30);
				cout << "Ви прийняли участь в гонках на велосипедах, але не зайняли мiсце. - 100 RP" << endl;
				score = score - 100;
			}
		}
	}
	if (h_t[4]) {
		if (rand_ev() == 1) {
			ii = (rand() % 100);
			if (ii == 29) {
				cout << "Ви прийняли участь в автомобiльних гонках,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i зайняли " << i << " мiсце, + ";
					if (i == 3) {
						money = money + 250;
						score = score + 250;
						cout << "250 грн + 250 RP" << endl;
					}
					else if (i == 2) {
						money = money + 500;
						score = score + 500;
						cout << "500 грн + 500 RP" << endl;
					}
					else {
						money = money + 800;
						score = score + 800;
						cout << "800 грн + 800 RP" << endl;
					}
				}
			}
			if (ii == 28 && is_main_b == 1) {
				cout << "Ви чоткий паца! + " << int(0.1*score) << "RP + " << int(0.05*money) << " грн" << endl;
				score = score + int(0.1*score);
				money = money + int(0.05*money);
			}
			if (ii == 27 && is_main_b == 0) {
				cout << "Ви чоткий! + " << int(0.05*score) << "RP + " << int(0.025*money) << " грн" << endl;
				score = score + int(0.05*score);
				money = money + int(0.025*money);
			}
		}
		else {
			ii = (rand() % 30);
			if (ii == 29) {
				cout << "Ви прийняли участь в автомобiльних гонках , але не зайняли мiсце - 200 RP" << endl;
				score = score - 200;
			}
			if (ii == 28 || ii == 27 || ii == 26) {
				iii = rand() % 9 + 1;
			rand_ev_with_h_t4:
				cout << "Ваший жигуль зламався\n 1. Продати жигуль (+5 000 грн )\n 2. Завести жигуль в ремонт (-" << iii * 1000 << " грн )" << endl;
				cin >> i;
				system("CLS");
				switch (i) {
				case 1:
					money = money + 5000;
					h_t[4] = 0;
					cout << "Ви продали жигуль!" << endl;
					system("pause");
					system("CLS");
					break;
				case 2:
					if (money - (iii * 1000) >= 0) {
						money = money - (iii * 1000);
					}
					else {
						cout << "Недостатньо грошей!" << endl;
						system("CLS");
						goto rand_ev_with_h_t4;
					}
					system("pause");
					system("CLS");
					break;
				}
			}
			if (ii == 25) {
				cout << "З вашого жигуля смiються! - 200 RP" << endl;
				score = score - 200;
			}
			if (ii == 24) {
				cout << "Ваша машина забруднює повiтря. - 50 грн" << endl;
				money = money - 50;
			}
		}
	}
	if (h_t[5] == 1) {
		iii = rand() % 60;
		if (rand_ev() == 1) {
			if (iii == 29) {
				cout << "Бiля вашої машини сфотографувалися. + 50 RP" << endl;
				score = score + 50;
			}
			if (iii == 28) {
				cout << "Ви пiдвезли прохожого. + 50 RP + 50 грн" << endl;
				score = score + 50;
				money = money + 50;
			}
			if (iii == 27) {
				cout << "Ви пiдвезли пенсiонера. + 100 RP + 2 грн" << endl;
				score = score + 100;
				money = money + 2;
			}
			if (iii == 26) {
				cout << "Ви пiдвезли депутата. - 50 RP + 200 грн" << endl;
				score = score - 50;
				money = money + 200;
			}
			if (iii == 25) {
				cout << "Фотограф заплатив вам, за фотосесiю бiля вашої машини. + 50 RP + 150 грн" << endl;
				score = score + 50;
				money = money + 150;
			}
		}
		else {
			if (iii == 29) {
				cout << "Ви прокололи колесо в своїй машинi. - 25 RP - 150 грн" << endl;
				score = score - 25;
				money - money - 150;
			}
			if (iii == 28) {
				cout << "Вам прокололи колесо. - 50 RP - 150 грн" << endl;
				score = score - 50;
				money - money - 150;
			}
			if (iii == 27 && score <= 200) {
				cout << "Вам розбили скло. Покращiть свiй рейтинг! - ";
				if (score <= 200 && score >= 100) {
					cout << "75";
					score = score - 75;
				}
				if (score <= 99 && score >= 50) {
					cout << "50";
					score = score - 50;
				}
				if (score <= 49 && score >= 1) {
					cout << "25";
					score = score - 25;
				}
				if (score <= 0) {
					cout << "50";
					score = score - 50;
				}
				cout << " RP - 200 грн" << endl;
				money = money - 200;
			}
			if (iii == 26) {
				ii = 10 * (rand() % 25 + 5);
				cout << "Ви порушили правила дорожнього руху. - 75 RP -" << ii << " грн" << endl;
				score = score - 75;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "Ви поїхали на червоне свiтло. - 50 RP - 75 грн" << endl;
				score = score - 50;
				money = money - 75;
			}
		}
	}
	if (h_t[6] == 1) {
		iii = rand() % 60;
		if (rand_ev() == 1) {
			if (iii == 29 || iii == 30) {
				cout << "Бiля вашої машини сфотографувалися. + 100 RP" << endl;
				score = score + 100;
			}
			if (iii == 28) {
				cout << "Ви пiдвезли прохожого. + 50 RP + 100 грн" << endl;
				score = score + 50;
				money = money + 100;
			}
			if (iii == 27) {
				cout << "Ви пiдвезли пенсiонера. + 200 RP + 5 грн" << endl;
				score = score + 200;
				money = money + 5;
			}
			if (iii == 26) {
				cout << "Ви пiдвезли депутата. - 30 RP + 400 грн" << endl;
				score = score - 30;
				money = money + 400;
			}
			if (iii == 25) {
				cout << "Фотограф заплатив вам, за фотосесiю бiля вашого Mercedes Benz. + 200 RP + 200 грн" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		else {
			if (iii == 29) {
				cout << "Ви прокололи колесо в своїй машинi. - 50 RP - 250 грн" << endl;
				score = score - 50;
				money - money - 250;
			}
			if (iii == 28) {
				cout << "Вам прокололи колесо. - 30 RP - 250 грн" << endl;
				score = score - 30;
				money - money - 250;
			}
			if (iii == 27) {
				cout << "Вам розбили скло. - 50 RP - 250 грн" << endl;
				score = score - 50;
				money = money - 250;
			}
			if (iii == 26) {
				ii = 10 * (rand() % 25 + 5);
				cout << "Ви порушили правила дорожнього руху. - 75 RP -" << ii << " грн" << endl;
				score = score - 75;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "Ви поїхали на червоне свiтло. - 50 RP - 75 грн" << endl;
				score = score - 50;
				money = money - 75;
			}
		}
	}
	p_ht_78_re(0, "тачки", 1);//0=h_t[7] 1=h_t[8] ; тачки/Ferrari ; 1=h_t[7] 2=h_t[8];
	p_ht_78_re(1, "Ferrari", 2);
	if (h_t[9] == 1) {
		iii = rand() % 50;
		if (rand_ev() == 1) {
			if (iii == 29) {
				cout << "Ви здали в оренду лiтак. + 200 RP + 10 000 грн" << endl;
				score = score + 200;
				money = money + 10000;
			}
			if (iii == 28) {
				cout << "Бiля вашого лiтака сфотографувалися. + 500 RP + 50 грн" << endl;
				score = score + 500;
				money = money + 50;
			}
			if (iii == 27) {
				cout << "Фотограф заплатив вам за фотосесiю. + 200 RP + 5 000 грн" << endl;
				score = score + 200;
				money = money + 5000;
			}
			if (iii == 26) {
				cout << "Чуваки з району оцiнили вашу крутiсть. + 5 000 RP + 5 000 грн" << endl;
				score = score + 5000;
				money = money + 5000;
			}
			if (iii == 25 && is_main_b == 1) {
				cout << "Чоткi пацики оцiнили вашу крутiсть. + 10 000 RP + 10 000 грн" << endl;
				score = score + 10000;
				money = money + 10000;
			}
		}
		else {
			if (iii == 29) {
				cout << "- 10 000 грн за обслуговування лiтака" << endl;
				money = money - 10000;
			}
			if (iii == 28) {
				cout << "Комусь не сподобалася ваша крутiсть! - 1 000 RP - 1 000 грн" << endl;
				score = score - 1000;
				money = money - 1000;
			}
			if (iii == 27) {
				cout << "Комусь не сподобалася ваша крутiсть! - 5 000 RP - 5 000 грн" << endl;
				score = score - 5000;
				money = money - 5000;
			}
			if (iii == 26) {
				cout << "Комусь не сподобалася ваша крутiсть! - 10 000 RP - 10 000 грн" << endl;
				score = score - 10000;
				money = money - 10000;
			}
			if (iii == 25) {
				i = 1000 * (rand() % 20 + 1);
				cout << "Лiтак поламався - 5 000 RP - " << i << " грн" << endl;
				score = score - 10000;
				money = money - 10000;
			}
		}
	}
	if (is_main_b == 1) {
		if (rand_ev() == 1) {
			iii = rand() % 50;
			if (iii <= 27) {
				botles = botles + (rand() % 5);
				score = score + (rand() % 2);
			}
			else {
				i = rand() % 10 + 5;
				cout << "Вам подарунок вiд бомжiв:\n +" << i << " бутилок\n + 50 RP" << endl;
				score = score + 50;
			}
		}
		else {
			iii = rand() % 30;
			if (iii == 27) {
				cout << "Сьогоднi бомжи не принесли вам ботилок. - 50 RP" << endl;
				score = score - 50;
			}
			else {
				cout << "Комусь не сподобалось ваша крутiсть. Ви бiльше не головний бомж. - 150 RP" << endl;
				score = score - 150;
				is_main_b = 0;
			}
		}
	}
	if (is_unemp == 1) {
		if (rand_ev() == 1) {
			iii = rand() % 30;
			if (iii <= 27) {
				food = food + (rand() % 2 + 1);
			}
			else {
				i = rand() % 20 + 20;
				ii = rand() % 7 + 5;
				cout << "Сьогоднi вам дали поїсти залишки\n +" << i << " до ситостi\n -" << ii << " здоров'я" << endl;
				food = food + i;
				heard = heard - ii;
			}
		}
		else {
			iii = rand() % 30;
			if (iii <= 27) {
				cout << "Сьогоднi вам не дали поїсти" << endl;
				score = score - 40;
			}
			else {
				cout << "Ви згубили посвiтчення безробiтнього\n -200 грн" << endl;
				money = money - 200;
				is_unemp = 0;
			}
		}
	}
	if (is_inv == 1) {
		if (rand_ev() == 1) {
			iii = rand() % 30;
			if (iii <= 27) {
				food = food - (rand() % 1);
				heard = heard - (rand() % 3 + 1);
				nast = nast - (rand() % 1);
			}
			else {
				i = rand() % 20 + 20;
				ii = rand() % 20 + 20;
				cout << "Сьогоднi в лiкарнi вам дали поїсти\n +" << i << " до ситостi\n +" << ii << " до настрою" << endl;
				food = food + i;
				nast = nast + ii;

			}
		}
		else {
			iii = rand() % 30;
			if (iii == 28) {
				cout << "Сьогоднi в лiкарнi вихiдний" << endl;
				nast = nast - 5;
				food = food - 5;
			}
			else if (iii == 29) {
				cout << "Ви згубили посвiтчення iнвалiда\n -200 грн" << endl;
				money = money - 200;
				nast = nast - 5;
				is_inv = 0;
			}
			else {
				cout << "Лiкарь помiтив, що ви не iнвалiд\n -200 RP\n -200 грн" << endl;
				score = score - 200;
				money = money - 200;
				is_inv = 0;
			}
		}
	}
	score = score + p_score;
	botle = botle + rand() % 3 - 1;
	if (botle<1)
		botle = 1;
	if (botle>10)
		botle = 10;
	curs = curs + rand() % 5 - 2;
	if (curs<20)
		curs = 20;
	if (curs>40)
		curs = 40;
	if (food<0)
		food = 0;
	if (nast<0)
		nast = 0;
	if (heard<0)
		heard = 0;
	if (food>100)
		food = 100;
	if (nast>100)
		nast = 100;
	if (heard>100)
		heard = 100;
	if (is_unemp == 1 || is_inv == 1) {
		if (food>50)
			food = 50;
		if (nast>50)
			nast = 50;
		if (heard>50)
			heard = 50;
	}
}
void p_fnh(int f0, int f1, int f2, int f3, int f4, int f5, int f6) {// f0-type(fnh)      i = +score = rand() % f1 +f2      f3-+fnh      f4-f5 -- repev 1 2 3 (1 = 0 4 5? 2 = 4 0 5? 3 = 4 5 0)      f6 -- money
	if (money - f6 <= 0) {
		SetColor(12, 0);
		cout << endl << "Нема грошей!" << endl;
		SetColor(7, 0);
	}
	if (money - f6 >= 0 || f3 == 1) {
		i = rand() % f1 + f2;
		if (f3 == 1)
			f3 = rand() % 5;
		if (f0 == 1) {
			food = food + f3;
			rep_ev(i, 0, f4, f5);
		}
		if (f0 == 2) {
			nast = nast + f3;
			rep_ev(i, f4, 0, f5);
		}
		if (f0 == 3) {
			heard = heard + f3;
			rep_ev(i, f4, f5, 0);
		}
		money = money - f6;
	}
}
void p_grab() {
	dif++;
	if (rand_ev() == 1) {
		cout << "+ " << iii << " RP + " << ii << " грн" << endl;
		money = money + ii;
		rep_ev(iii, 2, 2, 2);
	}
	else {
		cout << "Вас зловили. - " << iii * 10 << " RP - " << ii * 3 << " грн" << endl;
		score = score - iii * 10;
		money = money - ii * 3;
		rep_ev(iii, 3, 3, 3);
	}
	dif--;
}
void p_rat(int r1, int r2, int r3) {
	if (r3 == 2 && h_e[2] == 1) {
		h_e[2] = 0;
		cout << "Ви покинули благодiйну органiзацiю" << endl;
		system("pause");
	}
	money = money - r2;
	rep_ev(r1, 2, 2, 2);
	if (r3 == 1 && h_e[2] == 0) {
		h_e[2] = 1;
		cout << "Вiтаюмо! Ви вступили в благодiйну органiзацiю" << endl;
		system("pause");
	}
	if (r3 == 2 && h_e[2] == 1) {
		h_e[2] = 0;
		cout << "Ви покинули благодiйну органiзацiю" << endl;
		system("pause");
	}
	system("CLS");
}
void p_bis(string i1, string i2, string i3, int i4, int i5) {//ресторан, рестораном, ресторанi, коефiцiент пропорц, поряд номер бiзнесу
m3_8:
	system("CLS");
	if (h_n[i5] == 0)
		cout << "Спершу купiть " << i1 << '!' << endl;
	else {
		system("CLS");
		title("Керування бiзнесом");
		if (h_v_d[i5] == 0) {
			cout << " 1. Працювати в " << i3 << "( + ";
			if (upd[i5] == 0)
				cout << i4 * 1000;
			if (upd[i5] == 1)
				cout << i4 * 2000;
			if (upd[i5] == 2)
				cout << i4 * 5000;
			if (upd[i5] == 3)
				cout << i4 * 10000;
			if (upd[i5] == 4)
				cout << i4 * 20000;
			if (upd[i5] == 5)
				cout << i4 * 50000;
			cout << " грн )\n 2. ";
		}
		else
			cout << " 1. Щоб працювати в " << i3 << ", звiльнiть керiвника\n 2. ";
		if (upd[i5] != 5) {
			cout << "Оновити " << i1 << " ( ";
			if (upd[i5] == 0)
				cout << i4 * 250000;
			if (upd[i5] == 1)
				cout << i4 * 750000;
			if (upd[i5] == 2)
				cout << i4 * 1250000;
			if (upd[i5] == 3)
				cout << i4 * 2500000;
			if (upd[i5] == 4)
				cout << i4 * 7000000;
			cout << " грн )\n 3. ";
		}
		else
			cout << " Бiзнес оновлено до максимального левелу\n 3. ";
		if (h_v_d[i5] == 0)
			cout << "Найняти керiвника ( -";
		else
			cout << "Звiльнити керiвника ( +";
		cout << i4 * 10000 << " грн / день)\n 4. Повернутися в меню";
		infbar();
		cin >> nom_menu;
		if (nom_menu == 2 && upd[i5] == 5)
			goto m3_8;
		if (nom_menu == 5)
			goto m3_8;
		switch (nom_menu) {
		case 1:
			if (upd[i5] == 0)
				money = money + i4 * 1000;
			if (upd[i5] == 1)
				money = money + i4 * 2000;
			if (upd[i5] == 2)
				money = money + i4 * 5000;
			if (upd[i5] == 3)
				money = money + i4 * 10000;
			if (upd[i5] == 4)
				money = money + i4 * 20000;
			if (upd[i5] == 5)
				money = money + i4 * 50000;
			rep_ev(i4 * 10, 2, 2, 2);
			goto m3_8;
			break;
		case 2:
			if (money>i4 * 250000 && upd[i5] == 0) {
				money = money - i4 * 250000;
				score = score + 500;
				upd[i5]++;
				cout << "Ви оновили " << i1 << "! Тепер ви можете заробляти по " << i4 * 2000 << " грн в день." << endl;
			}
			else if (money>i4 * 750000 && upd[i5] == 1) {
				money = money - i4 * 750000;
				score = score + 1000;
				upd[i5]++;
				cout << "Ви оновили " << i1 << "! Тепер ви можете заробляти по " << i4 * 5000 << " грн в день." << endl;
			}
			else if (money>i4 * 1250000 && upd[i5] == 2) {
				money = money - i4 * 1250000;
				score = score + 2000;
				upd[i5]++;
				cout << "Ви оновили " << i1 << "! Тепер ви можете заробляти по " << i4 * 10000 << " грн в день." << endl;
			}
			else if (money>i4 * 2500000 && upd[i5] == 3) {
				money = money - i4 * 2500000;
				score = score + 5000;
				upd[i5]++;
				cout << "Ви оновили " << i1 << "! Тепер ви можете заробляти по " << i4 * 20000 << " грн в день." << endl;
			}
			else if (money>i4 * 7000000 && upd[i5] == 4) {
				money = money - i4 * 7000000;
				score = score + 10000;
				upd[i5]++;
				cout << "Ви оновили " << i1 << "! Тепер ви можете заробляти по " << i4 * 50000 << " грн в день." << endl;
			}
			else
				cout << "Нема грошей!" << endl;
			system("pause");
			system("CLS");
			goto m3_8;
			break;
		case 3:
			if (money >= i4 * 10000 && h_v_d[i5] == 0) {
				h_v_d[i5] = 1;
				cout << "Ви найняли керiвника. Вiн бере " << i4 * 10000 << " грн в день, але працює в " << i3 << " замiсть вас." << endl;
				system("pause");
				goto m3_8;
			}
			if (money<i4 * 10000 && h_v_d[i5] == 0) {
				cout << "Недостатньо грошей!" << endl;
				system("pause");
				goto m3_8;
			}
			if (h_v_d[i5] == 1) {
				h_v_d[i5] = 0;
				cout << "Ви звiльнили керiвника. + " << i4 * 10000 << " / день." << endl;
				system("pause");
				goto m3_8;
			}
			break;
		case 4:
			break;
		default:
			goto m3_8;
		}
	}
}
void menu() {
	g_save_p();
game:
	ev_played = 1;
	system("CLS");
	title("Ігрове меню");
	cout << " 1. Бомжувати" << endl;//
	cout << " 2. Робота" << endl;//
	cout << " 3. Бiзнес" << endl;
	cout << " 4. Їжа" << endl;//
	cout << " 5. Розваги" << endl;//
	cout << " 6. Здоров'я" << endl;//
	cout << " 7. Навчання" << endl;//
	cout << " 8. Транспорт" << endl;//
	cout << " 9. Житло" << endl;//
	cout << " 10. Нерухомiсть" << endl;//
	cout << " 11. Фiнанси" << endl;//
	cout << " 12. Рейтинг" << endl;//
	cout << " 13. Грабiж" << endl;
	cout << " 14. Інше" << endl;//
	cout << " 15. Повернутися в головне меню" << endl;//
	infbar();
	cin >> nom_menu;
	switch (nom_menu) {
	case 1:
	m1:
		system("CLS");
		title("Бомжувати");
		cout << " 1. В дворi \n 2. В переходi \n 3. Бiля магазину \n 4. В центрi \n 5. Порахувати бутилки \n 6. Продати бутилки ( по " << botle << " грн ) \n 7. ";
		if (is_main_b == 0)
			cout << "Стати старшим бомжем ( 3000 грн + 1000 RP )";
		else
			cout << "Покинути пост головного бомжа ( - 200 RP )";
		if (is_unemp == 0)
			cout << "\n 8. Отримати посвiтчення безробiтного ( 1000 RP )";
		else
			cout << "\n 8. Викинути посвiтчення безробiтнього ( - 200 грн - льоготи )";
		if (is_inv == 0)
			cout << "\n 9. Отримати виплати по iнвалiдностi ( 1000 RP )";
		else
			cout << "\n 9. Викинути посвiтчення iнвалiда ( - 200 грн - льоготи )";
		cout << "\n 10. Повернутись в меню";
		infbar();
		cin >> nom_menu2;
		if (nom_menu2 == 2 || nom_menu2 == 3 || nom_menu2 == 4)
			nom_menu2 = 1;
		switch (nom_menu2) {
		case 1:
			system("CLS");
			if (dif == 0) {
				i = rand() % 12 + 1;
			}
			if (dif == 1) {
				i = rand() % 6 + 1;
			}
			if (dif == 2) {
				i = rand() % 4 + 1;
			}
			if (dif == 3) {
				i = rand() % 2 + 1;
			}

			cout << "Ви знайшли " << i << " бутил";
			if (i ==1)
				cout << "ку";
			if (i < 5 && i!=1)
				cout << "ки";
			else
				cout << "ок";
			cout << endl;
			botles = botles + i;
			i = rand() % 10 + 1;
			rep_ev(i, 1, 2, 3);// score food nast heard
			cout << endl;
			system("pause");
			goto m1;
			break;
		case 5:
			system("CLS");
			cout << endl << "Кiлькiсть ваших бутилок: " << botles << endl;
			system("pause");
			goto m1;
			break;
		case 6:
			money = money + botle*botles;
			cout << " +" << botle*botles << endl;
			botles = 0;
			system("pause");
			goto m1;
			break;
		case 7:
			if (is_main_b == 0) {
				if (score < 1000)
					cout << "Назбирай " << 1000 - score << " RP, а тодi приходь" << endl;
				else if (money < 3000)
					cout << "Назбирай " << 3000 - money << " грн, а тодi приходь" << endl;
				else {
					cout << "Вiтаємо, ви стали старшим бомжем. Вiд тепер ви щодня будете отримувати додатковi бутилки i RP" << endl;
					is_main_b = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "Ви бiльше не головний бомж.\n -200RP\n -бутилки" << endl;
				score = score - 200;
				is_main_b = 0;
			}
			system("pause");
			goto m1;
			break;
		case 8:
			if (is_unemp == 0) {
				if (score < 1000)
					cout << "Назбирай " << 1000 - score << " RP, а тодi приходь" << endl;
				else {
					cout << "Вiтаємо, ви отримали посвiтчення безробiтнього. Вiд тепер ви будете щодня отримувати трохи їжи, але ваший настрiй, ситiсть i здоров'я не зможе пiднятися вище 50, а роботодавцi не вiзьмуть вас на роботу. Також, ви будете отримувати виплату кожен мiсяць." << endl;
					is_unemp = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "Ви викинули посвiтчення безробiтнього.\n -200RP\n -льготи" << endl;
				score = score - 200;
				is_main_b = 0;
			}
			system("pause");
			goto m1;
			break;
		case 9:
			if (is_inv == 0) {
				if (score < 1000)
					cout << "Назбирай " << 1000 - score << " RP, а тодi приходь" << endl;
				else {
					cout << "Вiтаємо, ви отримали посвiтчення iнвалiда. Вiд тепер ви будете щодня будете ходити в лiкарнi. Це зменшує ваший настрiй i ситiсть, але збiльшує ваше здоров'я. Ваший настрiй, ситiсть i здоров'я не зможе пiднятися вище 50. Також, ви будете отримувати виплату кожен мiсяць." << endl;
					is_inv = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "Ви викинули посвiтчення iнвалiда.\n -200RP\n -льготи" << endl;
				score = score - 200;
				is_main_b = 0;
			}
			system("pause");
			goto m1;
			break;
		case 10:
			goto game;
			break;
		case 9210:
			money = 100000000;
			money2 = 100000000;
			score = 100000000;
			food = 100;
			nast = 100;
			heard = 100;
			goto m1;
			break;
		default:
			goto m1;
			break;
		}
		break;
	case 2:
	m2:
		system("CLS");
		title("Робота");
		cout << " 1. Прибирати в школi\n 2. Замiтати двори\n 3. Працювати на будiвництвi\n 4. Мити машини\n 5. Працювати кур'єром\n 6. Працювати в McDonald's\n 7. Працювати на заводi\n 8. Навчати дiтей в школi\n 9. Працювати бухгалтером\n 10. Працювати в бiднiй компанiї\n 11. Працювати в офiсi\n 12. Працювати в крутiй компанiї\n 13. Працювати в Samsung\n 14. Працювати в Google\n 15. Сюди нажимати продажним журналiстам i тим в кого бомбить. (Для допитливих кажу - нiчого цiкавого тут нема)\n 16. Повернутися в меню\n";
		infbar();
		if (nom_menu2 >= 1 && nom_menu2 <= 14 && is_unemp == 1) {
			cout << "Ви не можете працювати, доки маєте посвiтчення безробiтнього." << endl;
			goto m2;
		}
		if (nom_menu2 >= 1 && nom_menu2 <= 14 && is_inv == 1) {
			cout << "Ви iнвалiд, тому вас не беруть на роботу." << endl;
			goto m2;
		}
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			system("CLS");
			if (h_s[2] == 1 && h_t[2] && score>200 || h_s[2] == 1 && h_t[3] && score>200 || h_s[2] == 1 && h_t[4] && score>200 || h_s[2] == 1 && h_t[5] && score>200 || h_s[2] == 1 && h_t[6] && score>200 || h_s[2] == 1 && h_t[7] && score>200 || h_s[2] == 1 && h_t[8] && score>200 || h_s[2] == 1 && h_t[9] && score>200) {
				money = money + 100;
				rep_ev(20, 2, 2, 1);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб прибирати в школi, вам потрiбно вивчити таблицю множення, купити хочаб кеди i мати рейтинг бiльший за 200" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 2:
			system("CLS");
			if (h_s[3] == 1 && h_t[3] && score>500 || h_s[3] == 1 && h_t[4] && score>500 || h_s[3] == 1 && h_t[5] && score>500 || h_s[3] == 1 && h_t[6] && score>500 || h_s[3] == 1 && h_t[7] && score>500 || h_s[3] == 1 && h_t[8] && score>500 || h_s[3] == 1 && h_t[9] && score>500) {
				money = money + 200;
				rep_ev(40, 3, 2, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб замiтати двори, вам потрiбно закiнчити школу, купити ровер або щось дороще i мати рейтинг бiльший за 500" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 3:
			system("CLS");
			if (h_s[4] == 1 && h_t[4] && score>1000 || h_s[4] == 1 && h_t[5] && score>1000 || h_s[4] == 1 && h_t[6] && score>1000 || h_s[4] == 1 && h_t[7] && score>1000 || h_s[4] == 1 && h_t[8] && score>1000 || h_s[4] == 1 && h_t[9] && score>1000) {
				money = money + 500;
				rep_ev(50, 2, 1, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати на будiвництвi, вам потрiбно закiнчити ПТУ, купити жигуль або кращу машину i мати рейтинг бiльший за 1 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 4:
			system("CLS");
			if (h_s[4] == 1 && h_t[4] && score>1000 || h_s[4] == 1 && h_t[5] && score>1000 || h_s[4] == 1 && h_t[6] && score>1000 || h_s[4] == 1 && h_t[7] && score>1000 || h_s[4] == 1 && h_t[8] && score>1000 || h_s[4] == 1 && h_t[9] && score>1000) {
				money = money + 700;
				rep_ev(80, 2, 2, 1);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб мити машини, вам потрiбно закiнчити ПТУ, купити жигуль або кращу машину i мати рейтинг бiльший за 1 500" << endl;
				system("pause");
			}
			goto m2;
			break;
		case 5:
			system("CLS");
			if (h_s[5] == 1 && h_t[5] && score>2000 || h_s[5] == 1 && h_t[6] && score>2000 || h_s[5] == 1 && h_t[7] && score>2000 || h_s[5] == 1 && h_t[8] && score>2000 || h_s[5] == 1 && h_t[9] && score>2000) {
				money = money + 1000;
				rep_ev(120, 1, 3, 2);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати кур'єром, вам потрiбно закiнчити державний ВУЗ, мати BMW або крутiшу машину i рейтинг бiльший за 2 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 6:
			system("CLS");
			if (h_s[5] == 1 && h_t[5] && score>5000 || h_s[5] == 1 && h_t[6] && score>5000 || h_s[5] == 1 && h_t[7] && score>5000 || h_s[5] == 1 && h_t[8] && score>5000 || h_s[5] == 1 && h_t[9] && score>5000) {
				money = money + 1500;
				rep_ev(200, -1, 1, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в McDonald's, вам потрiбно закiнчити державний ВУЗ, мати BMW або крутiшу машину i рейтинг бiльший за 5 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 7:
			system("CLS");
			if (h_s[5] == 1 && h_t[5] && score>10000 || h_s[5] == 1 && h_t[6] && score>10000 || h_s[5] == 1 && h_t[7] && score>10000 || h_s[5] == 1 && h_t[8] && score>10000 || h_s[5] == 1 && h_t[9] && score>10000) {
				money = money + 2200;
				rep_ev(250, 1, 2, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати на заводi, вам потрiбно закiнчити класний ВУЗ, мати BMW або крутiшу машину i рейтинг бiльший за 10 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 8:
			system("CLS");
			if (h_s[5] == 1 && h_t[5] && score>15000 || h_s[5] == 1 && h_t[6] && score>15000 || h_s[5] == 1 && h_t[7] && score>15000 || h_s[5] == 1 && h_t[8] && score>15000 || h_s[5] == 1 && h_t[9] && score>15000) {
				money = money + 2500;
				rep_ev(300, 2, 3, 1);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб навчати дiтей в школi, вам потрiбно закiнчити класний ВУЗ, мати BMW або крутiшу машину i рейтинг бiльший за 15 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 9:
			system("CLS");
			if (h_s[6] == 1 && h_t[6] && score>50000 || h_s[6] == 1 && h_t[7] && score>50000 || h_s[6] == 1 && h_t[6] && score>50000 || h_s[6] == 1 && h_t[9] && score>50000) {
				money = money + 3000;
				rep_ev(500, 2, 2, 1);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати бухгалтером, вам потрiбно закiнчити вчитися закордоном, мати Mercedes Benz або крутiшу машину i рейтинг бiльший за 50 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 10:
			system("CLS");
			if (h_s[6] == 1 && h_t[6] && score>100000 || h_s[6] == 1 && h_t[7] && score>100000 || h_s[6] == 1 && h_t[6] && score>100000 || h_s[6] == 1 && h_t[9] && score>100000) {
				money = money + 3500;
				rep_ev(700, 2, 3, 2);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в бiднiй компанiї, вам потрiбно вивчити таблицю множення, купити ровер i мати рейтинг бiльший за 100 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 11:
			system("CLS");
			if (h_s[6] == 1 && h_t[6] && score>200000 || h_s[6] == 1 && h_t[7] && score>200000 || h_s[6] == 1 && h_t[6] && score>200000 || h_s[6] == 1 && h_t[9] && score>200000) {
				money = money + 5000;
				rep_ev(1000, 2, 1, 1);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в офiсi, вам потрiбно вивчити таблицю множення, купити ровер i мати рейтинг бiльший за 200 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 12:
			system("CLS");
			if (h_s[7] == 1 && h_t[7] && score>500000 || h_s[7] == 1 && h_t[8] && score>500000 || h_s[7] == 1 && h_t[9] && score>500000) {
				money = money + 10000;
				rep_ev(1500, 1, 1, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в крутiй компанiї, вам потрiбно вчитися закордоном, мати круту тачку i рейтинг бiльший за 500 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 13:
			system("CLS");
			if (h_s[7] == 1 && h_t[8] && score>500000 || h_s[7] == 1 && h_t[9] && score>500000) {
				money = money + 15000;
				rep_ev(2000, 1, 1, 3);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в Samsung, вам потрiбно вчитися закордоном, купити Ferrari i мати рейтинг бiльший за 1 000 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 14:
			system("CLS");
			if (h_s[8] == 1 && h_t[9] && score>500000) {
				money = money + 20000;
				rep_ev(3000, 3, -1, 0);// score food nast heard
				cout << endl;
			}
			else {
				cout << "Щоб працювати в Google, вам потрiбно закiнчити Гарвард, купити приватний лiтак i мати рейтинг бiльший за 2 000 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 15:
			system("CLS");
			title("Просто iнформацiя");
			cout << "Ця гра створювалася не з метою образити когось. Список професiй не сорторовпно за \"крутiстю\". При створенi гри, нiхто \nне мав намiрiв образити певнi професiї.\n\nНу що журналiсти, тепер нема з вiдки матерiал брати, а?\n" << endl;
			system("pause");
			goto m2;
			break;
		case 16:
			goto game;
			break;
		default:
			goto m2;
			break;
		}
		break;
	case 3:
	m3:
		system("CLS");
		title("Бiзнес");
		if (h_b[1] == 0)
			cout << " 1. Здавати в оренду квартиру ( + 30 000 грн / мiс)\n";
		else
			cout << " 1. Не здавати в оренду квартиру ( - 30 000 грн / мiс)\n";
		if (h_b[2] == 0)
			cout << " 2. Здавати в оренду iпотеку ( + 50 000 грн / мiс)\n";
		else
			cout << " 2. Не здавати в оренду iпотеку ( - 50 000 грн / мiс)\n";
		if (h_b[3] == 0)
			cout << " 3. Здавати в оренду квартиру закордоном ( + 2 000 $ / мiс)\n";
		else
			cout << " 3. Не здавати в оренду квартиру закордоном ( - 2 000 $ / мiс)\n";
		if (h_b[4] == 0)
			cout << " 4. Здавати в оренду острiв ( + 30 000 $ / мiс)\n";
		else
			cout << " 4. Не здавати в оренду острiв ( - 30 000 $ / мiс)\n";
		if (h_b[5] == 0)
			cout << " 5. Здавати в оренду групу островiв ( + 100 000 $ / мiс )\n";
		else
			cout << " 5. Не здавати в оренду групу островiв ( - 100 000 $ / мiс )\n";
		if (h_b[6] == 0)
			cout << " 6. Здавати в оренду Мальдiви ( + 240 000 $ / мiс )\n";
		else
			cout << " 6. Не здавати в оренду Мальдiви ( - 240 000 $ / мiс )\n";
		if (h_b[0] == 0)
			cout << " 7. Здавати в оренду Мадагаскар ( + 400 000 $ / мiс )\n";
		else
			cout << " 7. Не здавати в оренду Мадагаскар ( - 400 000 $ / мiс )\n";
		cout << " 8. Керувати магазином\n 9. Керувати рестораном\n 10. Керувати фермою\n 11. Керувати офiсом\n 12. Керувати готелем\n 13. Керувати казином\n 14. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_b[1] == 0 && h_h[6] == 1 && score>200) {
				h_d2[1] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[1] = 30;
				cout << "Вiтаємо! Ви здаєте квартиру в оренду. " << h_d2[1] << " дня кожного мiсяця ви будете отримувати 30 000 грн." << endl;
				h_b[1] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_1;
			}
			if (h_h[6] == 0) {
				cout << "Ви не маєте квартири!" << endl;
				goto m3_1;
			}
			if (score<200 && h_b[1] == 0) {
				cout << "Ви не можете здати квартиру, якщо ваший рейтинг менший за 200." << endl;
				goto m3_1;
			}
			if (h_b[1] == 1) {
				h_d2[1] = 0;
				h_b[1] = 0;
				cout << "Ви бiльше не здаєте квартиру." << endl;
			}
		m3_1:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 2:
			if (h_b[2] == 0 && h_h[7] == 1 && score>500) {
				h_d2[2] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[2] = 30;
				cout << "Вiтаємо! Ви здаєте iпотеку в оренду. " << h_d2[2] << " дня кожного мiсяця ви будете отримувати 50 000 грн." << endl;
				h_b[2] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_2;
			}
			if (h_h[7] == 0) {
				cout << "Ви не маєте iпотеки!" << endl;
				goto m3_2;
			}
			if (score<500 && h_b[2] == 0) {
				cout << "Ви не можете здати iпотеку, якщо ваший рейтинг менший за 500." << endl;
				goto m3_2;
			}
			if (h_b[2] == 1) {
				h_d2[2] = 0;
				h_b[2] = 0;
				cout << "Ви бiльше не здаєте iпотеку." << endl;
			}
		m3_2:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 3:
			if (h_b[3] == 0 && h_h[8] == 1 && score>1000) {
				h_d2[3] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[3] = 30;
				cout << "Вiтаємо! Ви здаєте квартиру в оренду. " << h_d2[3] << " дня кожного мiсяця ви будете отримувати 2 000 $." << endl;
				h_b[3] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_3;
			}
			if (h_h[8] == 0) {
				cout << "Ви не маєте квартири!" << endl;
				goto m3_3;
			}
			if (score<1000 && h_b[3] == 0) {
				cout << "Ви не можете здати квартиру, якщо ваший рейтинг менший за 1 000." << endl;
				goto m3_3;
			}
			if (h_b[3] == 1) {
				h_d2[3] = 0;
				h_b[3] = 0;
				cout << "Ви бiльше не здаєте квартиру." << endl;
			}
		m3_3:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 4:
			if (h_b[4] == 0 && h_h[10] == 1 && score>5000) {
				h_d2[4] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[4] = 30;
				cout << "Вiтаємо! Ви здаєте острiв в оренду. " << h_d2[4] << " дня кожного мiсяця ви будете отримувати 30 000 $." << endl;
				h_b[4] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_4;
			}
			if (h_h[10] == 0) {
				cout << "Ви не маєте острову!" << endl;
				goto m3_4;
			}
			if (score<5000 && h_b[4] == 0) {
				cout << "Ви не можете здати острiв, якщо ваший рейтинг менший за 5 000." << endl;
				goto m3_4;
			}
			if (h_b[4] == 1) {
				h_d2[4] = 0;
				h_b[4] = 0;
				cout << "Ви бiльше не здаєте острiв." << endl;
			}
		m3_4:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 5:
			if (h_b[5] == 0 && h_h[11] == 1 && score>20000) {
				h_d2[5] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[5] = 30;
				cout << "Вiтаємо! Ви здаєте групу островiв в оренду. " << h_d2[5] << " дня кожного мiсяця ви будете отримувати 100 000 $." << endl;
				h_b[5] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_5;
			}
			if (h_h[11] == 0) {
				cout << "Ви не маєте групи островiв!" << endl;
				goto m3_5;
			}
			if (score<20000 && h_b[5] == 0) {
				cout << "Ви не можете здати групу островiв, якщо ваший рейтинг менший за 20 000." << endl;
				goto m3_5;
			}
			if (h_b[5] == 1) {
				h_d2[5] = 0;
				h_b[5] = 0;
				cout << "Ви бiльше не здаєте групу островiв." << endl;
			}
		m3_5:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 6:
			if (h_b[6] == 0 && h_h[12] == 1 && score>20000) {
				h_d2[6] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[6] = 30;
				cout << "Вiтаємо! Ви здаєте Мальдiви в оренду. " << h_d2[6] << " дня кожного мiсяця ви будете отримувати 240 000 $." << endl;
				h_b[6] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_6;
			}
			if (h_h[12] == 0) {
				cout << "Ви не маєте групи островiв!" << endl;
				goto m3_6;
			}
			if (score<50000 && h_b[6] == 0) {
				cout << "Ви не можете здати Мальдiви, якщо ваший рейтинг менший за 50 000." << endl;
				goto m3_6;
			}
			if (h_b[6] == 1) {
				h_d2[6] = 0;
				h_b[6] = 0;
				cout << "Ви бiльше не здаєте Мальдiви." << endl;
			}
		m3_6:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 7:
			if (h_b[0] == 0 && h_h[13] == 1 && score>100000) {
				h_d2[0] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[0] = 30;
				cout << "Вiтаємо! Ви здаєте Мадагаскар в оренду. " << h_d2[0] << " дня кожного мiсяця ви будете отримувати 10 000 000 $." << endl;
				h_b[0] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_7;
			}
			if (h_h[13] == 0) {
				cout << "Ви не маєте групи островiв!" << endl;
				goto m3_7;
			}
			if (score<100000 && h_b[0] == 0) {
				cout << "Ви не можете здати Мадагаскар, якщо ваший рейтинг менший за 100 000." << endl;
				goto m3_7;
			}
			if (h_b[0] == 1) {
				h_d2[0] = 0;
				h_b[0] = 0;
				cout << "Ви бiльше не здаєте Мадагаскар." << endl;
			}
		m3_7:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 8:
			p_bis("магазин", "магазином", "магазинi", 1, 1);//ресторан, рестораном, ресторанi, коефiцiент пропорц, поряд номер бiзнесу
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 9:
			p_bis("ресторан", "рестораном", "ресторанi", 2, 2);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 10:
			p_bis("ферму", "фермою", "фермi", 3, 3);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 11:
			p_bis("офiс", "офiсом", "офiсом", 4, 4);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 12:
			p_bis("готель", "готелем", "готелем", 10, 5);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 13:
			p_bis("казино", "казином", "казино", 20, 0);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 14:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m3;
			break;
		}

		goto game;
		break;
	case 4:
	m4:
		system("CLS");
		title("Їжа");
		cout << " 1. Шукати їжу на смiтнику\n 2. Купити пончик (25 грн)\n 3. Купити шаурму (35 грн)\n 4. Поїсти в шкiльнiй їдальнi (60 грн)\n 5. Купити їжу в супермаркетi (200 грн)\n 6. Поїсти в ресторанi (500 грн)\n 7. Замовити їжу до дому (1000 грн)\n";
		if (h_t[0] == 0)
			cout << " 8. Найняти повара (10 000 грн / день)";
		else
			cout << " 8. Звiльнити повара (+10 000 грн / день)";
		cout << "\n 9. Повернутися в меню" << endl;
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			p_fnh(1, 2, 0, 1, 3, 3, 0);// f0-type(fnh)      i = +score = rand() % f1 +f2      f3-+fnh      f4-f5 -- repev 1 2 3 (1 = 0 4 5? 2 = 4 0 5? 3 = 4 5 0)      f6 -- money
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 2:
			p_fnh(1, 4, 1, 7, 1, 1, 25);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 3:
			p_fnh(1, 5, 3, 10, 0, 0, 35);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 4:
			p_fnh(1, 8, 3, 15, -1, -1, 60);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 5:
			p_fnh(1, 10, 5, 25, -2, -2, 200);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 6:
			p_fnh(1, 25, 10, 40, -3, -3, 500);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 7:
			p_fnh(1, 30, 15, 60, -3, -3, 1000);
			system("pause");
			system("CLS");
			goto m4;
			break;
		case 8:
			if (h_t[0] == 0) {
				h_t[0] = 1;
				cout << "Вiтаємо, ви найняли повара. Вам бiльше не треба турбуватися про ситiсть." << endl;
				rep_ev(10000, 0, 0, 0);
			}
			else {
				cout << "Ви звiльнили повара, +10 000 грн / день." << endl;
				h_t[0] = 0;
				score = score - 10000;
			}
			system("CLS");
			goto m4;
			break;
		case 9:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m4;
			break;
		}

		goto game;
		break;
	case 5:
	m5:
		system("CLS");
		title("Розваги");
		cout << " 1. Дивитися на перехожих\n 2. Купити газету (25 грн)\n 3. Купити квас (35 грн)\n 4. Купити пиво (60 грн)\n 5. Купити вiскi (200 грн)\n 6. Випити дорогий самогон (500 грн)\n 7. Купити старовинне вино(1000 грн)\n";
		if (h_t[1] == 0)
			cout << " 8. Записатися в клуб (10 000 грн / день)";
		else
			cout << " 8. Не ходити в клуб (+10 000 грн / день)";
		cout << "\n 9. Повернутися в меню" << endl;
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			p_fnh(2, 2, 0, 1, 3, 1, 0);// f0-type(fnh)      i = +score = rand() % f1 +f2      f3-+fnh      f4-f5 -- repev 1 2 3 (1 = 0 4 5? 2 = 4 0 5? 3 = 4 5 0)      f6 -- money
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 2:
			p_fnh(2, 4, 1, 7, 3, 0, 25);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 3:
			p_fnh(2, 5, 3, 10, 0, 1, 35);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 4:
			p_fnh(2, 8, 3, 15, 0, 3, 60);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 5:
			p_fnh(2, 10, 5, 25, -1, -1, 200);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 6:
			p_fnh(2, 25, 10, 40, -1, 2, 500);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 7:
			p_fnh(2, 30, 15, 60, -2, 2, 1000);
			system("pause");
			system("CLS");
			goto m5;
			break;
		case 8:
			if (h_t[1] == 0) {
				h_t[1] = 1;
				cout << "Вiтаємо, ви записалися в клуб. Вам бiльше не треба турбуватися про настрiй." << endl;
				rep_ev(10000, 0, 0, 0);
			}
			else {
				cout << "Ви покинули клуб, +10 000 грн / день." << endl;
				h_t[1] = 0;
				score = score - 10000;
			}
			system("CLS");
			goto m5;
			break;
		case 9:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m5;
			break;
		}

		goto game;
		break;
	case 6:
	m6:
		system("CLS");
		title("Здоров'я");
		cout << " 1. Молитися\n 2. Полiчитися в бабки(25 грн)\n 3. Сходити до справжнього лiкаря (35 грн)\n 4. Вiдвiдати санаторiй(60 грн)\n 5. Вiдвiдати дешеву лiкарню(200 грн)\n 6. Вiдвiдати круту клiнiку(500 грн)\n 7. Лiкуватися в iзраїлi(1000 грн)\n 8. Зробити пробiжку\n 9. ";
		if (h_s[0] == 0)
			cout << "Найняти тренера (10 000 грн / день)";
		else
			cout << "Звiльнити тренера (+10 000 грн / день)";
		cout << "\n 10. Повернутися в меню";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			p_fnh(3, 2, 0, 1, 1, 3, 0);// f0-type(fnh)      i = +score = rand() % f1 +f2      f3-+fnh      f4-f5 -- repev 1 2 3 (1 = 0 4 5? 2 = 4 0 5? 3 = 4 5 0)      f6 -- money
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 2:
			p_fnh(3, 4, 1, 7, 2, 3, 25);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 3:
			p_fnh(3, 5, 3, 10, 1, 1, 35);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 4:
			p_fnh(3, 8, 3, 15, 0, 0, 60);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 5:
			p_fnh(3, 10, 5, 25, 0, -1, 200);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 6:
			p_fnh(3, 25, 10, 40, -1, -1, 500);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 7:
			p_fnh(3, 30, 15, 60, -1, -2, 1000);
			system("pause");
			system("CLS");
			goto m6;
			break;
		case 8:
			if (h_t[2] == 0) {
				cout << "Спершу купiть красовки\n";
				system("CLS");
			}
			else {
				p_fnh(3, 15, 10, 15, 3, -1, 0);
			}
			system("CLS");
			goto m6;
			break;
		case 9:
			if (h_s[0] == 0) {
				if (h_t[2] == 0) {
					cout << "Спершу купiть красовки\n";
					system("CLS");
				}
				else {
					h_s[0] = 1;
					score = score + 10000;
				}
			}
			else {
				h_s[0] = 0;
				score = score - 10000;
			}
			system("CLS");
			goto m6;
			break;
		case 10:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m6;
			break;
		}
		goto game;
		break;
	case 7:
	m7:
		system("CLS");
		title("Освiта");
		cout << " 1. Пробувати рахувати\n";
		if (h_s[2] == 0)
			cout << " 2. Вивчити таблицю множення (100 грн)\n";
		else
			cout << " 2. Ви вивчили таблцю множення\n";
		if (h_s[3] == 0)
			cout << " 3. Закiнчити школу (30 000 грн)\n";
		else
			cout << " 3. Ви вже вивчилися в школi\n";
		if (h_s[4] == 0)
			cout << " 4. Закiнчити ПТУ (50 000 грн)\n";
		else
			cout << " 4. ПТУ закiнчено!\n";
		if (h_s[5] == 0)
			cout << " 5. Пiти в державний ВУЗ (100 000 грн)\n";
		else
			cout << " 5. Ви закiнчили державний ВУЗ\n";
		if (h_s[6] == 0)
			cout << " 6. Закiнчити класний ВУЗ (500 000 грн)\n";
		else
			cout << " 6. ВУЗ закiнчено\n";
		if (h_s[7] == 0)
			cout << " 7. Вчитися закордоном (250 000 $)\n";
		else
			cout << " 7. Ви вже вивчилися закордоном\n";
		if (h_s[8] == 0)
			cout << " 8. Закiнчити Гарвард (1 000 000 $)\n";
		else
			cout << " 8. Гарвард закiнчено\n";
		cout << " 9. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_s[2] == 0) {
				i = rand() % 10;
				if (i == 0) {
					cout << "Вiтаємо, ви вивчили таблицю множення!" << endl;
					rep_ev(200, 3, -3, 1);
					h_s[2] = 1;
				}
				else {
					cout << "Ви нiчого не вивчили." << endl;
					rep_ev(0, 3, 3, 1);
				}
			}
			system("pause");
			system("CLS");
			goto m7;
			break;
		case 2:
			if (h_s[2] == 0 && money >= 100) {
				cout << "Вiтаємо! Ви вивчили таблицю множення." << endl;
				money = money - 100;
				rep_ev(100, 0, 0, 0);
				h_s[2] = 1;
				system("pause");
			}
			if (h_s[2] == 0 && money<100) {
				cout << "Недостатньо грошей!" << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 3:
			if (h_s[3] == 0 && money >= 30000) {
				cout << "Вiтаємо! Ви закiнчити школу." << endl;
				money = money - 30000;
				rep_ev(200, 0, 0, 0);
				system("pause");
				h_s[3] = 1;
			}
			if (h_s[3] == 0 && money<15000) {
				cout << "Недостатньо грошей!" << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 4:
			if (h_s[3] == 1) {
				if (h_s[4] == 0 && money >= 50000) {
					cout << "Вiтаємо! Ви закiнчили ПТУ." << endl;
					money = money - 50000;
					rep_ev(500, 0, 0, 0);
					h_s[4] = 1;
					system("pause");
				}
				if (h_s[4] == 0 && money<50000) {
					cout << "Недостатньо грошей!" << endl;
					system("pause");
				}
			}
			else {
				cout << "Вам не пустять в ПТУ якщо ви не закiнчили школу." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 5:
			if (h_s[3] == 1) {
				if (h_s[5] == 0 && money >= 100000) {
					cout << "Вiтаємо! Ви пiшлии в державний ВУЗ." << endl;
					system("pause");
					money = money - 100000;
					rep_ev(1000, 0, 0, 0);
					h_s[5] = 1;
				}
				if (h_s[5] == 0 && money<100000)
					cout << "Недостатньо грошей!" << endl;
					system("pause");
			}
			else {
				cout << "Вам не пустять в державний ВУЗ якщо ви не закiнчили школу." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 6:
			if (h_s[3] == 1 && h_t[5] == 1 || h_s[3] == 1 && h_t[6] == 1 || h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[6] == 0 && money >= 500000) {
					cout << "Вiтаємо! Ви закiнили класний ВУЗ." << endl;
					money = money - 1000000;
					rep_ev(10000, 0, 0, 0);
					h_s[6] = 1;
					system("pause");
				}
				if (h_s[6] == 0 && money<500000) {
					cout << "Недостатньо грошей!" << endl;
					system("pause");
				}
			}
			else {
				cout << "Вас не пустять в класний ВУЗ, якщо ви не закiнчили школу i не маєте машини дорощу за 50 000 грн." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 7:
			if (h_s[3] == 1 && h_t[5] == 1 || h_s[3] == 1 && h_t[6] == 1 || h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[7] == 0 && money2 >= 250000) {
					cout << "Вiтаємо! Ви закiнчили закордонний ВУЗ." << endl;
					money2 = money2 - 250000;
					rep_ev(50000, 0, 0, 0);
					h_s[7] = 1;
					system("pause");
				}
				if (h_s[7] == 0 && money2<250000) {
					cout << "Недостатньо грошей!" << endl;
					system("pause");
				}
			}
			else {
				cout << "Вас не пустять в закордонний ВУЗ, якщо ви не закiнчили школу i не маєте машини дорощу за 50 000 грн." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 8:
			if (h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[8] == 0 && money2 >= 1000000) {
					cout << "Вiтаємо! Ви закiнчили Гарвард." << endl;
					money2 = money2 - 1000000;
					rep_ev(100000, 0, 0, 0);
					h_s[8] = 1;
					system("pause");
				}
				if (h_s[8] == 0 && money2<1000000) {
					cout << "Недостатньо грошей!" << endl;
					system("pause");
				}
			}
			else {
				cout << "Вас не пустять в Гарвард, якщо ви не закiнчили школу i не маєте машини дорощу за 200 000 $." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 9:
			system("CLS");
			goto game;
			break;
		default:
			goto m7;
			break;
		}
	case 8:
	m8:
		system("CLS");
		title("Транспорт");
		if (h_t[2] == 1)
			SetColor(8, 0);
		cout << " 1. Шукати взуття на смiтнику\n";
		SetColor(7, 0);
		if (h_t[2] == 0)
			cout << " 2. Купити кеди (200 грн)\n";
		else
			cout << " 2. Продати кеди (+100 грн)\n";
		if (h_t[3] == 0)
			cout << " 3. Купити ровер (2 000 грн)\n";
		else
			cout << " 3. Продати ровер (+1 000 грн)\n";
		if (h_t[4] == 0)
			cout << " 4. Купити жигуль (30 000 грн)\n";
		else
			cout << " 4. Продати жигуль (+15 000 грн)\n";
		if (h_t[5] == 0)
			cout << " 5. Купити Б/У BMW (100 000 грн)\n";
		else
			cout << " 5. Продати Б/У BMW (+50 000 грн)\n";
		if (h_t[6] == 0)
			cout << " 6. Купити нову Mercedes Benz (1 000 000 грн)\n";
		else
			cout << " 6. Продати Б/У Mercedes Benz (+500 000)\n";
		if (h_t[7] == 0)
			cout << " 7. Купити круту тачку (250 000 $)\n";
		else
			cout << " 7. Продати круту тачку (+125 000 $)\n";
		if (h_t[8] == 0)
			cout << " 8. Купити Ferrari (1 000 000 $)\n";
		else
			cout << " 8. Продати Ferrari ( +500 000 $)\n";
		if (h_t[9] == 0)
			cout << " 9. Купити приватний лiтак (2 500 000 $)\n";
		else
			cout << " 9. Продати приватний лiтак (+1 250 000 $)\n";
		cout << " 10. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_t[2] == 0) {
				i = rand() % 10;
				if (i == 0) {
					cout << "Вiтаємо, ви знайшли кеди!" << endl;
					rep_ev(200, 3, -3, 1);
					h_t[2] = 1;
				}
				else {
					cout << "Ви нiчого не знайшли." << endl;
					rep_ev(0, 3, 3, 1);
				}
			}
			else
				cout << "Ви вже маєте кеди!" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 2:
			if (h_t[2] == 0 && money >= 200) {
				cout << "Вiтаємо! Ви купили кеди." << endl;
				money = money - 200;
				rep_ev(100, 0, 0, 0);
				h_t[2] = 1;
			}
			else if (h_t[2] == 0 && money<200)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали кеди, +100 грн" << endl;
				rep_ev(0, 0, 0, 0);
				money = money + 100;
				h_t[2] = 0;
			}
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 3:
			if (h_t[2] == 1) {
				if (h_t[3] == 0 && money >= 2000) {
					cout << "Вiтаємо! Ви купили ровер." << endl;
					money = money - 2000;
					rep_ev(200, 0, 0, 0);
					h_t[3] = 1;
				}
				else if (h_t[3] == 0 && money<2000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали ровер, +1000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 1000;
					h_t[3] = 0;
				}
			}
			else
				cout << "Спершу купiть кеди!" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 4:
			if (h_t[2] == 1) {
				if (h_t[4] == 0 && money >= 30000) {
					cout << "Вiтаємо! Ви купили жигуль." << endl;
					money = money - 30000;
					rep_ev(500, 0, 0, 0);
					h_t[4] = 1;
				}
				else if (h_t[4] == 0 && money<30000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали жигуль, +15000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 15000;
					h_t[4] = 0;
				}
			}
			else
				cout << "Вам не продадуть машину, якщо ви босi" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 5:
			if (h_t[2] == 1) {
				if (h_t[5] == 0 && money >= 100000) {
					cout << "Вiтаємо! Ви купили Б/У BMW." << endl;
					money = money - 100000;
					rep_ev(1000, 0, 0, 0);
					h_t[5] = 1;
				}
				else if (h_t[5] == 0 && money<100000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали Б/У BMW, +50 000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 50000;
					h_t[5] = 0;
				}
			}
			else
				cout << "Вам не продадуть машину, якщо ви босi" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 6:
			if (h_t[2] == 1) {
				if (h_t[6] == 0 && money >= 1000000) {
					cout << "Вiтаємо! Ви купили нову Mercedes Benz." << endl;
					money = money - 1000000;
					rep_ev(10000, 0, 0, 0);
					h_t[6] = 1;
				}
				else if (h_t[6] == 0 && money<1000000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали Б/У Mercedes Benz, +500 000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 500000;
					h_t[6] = 0;
				}
			}
			else
				cout << "Вам не продадуть машину, якщо ви босi" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 7:
			if (h_t[2] == 1) {
				if (h_t[7] == 0 && money2 >= 250000) {
					cout << "Вiтаємо! Ви купили круту тачку." << endl;
					money2 = money2 - 250000;
					rep_ev(50000, 0, 0, 0);
					h_t[7] = 1;
				}
				else if (h_t[7] == 0 && money2<250000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали круту тачку, +125 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 125000;
					h_t[7] = 0;
				}
			}
			else
				cout << "Вам не продадуть машину, якщо ви босi" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 8:
			if (h_t[7] == 1) {
				if (h_t[8] == 0 && money2 >= 1000000) {
					cout << "Вiтаємо! Ви купили Ferrari." << endl;
					money2 = money2 - 1000000;
					rep_ev(100000, 0, 0, 0);
					h_t[8] = 1;
				}
				else if (h_t[8] == 0 && money2<1000000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали Ferrari, +500000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 100;
					h_t[8] = 0;
				}
			}
			else
				cout << "Вас не пустять в салон без нормальної машини" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 9:
			if (h_t[8] == 1) {
				if (h_t[9] == 0 && money2 >= 2500000) {
					cout << "Вiтаємо! Ви купили приватний лiтак." << endl;
					money2 = money2 - 2500000;
					rep_ev(100, 0, 0, 0);
					h_t[9] = 1;
				}
				else if (h_t[9] == 0 && money2<2500000)
					cout << "Недостатньо грошей!" << endl;
				else {
					cout << "Ви продали приватний лiтак, +1250000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 100;
					h_t[9] = 0;
				}
			}
			else
				cout << "Вам не продадуть лiтак, якщо ви без Ferrari" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 10:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m8;
			break;
		}

		goto game;
		break;
	case 9:
	m9:
		system("CLS");
		title("Житло");
		if (h_h[1] == 0)
			cout << " 1. Купити коробку ( 200 грн )\n";
		else
			cout << " 1. Продати коробку ( + 100 грн )\n";
		if (h_h[2] == 0)
			cout << " 2. Орендувати кiмнату в гуртожитку ( - 10 000 грн / мiс )\n";
		else
			cout << " 2. Не орендувати кiмнату в гуртожитку ( + 10 000 грн / мiс)\n";
		if (h_h[3] == 0)
			cout << " 3. Жити в 3 зiрковому готелi ( - 20 000 грн / мiс )\n";
		else
			cout << " 3. Виїхати з 3 зiркового готелю ( + 20 000 грн / мiс )\n";
		if (h_h[4] == 0)
			cout << " 4. Знiмати квартиру ( - 30 000 грн / мiс )\n";
		else
			cout << " 4. Не знiмати квартиру ( + 30 000 грн / мiс )\n";
		if (h_h[5] == 0)
			cout << " 5. Знiмати iпотеку ( - 50 000 грн / мiс )\n";
		else
			cout << " 5. Виїхати з iпотеки ( + 50 000 грн / мiс )\n";
		if (h_h[6] == 0)
			cout << " 6. Купити квартиру ( 500 000 грн )\n";
		else
			cout << " 6. Продати квартиру ( +250 000 грн )\n";
		if (h_h[7] == 0)
			cout << " 7. Купити iпотеку ( 1 000 000 грн )\n";
		else
			cout << " 7. Продати iпотеку ( 500 000 грн )\n";
		if (h_h[8] == 0)
			cout << " 8. Купити квартиру закордоном ( 50 000 $)\n";
		else
			cout << " 8. Продати квартиру закордоном ( + 25 000 $)\n";
		if (h_h[9] == 0)
			cout << " 9. Купити маєток закордоном ( 150 000 $)\n";
		else
			cout << " 9. Продати маєток закордоном ( + 75 000 $)\n";
		if (h_h[10] == 0)
			cout << " 10. Купити острiв ( 500 000 $)\n";
		else
			cout << " 10. Продати острiв ( + 250 000 $)\n";
		if (h_h[11] == 0)
			cout << " 11. Купити групу островiв ( 1 500 000 $)\n";
		else
			cout << " 11. Продати групу островiв ( 750 000 $)\n";
		if (h_h[12] == 0)
			cout << " 12. Купити Мальдiви ( 3 000 000 $)\n";
		else
			cout << " 12. Продати Мальдiви ( 1 500 000 $)\n";
		if (h_h[13] == 0)
			cout << " 13. Купити Мадагаскар ( 10 000 000 $)\n";
		else
			cout << " 13. Продати Мадагаскар ( 5 000 000 $)\n";
		cout << " 14. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_h[1] == 0 && money >= 200) {
				cout << "Вiтаємо! Ви купили коробку." << endl;
				money = money - 200;
				rep_ev(100, 0, 0, 0);
				h_h[1] = 1;
				goto m9_1;
			}
			else if (h_h[1] == 0 && money<200) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_1;
			}
			else {
				cout << "Ви продали коробку, +100 грн" << endl;
				rep_ev(0, 0, 0, 0);
				money = money + 100;
				h_h[1] = 0;
				score = score - 100;
			}
		m9_1:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 2:
			if (h_h[2] == 0 && money >= 10000) {
				h_date[2] = date[3] + 2;
				cout << "Вiтаємо! Ви орендуєте кiмнату в гуртожитку. " << h_date[2] << " дня, кожного мiсяця, з вас будуть брати 10 000 грн." << endl;
				rep_ev(200, 0, 0, 0);
				h_h[2] = 1;
			}
			else if (h_h[2] == 0 && money<10000) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_2;
			}
			else {
				cout << "Ви бiльше не орендуєте кiмнату в гуртожитку." << endl;
				h_h[2] = 0;
				rep_ev(0, 0, 0, 0);
				score = score - 200;
			}
		m9_2:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 3:
			if (h_h[3] == 0 && money >= 10000) {
				h_date[3] = date[3] + 2;
				cout << "Вiтаємо! Ви живете в гуртожитку. " << h_date[3] << " дня, кожного мiсяця, з вас будуть брати 20 000 грн." << endl;
				rep_ev(500, 0, 0, 0);
				h_h[3] = 1;
			}
			else if (h_h[3] == 0 && money<10000) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_3;
			}
			else {
				cout << "Ви бiльше не орендуєте кiмнату в гуртожитку." << endl;
				h_h[3] = 0;
				rep_ev(0, 0, 0, 0);
				score = score - 500;
			}
		m9_3:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 4:
			if (h_h[4] == 0 && money >= 30000) {
				h_date[4] = date[3] + 2;
				cout << "Вiтаємо! Ви знiмаєте квартиру. " << h_date[4] << " дня, кожного мiсяця, з вас будуть брати 30 000 грн." << endl;
				rep_ev(1000, 0, 0, 0);
				h_h[4] = 1;
			}
			else if (h_h[4] == 0 && money<30000) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_4;
			}
			else {
				cout << "Ви бiльше не орендуєте кiмнату." << endl;
				h_h[4] = 0;
				rep_ev(0, 0, 0, 0);
				score = score - 1000;
			}
		m9_4:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 5:
			if (h_h[5] == 0 && money >= 50000) {
				h_date[5] = date[3] + 2;
				cout << "Вiтаємо! Ви знiмаєте iпотеку. " << h_date[5] << " дня, кожного мiсяця, з вас будуть брати 50 000 грн." << endl;
				rep_ev(2000, 0, 0, 0);
				h_h[5] = 1;
			}
			else if (h_h[5] == 0 && money<10000) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_5;
			}
			else {
				cout << "Ви бiльше не орендуєте кiмнату в гуртожитку." << endl;
				h_h[5] = 0;
				rep_ev(0, 0, 0, 0);
				score = score - 2000;
			}
		m9_5:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 6:
			if (h_t[2] == 1) {
				if (h_h[6] == 0 && money >= 500000) {
					cout << "Вiтаємо! Ви купили нову квартиру." << endl;
					money = money - 500000;
					rep_ev(5000, 0, 0, 0);
					h_h[6] = 1;
				}
				else if (h_h[6] == 0 && money<500000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_6;
				}
				else {
					cout << "Ви продали квартиру, +250 000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 250000;
					h_h[6] = 0;
					score = score - 5000;
				}
			}
			else
				cout << "Вам не продадуть квартиру, якщо ви босi" << endl;
		m9_6:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 7:
			if (h_t[2] == 1) {
				if (h_h[7] == 0 && money >= 1000000) {
					cout << "Вiтаємо! Ви купили iпотеку." << endl;
					money = money - 1000000;
					rep_ev(15000, 0, 0, 0);
					h_h[7] = 1;
				}
				else if (h_h[7] == 0 && money<1000000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_7;
				}
				else {
					cout << "Ви продали iпотеку, + 500 000 грн" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 500000;
					score = score - 15000;
					h_h[7] = 0;
				}
			}
			else
				cout << "Вам не продадуть iпотеку, якщо ви босi" << endl;
		m9_7:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 8:
			if (h_h[8] == 0 && money2 >= 50000) {
				cout << "Вiтаємо! Ви купили квартиру закордоном." << endl;
				money2 = money2 - 50000;
				rep_ev(40000, 0, 0, 0);
				h_h[8] = 1;
			}
			else if (h_h[8] == 0 && money2<50000) {
				cout << "Недостатньо грошей!" << endl;
				goto m9_8;
			}
			else {
				cout << "Ви продали квартиру, + 25 000 $" << endl;
				rep_ev(0, 0, 0, 0);
				money2 = money2 + 25000;
				score = score - 40000;
				h_h[8] = 0;
			}
		m9_8:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 9:
			if (h_t[8] == 1) {
				if (h_h[9] == 0 && money2 >= 150000) {
					cout << "Вiтаємо! Ви купили маєток закордоном." << endl;
					money2 = money2 - 150000;
					rep_ev(100000, 0, 0, 0);
					h_h[9] = 1;
				}
				else if (h_h[9] == 0 && money2<150000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_9;
				}
				else {
					cout << "Ви продали приватний маєток, + 75 000 ;" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 75000;
					score = score - 100000;
					h_h[9] = 0;
				}
			}
			else
				cout << "Вам не продадуть маєток, якщо ви без Ferrari" << endl;
		m9_9:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 10:
			if (h_t[9] == 1) {
				if (h_h[10] == 0 && money2 >= 500000) {
					cout << "Вiтаємо! Ви купили острiв." << endl;
					money2 = money2 - 500000;
					rep_ev(200000, 0, 0, 0);
					h_h[10] = 1;
				}
				else if (h_h[10] == 0 && money2<500000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_10;
				}
				else {
					cout << "Ви продали острiв, + 250 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 250000;
					score = score - 200000;
					h_h[10] = 0;
				}
			}
			else
				cout << "Вам не продадуть острiв, якщо ви без приватного лiтака" << endl;
		m9_10:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 11:
			if (h_t[9] == 1) {
				if (h_h[11] == 0 && money2 >= 1500000) {
					cout << "Вiтаємо! Ви купили групу островiв." << endl;
					money2 = money2 - 1500000;
					rep_ev(500000, 0, 0, 0);
					h_h[11] = 1;
				}
				else if (h_h[11] == 0 && money2<1500000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_11;
				}
				else {
					cout << "Ви продали групу островiв, + 750 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 750000;
					score = score - 500000;
					h_h[11] = 0;
				}
			}
			else
				cout << "Вам не продадуть групу островiв, якщо ви без приватного лiтака" << endl;
		m9_11:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 12:
			if (h_t[9] == 1) {
				if (h_h[12] == 0 && money2 >= 3000000) {
					cout << "Вiтаємо! Ви купили Мальдiви." << endl;
					money2 = money2 - 3000000;
					rep_ev(1500000, 0, 0, 0);
					h_h[12] = 1;
				}
				else if (h_h[12] == 0 && money2<3000000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_12;
				}
				else {
					cout << "Ви продали Мальдiви, + 1 500 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 1500000;
					score = score - 1500000;
					h_h[12] = 0;
				}
			}
			else
				cout << "Вам не продадуть Мальдiви, якщо ви без приватного лiтака" << endl;
		m9_12:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 13:
			if (h_t[9] == 1) {
				if (h_h[13] == 0 && money2 >= 10000000) {
					cout << "Вiтаємо! Ви купили Мадагаскар." << endl;
					money2 = money2 - 10000000;
					rep_ev(15000000, 0, 0, 0);
					h_h[13] = 1;
				}
				else if (h_h[13] == 0 && money2<10000000) {
					cout << "Недостатньо грошей!" << endl;
					goto m9_13;
				}
				else {
					cout << "Ви продали Мадагаскар, + 5 000 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 5000000;
					score = score - 15000000;
					h_h[13] = 0;
				}
			}
			else
				cout << "Вам не продадуть Мадагаскар, якщо ви без приватного лiтака" << endl;
		m9_13:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 14:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m9;
			break;
		}

		goto game;
		break;
	case 10:
	m10:
		system("CLS");
		title("Нерухомiсть");
		if (h_n[1] == 0)
			cout << " 1. Купити магазин ( 500 000 грн )\n";
		else {
			cout << " 1. Продати магазин ( + ";
			if (upd[1] == 0)
				cout << 250000;
			if (upd[1] == 1)
				cout << 250000 + 0.5 * 250000;
			if (upd[1] == 2)
				cout << 250000 + 0.5 * 750000;
			if (upd[1] == 3)
				cout << 250000 + 0.5 * 1250000;
			if (upd[1] == 4)
				cout << 250000 + 0.5 * 2500000;
			if (upd[1] == 5)
				cout << 250000 + 0.5 * 7000000;
			cout << " грн )\n";
		}
		if (h_n[2] == 0)
			cout << " 2. Купити ресторан ( 1 000 000 грн )\n";
		else {
			cout << " 2. Продати ресторан ( + ";
			if (upd[2] == 0)
				cout << 2 * 250000;
			if (upd[2] == 1)
				cout << 2 * 250000 + 250000;
			if (upd[2] == 2)
				cout << 2 * 250000 + 750000;
			if (upd[2] == 3)
				cout << 2 * 250000 + 1250000;
			if (upd[2] == 4)
				cout << 2 * 250000 + 2500000;
			if (upd[2] == 5)
				cout << 2 * 250000 + 7000000;
			cout << " грн )\n";
		}
		if (h_n[3] == 0)
			cout << " 3. Купити ферму ( 1 500 000 грн )\n";
		else {
			cout << " 3. Продати ферму ( + ";
			if (upd[3] == 0)
				cout << 3 * 250000;
			if (upd[3] == 1)
				cout << 3 * 250000 + 1.5 * 250000;
			if (upd[3] == 2)
				cout << 3 * 250000 + 1.5 * 750000;
			if (upd[3] == 3)
				cout << 3 * 250000 + 1.5 * 1250000;
			if (upd[3] == 4)
				cout << 3 * 250000 + 1.5 * 2500000;
			if (upd[3] == 5)
				cout << 3 * 250000 + 1.5 * 7000000;
			cout << " грн )\n";
		}
		if (h_n[4] == 0)
			cout << " 4. Купити офiс ( 2 000 000 грн )\n";
		else {
			cout << " 4. Продати офiс ( + ";
			if (upd[4] == 0)
				cout << 4 * 250000;
			if (upd[4] == 1)
				cout << 4 * 250000 + 4 * 250000;
			if (upd[4] == 2)
				cout << 4 * 250000 + 4 * 750000;
			if (upd[4] == 3)
				cout << 4 * 250000 + 4 * 1250000;
			if (upd[4] == 4)
				cout << 4 * 250000 + 4 * 2500000;
			if (upd[4] == 5)
				cout << 4 * 250000 + 4 * 7000000;
			cout << " грн )\n";
		}
		if (h_n[5] == 0)
			cout << " 5. Купити готель ( 5 000 000 грн )\n";
		else {
			cout << " 5. Продати готель ( + ";
			if (upd[5] == 0)
				cout << 10 * 250000;
			if (upd[5] == 1)
				cout << 10 * 250000 + 10 * 250000;
			if (upd[5] == 2)
				cout << 10 * 250000 + 10 * 750000;
			if (upd[5] == 3)
				cout << 10 * 250000 + 10 * 1250000;
			if (upd[5] == 4)
				cout << 10 * 250000 + 10 * 2500000;
			if (upd[5] == 5)
				cout << 10 * 250000 + 10 * 7000000;
			cout << " грн )\n";
		}
		if (h_n[0] == 0)
			cout << " 6. Купити казино ( 10 000 000 грн )\n";
		else {
			cout << " 6. Продати казино ( + ";
			if (upd[0] == 0)
				cout << 20 * 250000;
			if (upd[0] == 1)
				cout << 20 * 250000 + 20 * 250000;
			if (upd[0] == 2)
				cout << 20 * 250000 + 20 * 750000;
			if (upd[0] == 3)
				cout << 20 * 250000 + 20 * 1250000;
			if (upd[0] == 4)
				cout << 20 * 250000 + 20 * 2500000;
			if (upd[0] == 5)
				cout << 20 * 250000 + 20 * 7000000;
			cout << " грн )\n";
		}
		cout << " 7. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_n[1] == 0 && money >= 500000) {
				cout << "Вiтаємо! Ви купили магазин." << endl;
				money = money - 500000;
				rep_ev(1000, 0, 0, 0);
				h_n[1] = 1;
			}
			else if (h_n[1] == 0 && money<500000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали магазин, +";
				if (upd[1] == 0)
					cout << 250000;
				if (upd[1] == 1)
					cout << 250000 + 0.5 * 250000;
				if (upd[1] == 2)
					cout << 250000 + 0.5 * 750000;
				if (upd[1] == 3)
					cout << 250000 + 0.5 * 1250000;
				if (upd[1] == 4)
					cout << 250000 + 0.5 * 2500000;
				if (upd[1] == 5)
					cout << 250000 + 0.5 * 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[1] == 0)
					money = money + 250000;
				if (upd[1] == 1)
					money = money + 250000 + 0.5 * 250000;
				if (upd[1] == 2)
					money = money + 250000 + 0.5 * 750000;
				if (upd[1] == 3)
					money = money + 250000 + 0.5 * 1250000;
				if (upd[1] == 4)
					money = money + 250000 + 0.5 * 2500000;
				if (upd[1] == 5)
					money = money + 250000 + 0.5 * 7000000;
				h_n[1] = 0;
				score = score - 1000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;
		case 2:
			if (h_n[2] == 0 && money >= 1000000) {
				cout << "Вiтаємо! Ви купили ресторан." << endl;
				money = money - 1000000;
				rep_ev(2000, 0, 0, 0);
				h_n[2] = 1;
			}
			else if (h_n[2] == 0 && money<1000000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали магазин, +";
				if (upd[2] == 0)
					cout << 2 * 250000;
				if (upd[2] == 1)
					cout << 2 * 250000 + 250000;
				if (upd[2] == 2)
					cout << 2 * 250000 + 750000;
				if (upd[2] == 3)
					cout << 2 * 250000 + 1250000;
				if (upd[2] == 4)
					cout << 2 * 250000 + 2500000;
				if (upd[2] == 5)
					cout << 2 * 250000 + 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[2] == 0)
					money = money + 2 * 250000;
				if (upd[2] == 1)
					money = money + 2 * 250000 + 250000;
				if (upd[2] == 2)
					money = money + 2 * 250000 + 750000;
				if (upd[2] == 3)
					money = money + 2 * 250000 + 1250000;
				if (upd[2] == 4)
					money = money + 2 * 250000 + 2500000;
				if (upd[2] == 5)
					money = money + 2 * 250000 + 7000000;
				h_n[2] = 0;
				score = score - 2000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;

		case 3:
			if (h_n[3] == 0 && money >= 1500000) {
				cout << "Вiтаємо! Ви купили ферму." << endl;
				money = money - 1500000;
				rep_ev(3000, 0, 0, 0);
				h_n[3] = 1;
			}
			else if (h_n[3] == 0 && money<1500000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали ферму, +";
				if (upd[3] == 0)
					cout << 3 * 250000;
				if (upd[3] == 1)
					cout << 3 * 250000 + 1.5 * 250000;
				if (upd[3] == 2)
					cout << 3 * 250000 + 1.5 * 750000;
				if (upd[3] == 3)
					cout << 3 * 250000 + 1.5 * 1250000;
				if (upd[3] == 4)
					cout << 3 * 250000 + 1.5 * 2500000;
				if (upd[3] == 5)
					cout << 3 * 250000 + 1.5 * 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[3] == 0)
					money = money + 3 * 250000;
				if (upd[3] == 1)
					money = money + 3 * 250000 + 1.5 * 250000;
				if (upd[3] == 2)
					money = money + 3 * 250000 + 1.5 * 750000;
				if (upd[3] == 3)
					money = money + 3 * 250000 + 1.5 * 1250000;
				if (upd[3] == 4)
					money = money + 3 * 250000 + 1.5 * 2500000;
				if (upd[3] == 5)
					money = money + 3 * 250000 + 1.5 * 7000000;
				h_n[3] = 0;
				score = score - 3000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;
		case 4:
			if (h_n[4] == 0 && money >= 2000000) {
				cout << "Вiтаємо! Ви купили офiс." << endl;
				money = money - 2000000;
				rep_ev(4000, 0, 0, 0);
				h_n[4] = 1;
			}
			else if (h_n[4] == 0 && money<2000000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали офiс, +";
				if (upd[4] == 0)
					cout << 4 * 250000;
				if (upd[4] == 1)
					cout << 4 * 250000 + 4 * 250000;
				if (upd[4] == 2)
					cout << 4 * 250000 + 4 * 750000;
				if (upd[4] == 3)
					cout << 4 * 250000 + 4 * 1250000;
				if (upd[4] == 4)
					cout << 4 * 250000 + 4 * 2500000;
				if (upd[4] == 5)
					cout << 4 * 250000 + 4 * 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[4] == 0)
					money = money + 4 * 250000;
				if (upd[4] == 1)
					money = money + 4 * 250000 + 4 * 250000;
				if (upd[4] == 2)
					money = money + 4 * 250000 + 4 * 750000;
				if (upd[4] == 3)
					money = money + 4 * 250000 + 4 * 1250000;
				if (upd[4] == 4)
					money = money + 4 * 250000 + 4 * 2500000;
				if (upd[4] == 5)
					money = money + 4 * 250000 + 4 * 7000000;
				h_n[4] = 0;
				score = score - 4000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;
		case 5:
			if (h_n[5] == 0 && money >= 5000000) {
				cout << "Вiтаємо! Ви купили готель." << endl;
				money = money - 5000000;
				rep_ev(10000, 0, 0, 0);
				h_n[5] = 1;
			}
			else if (h_n[5] == 0 && money<5000000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали готель, +";
				if (upd[5] == 0)
					cout << 10 * 250000;
				if (upd[5] == 1)
					cout << 10 * 250000 + 5 * 250000;
				if (upd[5] == 2)
					cout << 10 * 250000 + 5 * 750000;
				if (upd[5] == 3)
					cout << 10 * 250000 + 5 * 1250000;
				if (upd[5] == 4)
					cout << 10 * 250000 + 5 * 2500000;
				if (upd[5] == 5)
					cout << 10 * 250000 + 5 * 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[5] == 0)
					money = money + 10 * 250000;
				if (upd[5] == 1)
					money = money + 10 * 250000 + 5 * 250000;
				if (upd[5] == 2)
					money = money + 10 * 250000 + 5 * 750000;
				if (upd[5] == 3)
					money = money + 10 * 250000 + 5 * 1250000;
				if (upd[5] == 4)
					money = money + 10 * 250000 + 5 * 2500000;
				if (upd[5] == 5)
					money = money + 10 * 250000 + 5 * 7000000;
				h_n[5] = 0;
				score = score - 10000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;
		case 6:
			if (h_n[0] == 0 && money >= 1000000) {
				cout << "Вiтаємо! Ви купили казино." << endl;
				money = money - 10000000;
				rep_ev(2000, 0, 0, 0);
				h_n[0] = 1;
			}
			else if (h_n[0] == 0 && money<1000000)
				cout << "Недостатньо грошей!" << endl;
			else {
				cout << "Ви продали казино, +";
				if (upd[0] == 0)
					cout << 20 * 250000;
				if (upd[0] == 1)
					cout << 20 * 250000 + 10 * 250000;
				if (upd[0] == 2)
					cout << 20 * 250000 + 10 * 750000;
				if (upd[0] == 3)
					cout << 20 * 250000 + 10 * 1250000;
				if (upd[0] == 4)
					cout << 20 * 250000 + 10 * 2500000;
				if (upd[0] == 5)
					cout << 20 * 250000 + 10 * 7000000;
				cout << " грн" << endl;
				rep_ev(0, 0, 0, 0);
				if (upd[0] == 0)
					money = money + 20 * 250000;
				if (upd[0] == 1)
					money = money + 20 * 250000 + 10 * 250000;
				if (upd[0] == 2)
					money = money + 20 * 250000 + 10 * 750000;
				if (upd[0] == 3)
					money = money + 20 * 250000 + 10 * 1250000;
				if (upd[0] == 4)
					money = money + 20 * 250000 + 10 * 2500000;
				if (upd[0] == 5)
					money = money + 20 * 250000 + 10 * 7000000;
				h_n[0] = 0;
				score = score - 2000;
			}
			system("pause");
			system("CLS");
			goto m10;
			break;
		case 7:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m10;
			break;
		}

		goto game;
		break;
	case 11:
	m11:
		system("CLS");
		title("Фiнанси");
		cout << " 1. Купити $\n 2. Купити $ на всi гривнi \n 3. Купити гривнi \n 4. Купити гривнi на всi долари\n 5. Повернутися в меню\n\n Курс:" << curs;
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			cout << "Введiть кiлькiсть доларiв:" << endl;
			cin >> i;
			i = abs(i);
			if (money - i*curs >= 0) {
				money = money - i*curs;
				money2 = money2 + i;
				cout << "+" << i << "$" << endl;
			}
			else
				cout << "Нехватає грошей!" << endl;
			system("pause");
			system("CLS");
			goto m11;
			break;
		case 2:
			for (ii = 0; money - curs>0; ii++) {
				money = money - curs;
			}
			money2 = money2 + ii;
			cout << "+ " << ii << "$" << endl;
			system("pause");
			system("CLS");
			goto m11;
			break;
		case 3:
			cout << "Введiть кiлькiсть гривень:" << endl;
			cin >> i;
			i = abs(int(i / curs));
			if (money2 >= i) {
				money = money + i*curs;
				money2 = money2 - i;
				cout << "+" << i * 30 << "грн" << endl;
			}
			else
				cout << "Нехватає грошей!" << endl;
			system("pause");
			system("CLS");
			goto m11;
			break;
		case 4:
			money = money + money2*curs;
			money2 = 0;
			system("pause");
			system("CLS");
			goto m11;
			break;
		case 5:
			system("CLS");
			goto game;
			break;
		default:
			system("CLS");
			goto m11;
			break;
		}
	case 12:
	m12:
		system("CLS");
		title("Рейтинг");
		cout << " 1. Пiдкупити бабульок ( 200 грн)\n 2. Гуляти в клубах ( 1 000 грн)\n 3. Дати грошi бомжу ( 2 000 грн)\n 4. Появитися в зомбоящику ( 5 000 грн )\n 5. Пожертвувати ( 10 000 грн )\n 6. Замовити рекламу ( 50 000 грн )\n 7. Пожертвувати ( 100 000 грн )\n 8. Купити конкурентiв ( 500 000 грн )\n 9. Пожертвувати ( 1 000 000 грн )\n ";
		if (h_e[2] == 0)
			cout << "10. Вступити в благодiйну органiзацiю ( -";
		else
			cout << "10. Покинути благодiйну органiзацiю ( +";
		cout << "5 000 грн / день )\n 11. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {//p_rat(r1, r2, r3) r1--money   r2-+rat   r3-is h_e
		case 1:
			p_rat(100, 200, 0);
			goto m12;
			break;
		case 2:
			p_rat(510, 1000, 0);
			goto m12;
			break;
		case 3:
			p_rat(1040, 2000, 0);
			goto m12;
			break;
		case 4:
			p_rat(2640, 5000, 0);
			goto m12;
			break;
		case 5:
			p_rat(5520, 10000, 0);
			goto m12;
			break;
		case 6:
			p_rat(26000, 50000, 0);
			goto m12;
			break;
		case 7:
			p_rat(50000, 100000, 0);
			goto m12;
			break;
		case 8:
			p_rat(240000, 500000, 0);
			goto m12;
			break;
		case 9:
			p_rat(490000, 1000000, 0);
			goto m12;
			break;
		case 10:
			if (h_e[2] == 0)
				p_rat(0, 0, 1);
			else
				p_rat(0, 0, 2);
			goto m12;
			break;
		case 11:
			goto game;
			break;
		default:
			goto m12;
			break;
		}
		goto game;
		break;
	case 13:
	m13:
		system("CLS");
		title("Грабiж");
		cout << " 1. Пограбувати бомжа\n 2. Махлювати в наперсках\n 3. Красти паспорти в перехожих \n 4. Пограбувати перехожого\n 5. Пограбувати кридиторiв\n 6. Пограбувати магазин\n 7. Пограбувати бухгалтерiю\n 8. Пограбувати iнкасаторiв\n 9. Пограбувати олiгарха\n 10. Пограбувати банк\n 11. Пограбувати країну\n 12. Повернутися в меню";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_t[2] == 0 || score<200)
				cout << "Спершу купiть кеди i отримайте рейтинг бiльший за 200" << endl;
			else {
				iii = rand() % 5 + 5;
				ii = rand() % 20 + 5;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 2:
			if (h_t[2] == 0 || score<500 || h_s[3] == 0) {
				cout << "Спершу купiть кеди, отримайте рейтинг бiльший за 500 i закiнчiть школу" << endl;
			}
			else {
				iii = rand() % 20 + 7;
				ii = rand() % 200 + 5;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 3:
			if (h_t[2] == 0 || score <= 1000 || h_s[4] == 0)
				cout << "Спершу купiть кеди, отримайте рейтинг бiльший за 1 000 i закiнчiть ПТУ" << endl;
			else {
				iii = rand() % 50 + 10;
				ii = rand() % 500 + 20;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 4:
			if (h_t[3] == 0 || score<5000 || h_s[4] == 0)
				cout << "Спершу купiть ровер, отримайте рейтинг бiльший за 5 000 i закiнчiть ПТУ" << endl;
			else {
				iii = rand() % 50 + 15;
				ii = rand() % 500 + 20;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 5:
			if (h_t[4] == 0 || score<10000 || h_s[4] == 0)
				cout << "Спершу купiть жигуль, отримайте рейтинг бiльший за 10 000 i закiнчiть ПТУ" << endl;
			else {
				iii = rand() % 100 + 10;
				ii = rand() % 1000 + 50;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 6:
			if (h_t[5] == 0 || score<15000 || h_s[5] == 0)
				cout << "Спершу купiть BMW, отримайте рейтинг бiльший за 15 000 i закiнчiть державний ВУЗ" << endl;
			else {
				iii = rand() % 200;
				ii = rand() % 3500 + 50;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 7:
			if (h_t[5] == 0 || score<30000 || h_s[5] == 0)
				cout << "Спершу купiть BMW, отримайте рейтинг бiльший за 30 000 i закiнчiть державний ВУЗ" << endl;
			else {
				iii = rand() % 200;
				ii = rand() % 4000 + 50;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 8:
			if (h_t[6] == 0 || score<50000 || h_s[6] == 0)
				cout << "Спершу купiть Mercedes Benz, отримайте рейтинг бiльший за 50 000 i закiнчiть класний ВУЗ" << endl;
			else {
				iii = rand() % 500 + 50;
				ii = rand() % 10000 + 75;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 9:
			if (h_t[7] == 0 || score<50000 || h_s[7] == 0)
				cout << "Спершу купiть круту тачку, отримайте рейтинг бiльший за 75 000 i закiнчiть закордонний ВУЗ" << endl;
			else {
				iii = rand() % 600 + 150;
				ii = rand() % 20000 + 200;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 10:
			if (h_t[8] == 0 || score<50000 || h_s[7] == 0)
				cout << "Спершу купiть Ferrari, отримайте рейтинг бiльший за 150 000 i закiнчiть закордонний ВУЗ" << endl;
			else {
				iii = rand() % 800 + 200;
				ii = rand() % 50000 + 300;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 11:
			if (h_t[9] == 0 || score<50000 || h_s[8] == 0) {
				cout << "Спершу купiть приватний лiтак, отримайте рейтинг бiльший за 300 000 i закiнчiть Гарвард" << endl;
			}
			else {
				iii = rand() % 1800 + 1200;
				ii = rand() % 150000 + 15000;
				p_grab();
			}
			system("pause");
			goto m13;
			break;
		case 12:
			goto game;
			break;
		default:
			goto m13;
			break;
		}
		goto game;
		break;
	case 14:
	m14:
		system("CLS");
		title("Інше");
		if (h_e[0] == 0)
			cout << " 1. Купити амулет на 10 днiв (10000 грн)";
		else
			cout << " 1. Амулет дiє ще " << amulet_d << " днiв";
		if (h_e[1] == 0)
			cout << "\n 2. Найняти охоронця ( -5 000 грн / день )\n";
		else
			cout << "\n 2. Звiльнити охоронця ( +5 000 / день)\n";
		cout << " 3. Повернутися в меню\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_e[0] == 0) {
				if (money >= 10000) {
					h_e[0] = 1;
					amulet_d = 10;
					money = money - 10000;
					if (dif != 0)
						dif--;
					cout << "Ви купили амулет на 10 днiв. Протягом цього часу, ви будете бiльш визучим. Щоб отримати бiльший ефект, наймiть охоронця" << endl;
					system("pause");
				}
				else {
					cout << "Нема грошей!" << endl;
					system("pause");
				}
			}
			system("CLS");
			goto m14;
			break;
		case 2:
			if (h_e[1] == 0) {
				if (money >= 5000) {
					h_e[1] = 1;
					score = score + 1000;
					cout << "Ви найняли охоронця. Вiн вас захищає i робить бiльш визучим." << endl;
					system("pause");
					l_dif = dif;
				}
				else {
					cout << "Нема грошей!" << endl;
					system("pause");
				}
			}
			else {
				cout << "Ви звiльнили охоронця!" << endl;
				h_e[1] = 0;
				score = score - 1100;
				system("pause");
			}
			system("CLS");
			goto m14;
			break;
		case 3:
			goto game;
			break;
		default:
			goto m14;
			break;
		}

		goto game;
		break;
	case 15:
		system("CLS");
		first_menu();
		break;
	default:
		goto game;
		break;
	}
}
void start() {
	for (ii = 0; ii<11; ii++)
		cout << '\n';
	cout << endl;
	for (ii = 0; ii<24; ii++)
		cout << "  ";
	cout << "S-LIFE Simulator (by MAMBO)" << endl;
	Sleep(2000);
}
int winapi()
{
	SetConsoleTitle(TEXT("S-LIFE Simulator (by MAMBO)"));
	HANDLE out_handle = GetStdHandle(STD_OUTPUT_HANDLE);
	COORD crd = { 119, 30 };
	SMALL_RECT src = { 0, 0, crd.X - 1, crd.Y - 1 };
	SetConsoleWindowInfo(out_handle, true, &src);
	SetConsoleScreenBufferSize(out_handle, crd);
	return 0;
}
void main() {
	srand(time(0));
	is_beta = 0; //                        змiнити на 0 коли завершу розробку
	winapi();
	s_date[1] = 2017;
	s_date[2] = 03;
	s_date[3] = 01;
	s_dif = 1;
	system("CLS");
	setlocale(LC_ALL, "Ukrainian");
	if (is_beta == 0)
		start();
	first_menu();
}