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
		date[1] = s_date[1];//�i�
		date[2] = s_date[2];//�i����
		date[3] = s_date[3];//����
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
	title("����");
	if (ev_played == 1) {
		cout << " 1. ���������� ���" << endl;
		cout << " 2. ������ ���� ���" << endl;
		cout << " 3. �������� ���" << endl;
		cout << " 4. ��������" << endl;
		cout << " 5. ������������" << endl;
		cout << " 6. ��� ���" << endl;
		cout << " 7. ���i�" << endl;
	}
	else {
		cout << " 1. ������ ���� ���" << endl;
		cout << " 2. �������� ���" << endl;
		cout << " 3. ��������" << endl;
		cout << " 4. ������������" << endl;
		cout << " 5. ��� ���" << endl;
		cout << " 6. ���i�" << endl;
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
		title("����������");
		g_save_h();
		cout << "��� ���i��� ���������." << endl;
		decor('=');
		system("pause");
		goto m;
		break;
	case 3:
		title("���i���");
		cout << endl << "��������� � ���i� ��i �i��������� ��������� �����:" << endl << "   1. ���������� ������" << endl << "   2. ����i�� ����� ����i����� ������" << endl << "   3. ����i�� ����i�� ""Enter""." << endl;
		cout << endl << "���� �� �������� ����� ''����i�� ���� ����i�� ��� ����������'', ��� ���i��� ���i��������, ��� ����i��� ��������� ���� " << endl << "����i�� (��������� Enter), ��� ���������� �����, �������� ����� �i�, ��� ���� i��� (� ���������i �i� ������i�).\n\n���� ��� ����������� � ���i��i ��i� �������� �i����i�, ������������ �����i�, ��������� 100 �����, 100 ������� �� 100 \n������i\n";
		decor('=');
		system("pause");
		goto m;
		break;
	case 4:
		system("CLS");
a:		title("������������");
		cout << "1. �i���i��� ������ ��� �����i (�i� 0 �� 5 000)(�����:  " << s_money << ")." << endl;
		cout << "2. �i� ��� �����i (�i� 1980 �� 2020)(�����: " << s_date[1] << ")." << endl;
		cout << "3. �i���� ��� �����i (�i� 3 �� 9)(�����: " << s_date[2] << ")." << endl;
		cout << "4. ���� ��� �����i (�i� 1 �� 30)(�����: " << s_date[3] << ")." << endl;
		cout << "5. ������i��� (�i� 0 �� 3)(�����: " << s_dif << ")." << endl;
		cout << "6. ������ ���-���" << endl;
		cout << "7. ����������� � ����" << endl;
		decor('=');
		cin >> nom_menu2;
		system("CLS");
		switch (nom_menu2) {
		case 1:
			system("CLS");
		b:
			cout << "����i�� ���� ������ ��� �����i:" << endl;
			cin >> s_money;
			system("CLS");
			if (s_money < 0) {
				cout << "�i�i������ ���� - 0" << endl;
				goto b;
			}
			else if (s_money > 5000) {
				cout << "����������� ���� - 5 000" << endl;
				goto b;
			}
			else
				goto a;
			goto b;
			break;
		case 2:
			system("CLS");
		e:
			cout << "����i�� �i� ��� �����i:" << endl;
			cin >> s_date[1];
			system("CLS");
			if (s_date[1] < 1980) {
				cout << "�i�i������� �i� - 1980" << endl;
				goto e;
			}
			else if (s_date[1] > 2020) {
				cout << "������������ �i� - 2020" << endl;
				goto e;
			}
			else
				goto a;
			goto b;
			break;
		case 3:
			system("CLS");
		l:
			cout << "����i�� �i���� ��� �����i:" << endl;
			cin >> s_date[2];
			system("CLS");
			if (s_date[2] < 3) {
				cout << "�i�i������� �i���� - 3" << endl;
				goto l;
			}
			else if (s_date[2] > 9) {
				cout << "������������ �i���� - 9" << endl;
				goto l;
			}
			else
				goto a;
			goto b;
			break;
		case 4:
			system("CLS");
		c:
			cout << "����i�� ���� ��� �����i:" << endl;
			cin >> s_date[3];
			system("CLS");
			if (s_date[3] < 1) {
				cout << "�i�i������� ���� - 1" << endl;
				goto c;
			}
			else if (s_date[3] > 30) {
				cout << "������������ ���� - 30" << endl;
				goto c;
			}
			else
				goto a;
			goto b;
			break;
		case 5:
			system("CLS");
		g:
			cout << "�����i�� ������i��� ���: \n0. �����.\n1. ���������.\n2. �����.\n3. ���������. " << endl;
			cin >> s_dif;
			system("CLS");
			if (s_dif < 0) {
				cout << "�i�i������ ������i��� - 0" << endl;
				goto g;
			}
			else if (s_dif > 3) {
				cout << "����������� ������i��� - 3" << endl;
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
				cout << "��� 3410 ���i��� �����������" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			if (cheat_k == cheats[2]) {
				s_money = 999999999999999;
				s_score = 5000000000;
				cout << "��� 9990 ���i��� �����������" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			if (cheat_k == cheats[3]) {
				is_1000 = 0;
				cout << "��� 1000 ���i��� �����������" << endl;
				system("pause");
				system("CLS");
				goto a;
			}
			else
				cout << "��� �� ��������" << endl;
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
		title("��� ���");
		cout << "��� ""S-LIFE Simulator"", �������� MAMBO 2017 ����. ���� ��� �� ���� ������i��� ������ �������� �� ������� ���� �� ������ �� ��������" << endl << endl << "����i� ���: 1.0" << endl << endl << "�������� �� ���� ��������� ���: Visual Studio 2012, Visual Studio 2015; C++" << endl << endl << "��� ���� ����������:";
		SetColor(0, 7);
		cout << "www.mambo.zzz.com.ua; www.shop.mambo.zzz.com.ua";
		SetColor(7, 0);
		cout << endl << endl << "�������������� ����!" << endl << endl;
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
	cout << "�������: " << money;
	SetColor(7, 0);
	if (money2<0)
		SetColor(12, 0);
	if (money2 == 999999999)
		SetColor(11, 0);
	cout << "\t �����i�: ";
	SetColor(7, 0);
	cout << money2 << "\t ����: " << curs << "\t  �i�� �� �������: " << botle << endl;
	if (heard<20)
		SetColor(12, 0);
	if (heard == 100)
		SetColor(10, 0);
	cout << "������'�: " << heard;
	SetColor(7, 0);
	if (food<20)
		SetColor(12, 0);
	if (food == 100)
		SetColor(10, 0);
	cout << "\t ���i���: " << food;
	SetColor(7, 0);
	if (nast<20)
		SetColor(12, 0);
	if (nast == 100)
		SetColor(10, 0);
	cout << "\t �����i�: " << nast;
	SetColor(7, 0);
	cout << endl << "����: ";
	if (date[3] < 10)
		cout << 0;
	cout << date[3] << " : ";
	if (date[2] < 10)
		cout << 0;
	cout << date[2] << " : " << date[1] << "\t �������: " << score << endl;
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
		cout << endl << "���� ��� ������������, �� �� ������� �� ���i���� ��i�!" << endl;
		SetColor(7, 0);
	}
	if (die>5 && dif == 0 || die>4 && dif == 1 || die>3 && dif == 2 || die>2 && dif == 3) {
		ev_played = 0;
		SetColor(12, 0);
		system("CLS");
		cout << endl << "�� �������!" << endl;
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
		cout << endl << "�����i�� ����i, ��� �� ������� �� ���i���� ��i�!" << endl;
		SetColor(7, 0);
	}
	if (score<0) {
		SetColor(12, 0);
		cout << endl << "������i�� ��i� �������, ��� ��� ����������!" << endl;
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
void p_b_zarp(int p4, int p5) {//����. ���
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
void p_ht_78_re(bool i1, string i2, int i3) {//0=h_t[7] 1=h_t[8] ; �����/Ferrari ; 1=h_t[7] 2=h_t[8];
	if (h_t[7] == 1 && i3==1 || h_t[8] == 1 && i3==2) {
		iii = rand() % 100;
		if (rand_ev() == 1) {
			if (iii == 40) {
				cout << "�i�� ���� " << i2 << " ����������������. + ";
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
				cout << "�� �i������ ���������. + " << i3 * 200 << " RP + " << i3 * 200 << " ���" << endl;
				score = score + i3 * 200;
				money = money + i3 * 200;
			}
			if (iii == 27) {
				cout << "�� �i������ ����i�����. + " << i3 * 500 << " RP + " << i3 * 100 << " ���" << endl;
				score = score + i3 * 500;
				money = money + i3 * 100;
			}
			if (iii == 26) {
				cout << "�� �i������ ��������. - " << i3 * 100 << " RP + " << i3 * 1000 << " ���" << endl;
				score = score + i3 * 100;
				money = money + i3 + 1000;
			}
			if (iii == 25) {
				cout << "�������� �������� ���, �� �������i� �i�� ���� " << i2 << ". + " << i3 * 300 << " RP + " << i3 * 1500 << " ���" << endl;
				score = score + i3 * 300;
				money = money + i3 * 1500;
			}
		}
		else {
			if (iii == 29) {
				cout << "�� ��������� ������ � ���� " << i2 << ". - " << i3 * 300 << " RP - " << i3 * 500 << " ���" << endl;
				score = score - i3 * 300;
				money - money - i3 * 500;
			}
			if (iii == 28) {
				cout << "��� ��������� ������. - " << i3 * 500 << " RP - " << i3 * 500 << " ���" << endl;
				score = score - i3 * 500;
				money - money - i3 * 500;
			}
			if (iii == 27) {
				cout << "��� ������� ����. - " << i3 * 300 << " RP - " << i3 * 1000 << " ���" << endl;
				score = score - i3 * 300;
				money = money - i3 * 1000;
			}
			if (iii == 26) {
				ii = i3 * 10 * (rand() % 250 + 50);
				cout << "�� �������� ������� ���������� ����. - " << i3 * 100 << " RP -" << ii << " ���" << endl;
				score = score - i3 * 100;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "�� ������ �� ������� ��i���. - " << i3 * 500 << " RP - " << i3 * 750 << " ���" << endl;
				score = score - i3 * 500;
				money = money - i3 * 750;
			}
			if (iii >= 19 && iii <= 24) {
				cout << "- " << i3 * 400 << " �� �������������� ���� " << i2 << ". " << endl;
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
	p_b_zarp(1, 1);//����. ���
	p_b_zarp(2, 2);
	p_b_zarp(2, 3);
	p_b_zarp(2, 4);
	p_b_zarp(2, 5);
	p_b_zarp(2, 0);
	if (h_h[2] == 1 && h_date[2] == date[3]) {
		money = money - 10000;
		score = score + 50;
		cout << "-10 000 ��� - �� �i����� � ����������" << endl;
	}
	if (h_h[3] == 1 && date[3] == date[3]) {
		money = money - 20000;
		score = score + 100;
		cout << "-20 000 ��� - �� ������ ������" << endl;
	}
	if (h_h[4] == 1 && h_date[4] == date[3]) {
		money = money - 30000;
		score = score + 150;
		cout << "-30 000 ��� - �� ������ ��������" << endl;
	}
	if (h_h[5] == 1 && h_date[5] == date[3]) {
		money = money - 50000;
		score = score + 250;
		cout << "-50 000 ��� - �� ������ �������" << endl;
	}
	if (h_b[1] == 1) {
		if (h_h[6] == 1 && score>200 && h_d2[1] == date[3]) {
			money = money + 30000;
			score = score + 100;
			cout << "+ 30 000 ��� �� ������ ��������" << endl;
		}
		if (score<200) {
			h_b[1] = 0;
			score = score - 50;
			h_d2[1] = 0;
			cout << "����� ������� �������, ��� ������� ��������. �i� ��� ��i� ��i���! - 50 RP" << endl;
		}
		if (h_h[6] == 0) {
			h_b[1] = 0;
			h_d2[1] = 0;
			score = score - 50;
			cout << "��� ���������� ��������, ����i��� ���� ��������. �i� ��� ��i� ��i���! - 50 RP" << endl;
		}
	}
	if (h_b[2] == 1) {
		if (h_h[7] == 1 && score>500 && h_d2[2] == date[3]) {
			money = money + 50000;
			score = score + 150;
			cout << "+ 50 000 ��� �� ������ i������" << endl;
		}
		if (score<500) {
			h_b[2] = 0;
			score = score - 100;
			h_d2[2] = 0;
			cout << "����� ������� �������, ��� ������� i������. �i� ��� ��i� ��i���! - 100 RP" << endl;
		}
		if (h_h[7] == 0) {
			h_b[2] = 0;
			h_d2[2] = 0;
			score = score - 100;
			cout << "��� ���������� ��������, ����i��� ���� i������. �i� ��� ��i� ��i���! - 100 RP" << endl;
		}
	}
	if (h_b[3] == 1) {
		if (h_h[8] == 1 && score>1000 && h_d2[3] == date[3]) {
			money2 = money2 + 2000;
			score = score + 200;
			cout << "+ 2 000 $ �� ������ ��������" << endl;
		}
		if (score<1000) {
			h_b[3] = 0;
			score = score - 200;
			h_d2[3] = 0;
			cout << "����� ������� �������, ��� ������� ��������. �i� ��� ��i� ��i���! - 200 RP" << endl;
		}
		if (h_h[8] == 0) {
			h_b[3] = 0;
			h_d2[3] = 0;
			score = score - 200;
			cout << "��� ���������� ��������, ����i��� ���� ��������. �i� ��� ��i� ��i���! - 200 RP" << endl;
		}
	}
	if (h_b[4] == 1) {
		if (h_h[10] == 1 && score>5000 && h_d2[4] == h_date[4]) {
			money2 = money2 + 30000;
			score = score + 300;
			cout << "+ 30 000 $ �� ������ ������" << endl;
		}
		if (score<5000) {
			h_b[4] = 0;
			score = score - 300;
			h_d2[4] = 0;
			cout << "����� ������� �������, ��� ������� ����i�. �i� ��� ��i� ��i���! - 300 RP" << endl;
		}
		if (h_h[10] == 0) {
			h_b[4] = 0;
			h_d2[4] = 0;
			score = score - 300;
			cout << "��� ���������� ��������, ����i��� ���� ����i�. �i� ��� ��i� ��i���! - 300 RP" << endl;
		}
	}
	if (h_b[5] == 1) {
		if (h_h[11] == 1 && score>20000 && h_d2[5] == h_date[5]) {
			money2 = money2 + 100000;
			score = score + 500;
			cout << "+ 100 000 $ �� ������ ����� �����i�" << endl;
		}
		if (score<20000) {
			h_b[5] = 0;
			score = score - 500;
			h_d2[5] = 0;
			cout << "����� ������� �������, ��� ������� ����� ������i�. �i� ��� ��i� ��i���! - 500 RP" << endl;
		}
		if (h_h[11] == 0) {
			h_b[5] = 0;
			h_d2[5] = 0;
			score = score - 500;
			cout << "��� ���������� ��������, ����i��� ���� ����� ������i�. �i� ��� ��i� ��i���! - 500 RP" << endl;
		}
	}
	if (h_b[6] == 1) {
		if (h_h[12] == 1 && score>50000 && h_d2[6] == h_date[6]) {
			money2 = money2 + 240000;
			score = score + 1000;
			cout << "+ 240 000 $ �� ������ �����i�" << endl;
		}
		if (score<50000) {
			h_b[6] = 0;
			score = score - 1000;
			h_d2[6] = 0;
			cout << "����� ������� �������, ��� ������� �����i��. �i� ��� ��i� ��i���! - 1000 RP" << endl;
		}
		if (h_h[12] == 0) {
			h_b[6] = 0;
			h_d2[6] = 0;
			score = score - 1000;
			cout << "��� ���������� ��������, ����i��� ���� �����i��. �i� ��� ��i� ��i���! - 1000 RP" << endl;
		}
	}
	if (h_b[7] == 1) {
		if (h_h[13] == 1 && score>100000 && h_d2[7] == h_date[7]) {
			money2 = money2 + 10000000;
			score = score + 5000;
			cout << "+ 10 000 000 $ �� ������ �����������" << endl;
		}
		if (score<100000) {
			h_b[7] = 0;
			score = score - 5000;
			h_d2[7] = 0;
			cout << "����� ������� �������, ��� ������� ����������. �i� ��� ��i� ��i���! - 5000 RP" << endl;
		}
		if (h_h[13] == 0) {
			h_b[7] = 0;
			h_d2[7] = 0;
			score = score - 5000;
			cout << "��� ���������� ��������, ����i��� ���� ����������. �i� ��� ��i� ��i���! - 5000 RP" << endl;
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
			cout << "�� ������i��i�. ������� ��������� ��� ����i:\n +" << i << " ���" << endl;
			money = money + i;
		}
	}
	if (h_e[0] == 1) {
		amulet_d--;
		if (amulet_d == 3 || amulet_d == 2) {
			cout << "������ �i� �� " << amulet_d << " ���" << endl;
		}
		if (amulet_d == 1) {
			cout << "������ �i� �� " << amulet_d << " ����" << endl;
		}
		if (amulet_d <= 0) {
			h_e[0] = 0;
			cout << "������ �i���� �� �i�" << endl;
			dif++;
		}
	}
	if (food<25) {
		iii = rand() % 35;
		if (iii == 29) {
			cout << "�� ������ �������, ";
			food = food + 10;
			if (rand_ev() == 0) {
				cout << "��� ��� �������. - 50 ��� - 50 RP";
				money = money - 50;
				score = score - 50;
			}
			cout << " + 10 �� ��i" << endl;
		}
		if (iii == 28) {
			cout << "�� ������ �����, ";
			food = food + 20;
			if (rand_ev() == 0) {
				cout << "��� ��� �������. - 100 ��� - 100 RP";
				money = money - 50;
				score = score - 50;
			}
			cout << " + 20 �� ��i" << endl;
		}
		if (iii == 27) {
			cout << "�� ������ ��i�, ";
			food = food + 10;
			if (rand_ev() == 0) {
				cout << "��� ��� �������. - 30 ��� - 30 RP";
				money = money - 30;
				score = score - 30;
			}
			cout << " + 10 �� ��i" << endl;
		}
		if (iii == 26) {
			cout << "�� ������ �i��, ";
			food = food + 30;
			if (rand_ev() == 0) {
				cout << "��� ��� �������. - 200 ��� - 200 RP";
				money = money - 200;
				score = score - 200;
			}
			cout << " + 30 �� ��i" << endl;
		}
	}
	if (nast<25) {
		iii = rand() % 40;
		if (iii == 29) {
			cout << "�� �������� ��� ���i���������, ";
			if (rand_ev() == 1) {
				cout << "��� ��� �������. - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 28) {
			cout << "�� ����������� ���������, ";
			if (rand_ev() == 1) {
				cout << "��� ��� �������. - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP + 200 ���" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		if (iii == 27) {
			cout << "�� ������ ����� � �������i, ";
			if (rand_ev() == 1) {
				cout << "��� ��� �������. - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP + 200 ���" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		if (iii == 26) {
			cout << "�� ��������� ���� � ����������� �������i, ";
			if (rand_ev() == 1) {
				cout << "��� ��� ��������. - 50 ��� - 50 RP" << endl;
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
			cout << "��� �������� �� ���������, ";
			if (rand_ev() == 1) {
				cout << "i ��� ��������. - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 28) {
			cout << "�� �������� ����� ���������, ";
			if (rand_ev() == 1) {
				cout << "��� ��� �������. - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			else {
				cout << "+ 200 RP" << endl;
				score = score + 200;
			}
		}
		if (iii == 27) {
			cout << "�i� ��� ������ ��������, ���� ��� �������� - 100 RP" << endl;
			score = score - 100;
		}
		if (iii == 26) {
			cout << "�� ��������� ���� � ����������� �������i, ";
			if (rand_ev() == 1) {
				cout << "��� ��� ��������. - 50 ��� - 50 RP" << endl;
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
		cout << endl << "�i���� � ����� �����!" << endl;
		if (is_main_b == 1)
			cout << "����� �������� ��� 500 ���!" << endl;
		if (is_inv == 1)
			cout << "�i���� ������� ��� 500 ���!" << endl;
		if (is_unemp == 1)
			cout << "������� �������� ��� 500 ���!" << endl;
	}
	if (h_t[2] == 1) {
		if (rand_ev() == 1) {
			iii = rand() % 60;
			if (iii == 29) {
				ii = (rand() % 30);
				cout << "�� ������� ��������������, ���� ����� " << ii * 100 << " ���! + " << ii * 10 << " ��� + 200 RP" << endl;
				score = score + 200;
				money = money + ii * 10;
			}
			if (iii == 28) {
				ii = (rand() % 30);
				cout << "�� �������� ������ � ���i��,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i ������� " << i << " �i���, + ";
					if (i == 3) {
						money = money + 100;
						score = score + 100;
						cout << "100 ��� + 100 RP" << endl;
					}
					if (i == 2) {
						money = money + 250;
						score = score + 250;
						cout << "250 ��� + 250 RP" << endl;
					}
					if (i == 1) {
						money = money + 500;
						score = score + 500;
						cout << "500 ��� + 500 RP" << endl;
					}
				}
			}
			if (iii == 27) {
				cout << "�� ������ ������! + 500 ���!  + 500 RP" << endl;
				score = score + 500;
				money = money + 500;
			}
		}
		else {
			iii = rand() % 50;
			if (iii == 29) {
				cout << "��� ���i������� � ����i��i. - 100 RP" << endl;
				score = score - 100;
			}
			if (iii == 28) {
				cout << "�� ������ �������, ��� ��� �������. - 200 ��� - 200 RP" << endl;
				money = money - 200;
				score = score - 200;
			}
			if (iii == 27) {
				ii = (rand() % 30);
				cout << "�� �������� ������ � ���i��, ��� �� ������� �i���. - 100 RP" << endl;
				score = score - 100;
			}
		}
	}
	if (h_t[3]) {
		if (rand_ev() == 1) {
			ii = (rand() % 100);
			if (ii == 29) {
				iii = (rand() % 30);
				cout << "�� ������� ��������������, ���� ����� " << ii * 100 << " ���! + " << ii * 10 << " ��� + 200 RP" << endl;
				score = score + 200;
				money = money + ii * 10;
			}
			if (ii == 28) {
				iii = (rand() % 30);
				cout << "�� �������� ������ � ������ �� �����������,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i ������� " << i << " �i���, + ";
					if (i == 3) {
						money = money + 200;
						score = score + 200;
						cout << "200 ��� + 200 RP" << endl;
					}
					else if (i == 2) {
						money = money + 350;
						score = score + 350;
						cout << "350 ��� + 350 RP" << endl;
					}
					else {
						money = money + 600;
						score = score + 600;
						cout << "600 ��� + 600 RP" << endl;
					}
				}
			}
			if (ii == 27) {
				cout << "�� ���������� �������i� ��� �������, + 100 ��� + 100 RP" << endl;
				money = money + 100;
				score = score + 100;
			}
			if (ii == 26) {
				cout << "�� �i������ ������, + 50 ��� + 150 RP" << endl;
				money = money + 50;
				score = score + 150;
			}
			if (ii == 25) {
				cout << "�� �i������ ���������, + 100 ��� + 100 RP" << endl;
				money = money + 50;
				score = score + 150;
			}
			if (ii == 24) {
				cout << "�� �i������ i����i��, + 50 ��� + 100 RP" << endl;
				money = money + 50;
				score = score + 100;
			}
			if (ii == 23) {
				cout << "�� �i������ ��������, + 300 RP" << endl;
				score = score + 300;
			}
		}
		else {
			ii = (rand() % 100);
			if (ii == 29) {
				cout << "�� ����� ���������, - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 28) {
				cout << "�� �������� ���� ���������, - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 27) {
				cout << "�� �������� ������� ���������� ���� ��� ������������i�, - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (ii == 26) {
				cout << "�� ��������� ���������� ����� ������ �����������, - 100 ��� - 100 RP" << endl;
				money = money - 100;
				score = score - 100;
			}
			if (iii == 27) {
				ii = (rand() % 30);
				cout << "�� �������� ������ � ������ �� �����������, ��� �� ������� �i���. - 100 RP" << endl;
				score = score - 100;
			}
		}
	}
	if (h_t[4]) {
		if (rand_ev() == 1) {
			ii = (rand() % 100);
			if (ii == 29) {
				cout << "�� �������� ������ � �������i����� ������,";
				if (rand_ev() == 1) {
					i = rand() % 3 + 1;
					cout << " i ������� " << i << " �i���, + ";
					if (i == 3) {
						money = money + 250;
						score = score + 250;
						cout << "250 ��� + 250 RP" << endl;
					}
					else if (i == 2) {
						money = money + 500;
						score = score + 500;
						cout << "500 ��� + 500 RP" << endl;
					}
					else {
						money = money + 800;
						score = score + 800;
						cout << "800 ��� + 800 RP" << endl;
					}
				}
			}
			if (ii == 28 && is_main_b == 1) {
				cout << "�� ������ ����! + " << int(0.1*score) << "RP + " << int(0.05*money) << " ���" << endl;
				score = score + int(0.1*score);
				money = money + int(0.05*money);
			}
			if (ii == 27 && is_main_b == 0) {
				cout << "�� ������! + " << int(0.05*score) << "RP + " << int(0.025*money) << " ���" << endl;
				score = score + int(0.05*score);
				money = money + int(0.025*money);
			}
		}
		else {
			ii = (rand() % 30);
			if (ii == 29) {
				cout << "�� �������� ������ � �������i����� ������ , ��� �� ������� �i��� - 200 RP" << endl;
				score = score - 200;
			}
			if (ii == 28 || ii == 27 || ii == 26) {
				iii = rand() % 9 + 1;
			rand_ev_with_h_t4:
				cout << "����� ������ ��������\n 1. ������� ������ (+5 000 ��� )\n 2. ������� ������ � ������ (-" << iii * 1000 << " ��� )" << endl;
				cin >> i;
				system("CLS");
				switch (i) {
				case 1:
					money = money + 5000;
					h_t[4] = 0;
					cout << "�� ������� ������!" << endl;
					system("pause");
					system("CLS");
					break;
				case 2:
					if (money - (iii * 1000) >= 0) {
						money = money - (iii * 1000);
					}
					else {
						cout << "����������� ������!" << endl;
						system("CLS");
						goto rand_ev_with_h_t4;
					}
					system("pause");
					system("CLS");
					break;
				}
			}
			if (ii == 25) {
				cout << "� ������ ������ ��i�����! - 200 RP" << endl;
				score = score - 200;
			}
			if (ii == 24) {
				cout << "���� ������ ��������� ���i���. - 50 ���" << endl;
				money = money - 50;
			}
		}
	}
	if (h_t[5] == 1) {
		iii = rand() % 60;
		if (rand_ev() == 1) {
			if (iii == 29) {
				cout << "�i�� ���� ������ ����������������. + 50 RP" << endl;
				score = score + 50;
			}
			if (iii == 28) {
				cout << "�� �i������ ���������. + 50 RP + 50 ���" << endl;
				score = score + 50;
				money = money + 50;
			}
			if (iii == 27) {
				cout << "�� �i������ ����i�����. + 100 RP + 2 ���" << endl;
				score = score + 100;
				money = money + 2;
			}
			if (iii == 26) {
				cout << "�� �i������ ��������. - 50 RP + 200 ���" << endl;
				score = score - 50;
				money = money + 200;
			}
			if (iii == 25) {
				cout << "�������� �������� ���, �� �������i� �i�� ���� ������. + 50 RP + 150 ���" << endl;
				score = score + 50;
				money = money + 150;
			}
		}
		else {
			if (iii == 29) {
				cout << "�� ��������� ������ � ���� �����i. - 25 RP - 150 ���" << endl;
				score = score - 25;
				money - money - 150;
			}
			if (iii == 28) {
				cout << "��� ��������� ������. - 50 RP - 150 ���" << endl;
				score = score - 50;
				money - money - 150;
			}
			if (iii == 27 && score <= 200) {
				cout << "��� ������� ����. ������i�� ��i� �������! - ";
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
				cout << " RP - 200 ���" << endl;
				money = money - 200;
			}
			if (iii == 26) {
				ii = 10 * (rand() % 25 + 5);
				cout << "�� �������� ������� ���������� ����. - 75 RP -" << ii << " ���" << endl;
				score = score - 75;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "�� ������ �� ������� ��i���. - 50 RP - 75 ���" << endl;
				score = score - 50;
				money = money - 75;
			}
		}
	}
	if (h_t[6] == 1) {
		iii = rand() % 60;
		if (rand_ev() == 1) {
			if (iii == 29 || iii == 30) {
				cout << "�i�� ���� ������ ����������������. + 100 RP" << endl;
				score = score + 100;
			}
			if (iii == 28) {
				cout << "�� �i������ ���������. + 50 RP + 100 ���" << endl;
				score = score + 50;
				money = money + 100;
			}
			if (iii == 27) {
				cout << "�� �i������ ����i�����. + 200 RP + 5 ���" << endl;
				score = score + 200;
				money = money + 5;
			}
			if (iii == 26) {
				cout << "�� �i������ ��������. - 30 RP + 400 ���" << endl;
				score = score - 30;
				money = money + 400;
			}
			if (iii == 25) {
				cout << "�������� �������� ���, �� �������i� �i�� ������ Mercedes Benz. + 200 RP + 200 ���" << endl;
				score = score + 200;
				money = money + 200;
			}
		}
		else {
			if (iii == 29) {
				cout << "�� ��������� ������ � ���� �����i. - 50 RP - 250 ���" << endl;
				score = score - 50;
				money - money - 250;
			}
			if (iii == 28) {
				cout << "��� ��������� ������. - 30 RP - 250 ���" << endl;
				score = score - 30;
				money - money - 250;
			}
			if (iii == 27) {
				cout << "��� ������� ����. - 50 RP - 250 ���" << endl;
				score = score - 50;
				money = money - 250;
			}
			if (iii == 26) {
				ii = 10 * (rand() % 25 + 5);
				cout << "�� �������� ������� ���������� ����. - 75 RP -" << ii << " ���" << endl;
				score = score - 75;
				money = money - ii;
			}
			if (iii == 25) {
				cout << "�� ������ �� ������� ��i���. - 50 RP - 75 ���" << endl;
				score = score - 50;
				money = money - 75;
			}
		}
	}
	p_ht_78_re(0, "�����", 1);//0=h_t[7] 1=h_t[8] ; �����/Ferrari ; 1=h_t[7] 2=h_t[8];
	p_ht_78_re(1, "Ferrari", 2);
	if (h_t[9] == 1) {
		iii = rand() % 50;
		if (rand_ev() == 1) {
			if (iii == 29) {
				cout << "�� ����� � ������ �i���. + 200 RP + 10 000 ���" << endl;
				score = score + 200;
				money = money + 10000;
			}
			if (iii == 28) {
				cout << "�i�� ������ �i���� ����������������. + 500 RP + 50 ���" << endl;
				score = score + 500;
				money = money + 50;
			}
			if (iii == 27) {
				cout << "�������� �������� ��� �� �������i�. + 200 RP + 5 000 ���" << endl;
				score = score + 200;
				money = money + 5000;
			}
			if (iii == 26) {
				cout << "������ � ������ ��i���� ���� ����i���. + 5 000 RP + 5 000 ���" << endl;
				score = score + 5000;
				money = money + 5000;
			}
			if (iii == 25 && is_main_b == 1) {
				cout << "����i ������ ��i���� ���� ����i���. + 10 000 RP + 10 000 ���" << endl;
				score = score + 10000;
				money = money + 10000;
			}
		}
		else {
			if (iii == 29) {
				cout << "- 10 000 ��� �� �������������� �i����" << endl;
				money = money - 10000;
			}
			if (iii == 28) {
				cout << "������ �� ����������� ���� ����i���! - 1 000 RP - 1 000 ���" << endl;
				score = score - 1000;
				money = money - 1000;
			}
			if (iii == 27) {
				cout << "������ �� ����������� ���� ����i���! - 5 000 RP - 5 000 ���" << endl;
				score = score - 5000;
				money = money - 5000;
			}
			if (iii == 26) {
				cout << "������ �� ����������� ���� ����i���! - 10 000 RP - 10 000 ���" << endl;
				score = score - 10000;
				money = money - 10000;
			}
			if (iii == 25) {
				i = 1000 * (rand() % 20 + 1);
				cout << "�i��� ��������� - 5 000 RP - " << i << " ���" << endl;
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
				cout << "��� ��������� �i� ����i�:\n +" << i << " �������\n + 50 RP" << endl;
				score = score + 50;
			}
		}
		else {
			iii = rand() % 30;
			if (iii == 27) {
				cout << "�������i ����� �� �������� ��� �������. - 50 RP" << endl;
				score = score - 50;
			}
			else {
				cout << "������ �� ����������� ���� ����i���. �� �i���� �� �������� ����. - 150 RP" << endl;
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
				cout << "�������i ��� ���� ����� �������\n +" << i << " �� ������i\n -" << ii << " ������'�" << endl;
				food = food + i;
				heard = heard - ii;
			}
		}
		else {
			iii = rand() % 30;
			if (iii <= 27) {
				cout << "�������i ��� �� ���� �����" << endl;
				score = score - 40;
			}
			else {
				cout << "�� ������� ����i������ ������i������\n -200 ���" << endl;
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
				cout << "�������i � �i����i ��� ���� �����\n +" << i << " �� ������i\n +" << ii << " �� �������" << endl;
				food = food + i;
				nast = nast + ii;

			}
		}
		else {
			iii = rand() % 30;
			if (iii == 28) {
				cout << "�������i � �i����i ���i����" << endl;
				nast = nast - 5;
				food = food - 5;
			}
			else if (iii == 29) {
				cout << "�� ������� ����i������ i����i��\n -200 ���" << endl;
				money = money - 200;
				nast = nast - 5;
				is_inv = 0;
			}
			else {
				cout << "�i���� ���i���, �� �� �� i����i�\n -200 RP\n -200 ���" << endl;
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
		cout << endl << "���� ������!" << endl;
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
		cout << "+ " << iii << " RP + " << ii << " ���" << endl;
		money = money + ii;
		rep_ev(iii, 2, 2, 2);
	}
	else {
		cout << "��� �������. - " << iii * 10 << " RP - " << ii * 3 << " ���" << endl;
		score = score - iii * 10;
		money = money - ii * 3;
		rep_ev(iii, 3, 3, 3);
	}
	dif--;
}
void p_rat(int r1, int r2, int r3) {
	if (r3 == 2 && h_e[2] == 1) {
		h_e[2] = 0;
		cout << "�� �������� ������i��� �����i���i�" << endl;
		system("pause");
	}
	money = money - r2;
	rep_ev(r1, 2, 2, 2);
	if (r3 == 1 && h_e[2] == 0) {
		h_e[2] = 1;
		cout << "�i�����! �� �������� � ������i��� �����i���i�" << endl;
		system("pause");
	}
	if (r3 == 2 && h_e[2] == 1) {
		h_e[2] = 0;
		cout << "�� �������� ������i��� �����i���i�" << endl;
		system("pause");
	}
	system("CLS");
}
void p_bis(string i1, string i2, string i3, int i4, int i5) {//��������, ����������, ��������i, ����i�i��� �������, ����� ����� �i�����
m3_8:
	system("CLS");
	if (h_n[i5] == 0)
		cout << "������ ���i�� " << i1 << '!' << endl;
	else {
		system("CLS");
		title("��������� �i������");
		if (h_v_d[i5] == 0) {
			cout << " 1. ��������� � " << i3 << "( + ";
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
			cout << " ��� )\n 2. ";
		}
		else
			cout << " 1. ��� ��������� � " << i3 << ", ��i���i�� ���i�����\n 2. ";
		if (upd[i5] != 5) {
			cout << "������� " << i1 << " ( ";
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
			cout << " ��� )\n 3. ";
		}
		else
			cout << " �i���� �������� �� ������������� ������\n 3. ";
		if (h_v_d[i5] == 0)
			cout << "������� ���i����� ( -";
		else
			cout << "��i������ ���i����� ( +";
		cout << i4 * 10000 << " ��� / ����)\n 4. ����������� � ����";
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
				cout << "�� ������� " << i1 << "! ����� �� ������ ��������� �� " << i4 * 2000 << " ��� � ����." << endl;
			}
			else if (money>i4 * 750000 && upd[i5] == 1) {
				money = money - i4 * 750000;
				score = score + 1000;
				upd[i5]++;
				cout << "�� ������� " << i1 << "! ����� �� ������ ��������� �� " << i4 * 5000 << " ��� � ����." << endl;
			}
			else if (money>i4 * 1250000 && upd[i5] == 2) {
				money = money - i4 * 1250000;
				score = score + 2000;
				upd[i5]++;
				cout << "�� ������� " << i1 << "! ����� �� ������ ��������� �� " << i4 * 10000 << " ��� � ����." << endl;
			}
			else if (money>i4 * 2500000 && upd[i5] == 3) {
				money = money - i4 * 2500000;
				score = score + 5000;
				upd[i5]++;
				cout << "�� ������� " << i1 << "! ����� �� ������ ��������� �� " << i4 * 20000 << " ��� � ����." << endl;
			}
			else if (money>i4 * 7000000 && upd[i5] == 4) {
				money = money - i4 * 7000000;
				score = score + 10000;
				upd[i5]++;
				cout << "�� ������� " << i1 << "! ����� �� ������ ��������� �� " << i4 * 50000 << " ��� � ����." << endl;
			}
			else
				cout << "���� ������!" << endl;
			system("pause");
			system("CLS");
			goto m3_8;
			break;
		case 3:
			if (money >= i4 * 10000 && h_v_d[i5] == 0) {
				h_v_d[i5] = 1;
				cout << "�� ������� ���i�����. �i� ���� " << i4 * 10000 << " ��� � ����, ��� ������ � " << i3 << " ���i��� ���." << endl;
				system("pause");
				goto m3_8;
			}
			if (money<i4 * 10000 && h_v_d[i5] == 0) {
				cout << "����������� ������!" << endl;
				system("pause");
				goto m3_8;
			}
			if (h_v_d[i5] == 1) {
				h_v_d[i5] = 0;
				cout << "�� ��i������ ���i�����. + " << i4 * 10000 << " / ����." << endl;
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
	title("������ ����");
	cout << " 1. ���������" << endl;//
	cout << " 2. ������" << endl;//
	cout << " 3. �i����" << endl;
	cout << " 4. ���" << endl;//
	cout << " 5. �������" << endl;//
	cout << " 6. ������'�" << endl;//
	cout << " 7. ��������" << endl;//
	cout << " 8. ���������" << endl;//
	cout << " 9. �����" << endl;//
	cout << " 10. �������i���" << endl;//
	cout << " 11. �i�����" << endl;//
	cout << " 12. �������" << endl;//
	cout << " 13. ����i�" << endl;
	cout << " 14. ����" << endl;//
	cout << " 15. ����������� � ������� ����" << endl;//
	infbar();
	cin >> nom_menu;
	switch (nom_menu) {
	case 1:
	m1:
		system("CLS");
		title("���������");
		cout << " 1. � ����i \n 2. � �������i \n 3. �i�� �������� \n 4. � �����i \n 5. ���������� ������� \n 6. ������� ������� ( �� " << botle << " ��� ) \n 7. ";
		if (is_main_b == 0)
			cout << "����� ������� ������ ( 3000 ��� + 1000 RP )";
		else
			cout << "�������� ���� ��������� ����� ( - 200 RP )";
		if (is_unemp == 0)
			cout << "\n 8. �������� ����i������ ������i����� ( 1000 RP )";
		else
			cout << "\n 8. �������� ����i������ ������i������ ( - 200 ��� - ������� )";
		if (is_inv == 0)
			cout << "\n 9. �������� ������� �� i����i�����i ( 1000 RP )";
		else
			cout << "\n 9. �������� ����i������ i����i�� ( - 200 ��� - ������� )";
		cout << "\n 10. ����������� � ����";
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

			cout << "�� ������� " << i << " �����";
			if (i ==1)
				cout << "��";
			if (i < 5 && i!=1)
				cout << "��";
			else
				cout << "��";
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
			cout << endl << "�i���i��� ����� �������: " << botles << endl;
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
					cout << "�������� " << 1000 - score << " RP, � ���i �������" << endl;
				else if (money < 3000)
					cout << "�������� " << 3000 - money << " ���, � ���i �������" << endl;
				else {
					cout << "�i����, �� ����� ������� ������. �i� ����� �� ����� ������ ���������� ��������i ������� i RP" << endl;
					is_main_b = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "�� �i���� �� �������� ����.\n -200RP\n -�������" << endl;
				score = score - 200;
				is_main_b = 0;
			}
			system("pause");
			goto m1;
			break;
		case 8:
			if (is_unemp == 0) {
				if (score < 1000)
					cout << "�������� " << 1000 - score << " RP, � ���i �������" << endl;
				else {
					cout << "�i����, �� �������� ����i������ ������i������. �i� ����� �� ������ ����� ���������� ����� ���, ��� ����� �����i�, ���i��� i ������'� �� ����� �i������� ���� 50, � ����������i �� �i������ ��� �� ������. �����, �� ������ ���������� ������� ����� �i����." << endl;
					is_unemp = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "�� �������� ����i������ ������i������.\n -200RP\n -������" << endl;
				score = score - 200;
				is_main_b = 0;
			}
			system("pause");
			goto m1;
			break;
		case 9:
			if (is_inv == 0) {
				if (score < 1000)
					cout << "�������� " << 1000 - score << " RP, � ���i �������" << endl;
				else {
					cout << "�i����, �� �������� ����i������ i����i��. �i� ����� �� ������ ����� ������ ������ � �i����i. �� ������ ����� �����i� i ���i���, ��� ��i���� ���� ������'�. ����� �����i�, ���i��� i ������'� �� ����� �i������� ���� 50. �����, �� ������ ���������� ������� ����� �i����." << endl;
					is_inv = 1;
					money = money - 3000;
					rep_ev(100, 0, -2, 0);
				}
			}
			else {
				cout << "�� �������� ����i������ i����i��.\n -200RP\n -������" << endl;
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
		title("������");
		cout << " 1. ��������� � ����i\n 2. ���i���� �����\n 3. ��������� �� ���i������i\n 4. ���� ������\n 5. ��������� ���'����\n 6. ��������� � McDonald's\n 7. ��������� �� �����i\n 8. ������� �i��� � ����i\n 9. ��������� �����������\n 10. ��������� � �i��i� ������i�\n 11. ��������� � ��i�i\n 12. ��������� � ����i� ������i�\n 13. ��������� � Samsung\n 14. ��������� � Google\n 15. ���� �������� ��������� ������i���� i ��� � ���� �������. (��� ���������� ���� - �i���� �i������ ��� ����)\n 16. ����������� � ����\n";
		infbar();
		if (nom_menu2 >= 1 && nom_menu2 <= 14 && is_unemp == 1) {
			cout << "�� �� ������ ���������, ���� ���� ����i������ ������i������." << endl;
			goto m2;
		}
		if (nom_menu2 >= 1 && nom_menu2 <= 14 && is_inv == 1) {
			cout << "�� i����i�, ���� ��� �� ������ �� ������." << endl;
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
				cout << "��� ��������� � ����i, ��� ����i��� ������� ������� ��������, ������ ����� ���� i ���� ������� �i����� �� 200" << endl;
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
				cout << "��� ���i���� �����, ��� ����i��� ���i����� �����, ������ ����� ��� ���� ������ i ���� ������� �i����� �� 500" << endl;
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
				cout << "��� ��������� �� ���i������i, ��� ����i��� ���i����� ���, ������ ������ ��� ����� ������ i ���� ������� �i����� �� 1 000" << endl;
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
				cout << "��� ���� ������, ��� ����i��� ���i����� ���, ������ ������ ��� ����� ������ i ���� ������� �i����� �� 1 500" << endl;
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
				cout << "��� ��������� ���'����, ��� ����i��� ���i����� ��������� ���, ���� BMW ��� ����i�� ������ i ������� �i����� �� 2 000" << endl;
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
				cout << "��� ��������� � McDonald's, ��� ����i��� ���i����� ��������� ���, ���� BMW ��� ����i�� ������ i ������� �i����� �� 5 000" << endl;
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
				cout << "��� ��������� �� �����i, ��� ����i��� ���i����� ������� ���, ���� BMW ��� ����i�� ������ i ������� �i����� �� 10 000" << endl;
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
				cout << "��� ������� �i��� � ����i, ��� ����i��� ���i����� ������� ���, ���� BMW ��� ����i�� ������ i ������� �i����� �� 15 000" << endl;
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
				cout << "��� ��������� �����������, ��� ����i��� ���i����� ������� ����������, ���� Mercedes Benz ��� ����i�� ������ i ������� �i����� �� 50 000" << endl;
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
				cout << "��� ��������� � �i��i� ������i�, ��� ����i��� ������� ������� ��������, ������ ����� i ���� ������� �i����� �� 100 000" << endl;
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
				cout << "��� ��������� � ��i�i, ��� ����i��� ������� ������� ��������, ������ ����� i ���� ������� �i����� �� 200 000" << endl;
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
				cout << "��� ��������� � ����i� ������i�, ��� ����i��� ������� ����������, ���� ����� ����� i ������� �i����� �� 500 000" << endl;
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
				cout << "��� ��������� � Samsung, ��� ����i��� ������� ����������, ������ Ferrari i ���� ������� �i����� �� 1 000 000" << endl;
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
				cout << "��� ��������� � Google, ��� ����i��� ���i����� �������, ������ ��������� �i��� i ���� ������� �i����� �� 2 000 000" << endl;
				system("pause");
			}
			if (food <= 0 || nast <= 0 || heard <= 0)
				system("pause");
			goto m2;
			break;
		case 15:
			system("CLS");
			title("������ i�������i�");
			cout << "�� ��� ������������ �� � ����� �������� ������. ������ ������i� �� ����������� �� \"����i���\". ��� �������i ���, �i��� \n�� ��� ���i�i� �������� ����i ������i�.\n\n�� �� ������i���, ����� ���� � �i��� �����i�� �����, �?\n" << endl;
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
		title("�i����");
		if (h_b[1] == 0)
			cout << " 1. ������� � ������ �������� ( + 30 000 ��� / �i�)\n";
		else
			cout << " 1. �� ������� � ������ �������� ( - 30 000 ��� / �i�)\n";
		if (h_b[2] == 0)
			cout << " 2. ������� � ������ i������ ( + 50 000 ��� / �i�)\n";
		else
			cout << " 2. �� ������� � ������ i������ ( - 50 000 ��� / �i�)\n";
		if (h_b[3] == 0)
			cout << " 3. ������� � ������ �������� ���������� ( + 2 000 $ / �i�)\n";
		else
			cout << " 3. �� ������� � ������ �������� ���������� ( - 2 000 $ / �i�)\n";
		if (h_b[4] == 0)
			cout << " 4. ������� � ������ ����i� ( + 30 000 $ / �i�)\n";
		else
			cout << " 4. �� ������� � ������ ����i� ( - 30 000 $ / �i�)\n";
		if (h_b[5] == 0)
			cout << " 5. ������� � ������ ����� ������i� ( + 100 000 $ / �i� )\n";
		else
			cout << " 5. �� ������� � ������ ����� ������i� ( - 100 000 $ / �i� )\n";
		if (h_b[6] == 0)
			cout << " 6. ������� � ������ �����i�� ( + 240 000 $ / �i� )\n";
		else
			cout << " 6. �� ������� � ������ �����i�� ( - 240 000 $ / �i� )\n";
		if (h_b[0] == 0)
			cout << " 7. ������� � ������ ���������� ( + 400 000 $ / �i� )\n";
		else
			cout << " 7. �� ������� � ������ ���������� ( - 400 000 $ / �i� )\n";
		cout << " 8. �������� ���������\n 9. �������� ����������\n 10. �������� ������\n 11. �������� ��i���\n 12. �������� �������\n 13. �������� �������\n 14. ����������� � ����\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_b[1] == 0 && h_h[6] == 1 && score>200) {
				h_d2[1] = date[3] - 1;
				if (date[3] <= 0)
					h_d2[1] = 30;
				cout << "�i����! �� ����� �������� � ������. " << h_d2[1] << " ��� ������� �i���� �� ������ ���������� 30 000 ���." << endl;
				h_b[1] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_1;
			}
			if (h_h[6] == 0) {
				cout << "�� �� ���� ��������!" << endl;
				goto m3_1;
			}
			if (score<200 && h_b[1] == 0) {
				cout << "�� �� ������ ����� ��������, ���� ����� ������� ������ �� 200." << endl;
				goto m3_1;
			}
			if (h_b[1] == 1) {
				h_d2[1] = 0;
				h_b[1] = 0;
				cout << "�� �i���� �� ����� ��������." << endl;
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
				cout << "�i����! �� ����� i������ � ������. " << h_d2[2] << " ��� ������� �i���� �� ������ ���������� 50 000 ���." << endl;
				h_b[2] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_2;
			}
			if (h_h[7] == 0) {
				cout << "�� �� ���� i������!" << endl;
				goto m3_2;
			}
			if (score<500 && h_b[2] == 0) {
				cout << "�� �� ������ ����� i������, ���� ����� ������� ������ �� 500." << endl;
				goto m3_2;
			}
			if (h_b[2] == 1) {
				h_d2[2] = 0;
				h_b[2] = 0;
				cout << "�� �i���� �� ����� i������." << endl;
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
				cout << "�i����! �� ����� �������� � ������. " << h_d2[3] << " ��� ������� �i���� �� ������ ���������� 2 000 $." << endl;
				h_b[3] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_3;
			}
			if (h_h[8] == 0) {
				cout << "�� �� ���� ��������!" << endl;
				goto m3_3;
			}
			if (score<1000 && h_b[3] == 0) {
				cout << "�� �� ������ ����� ��������, ���� ����� ������� ������ �� 1 000." << endl;
				goto m3_3;
			}
			if (h_b[3] == 1) {
				h_d2[3] = 0;
				h_b[3] = 0;
				cout << "�� �i���� �� ����� ��������." << endl;
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
				cout << "�i����! �� ����� ����i� � ������. " << h_d2[4] << " ��� ������� �i���� �� ������ ���������� 30 000 $." << endl;
				h_b[4] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_4;
			}
			if (h_h[10] == 0) {
				cout << "�� �� ���� �������!" << endl;
				goto m3_4;
			}
			if (score<5000 && h_b[4] == 0) {
				cout << "�� �� ������ ����� ����i�, ���� ����� ������� ������ �� 5 000." << endl;
				goto m3_4;
			}
			if (h_b[4] == 1) {
				h_d2[4] = 0;
				h_b[4] = 0;
				cout << "�� �i���� �� ����� ����i�." << endl;
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
				cout << "�i����! �� ����� ����� ������i� � ������. " << h_d2[5] << " ��� ������� �i���� �� ������ ���������� 100 000 $." << endl;
				h_b[5] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_5;
			}
			if (h_h[11] == 0) {
				cout << "�� �� ���� ����� ������i�!" << endl;
				goto m3_5;
			}
			if (score<20000 && h_b[5] == 0) {
				cout << "�� �� ������ ����� ����� ������i�, ���� ����� ������� ������ �� 20 000." << endl;
				goto m3_5;
			}
			if (h_b[5] == 1) {
				h_d2[5] = 0;
				h_b[5] = 0;
				cout << "�� �i���� �� ����� ����� ������i�." << endl;
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
				cout << "�i����! �� ����� �����i�� � ������. " << h_d2[6] << " ��� ������� �i���� �� ������ ���������� 240 000 $." << endl;
				h_b[6] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_6;
			}
			if (h_h[12] == 0) {
				cout << "�� �� ���� ����� ������i�!" << endl;
				goto m3_6;
			}
			if (score<50000 && h_b[6] == 0) {
				cout << "�� �� ������ ����� �����i��, ���� ����� ������� ������ �� 50 000." << endl;
				goto m3_6;
			}
			if (h_b[6] == 1) {
				h_d2[6] = 0;
				h_b[6] = 0;
				cout << "�� �i���� �� ����� �����i��." << endl;
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
				cout << "�i����! �� ����� ���������� � ������. " << h_d2[0] << " ��� ������� �i���� �� ������ ���������� 10 000 000 $." << endl;
				h_b[0] = 1;
				rep_ev(0, 0, 0, 0);
				goto m3_7;
			}
			if (h_h[13] == 0) {
				cout << "�� �� ���� ����� ������i�!" << endl;
				goto m3_7;
			}
			if (score<100000 && h_b[0] == 0) {
				cout << "�� �� ������ ����� ����������, ���� ����� ������� ������ �� 100 000." << endl;
				goto m3_7;
			}
			if (h_b[0] == 1) {
				h_d2[0] = 0;
				h_b[0] = 0;
				cout << "�� �i���� �� ����� ����������." << endl;
			}
		m3_7:
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 8:
			p_bis("�������", "���������", "�������i", 1, 1);//��������, ����������, ��������i, ����i�i��� �������, ����� ����� �i�����
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 9:
			p_bis("��������", "����������", "��������i", 2, 2);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 10:
			p_bis("�����", "������", "����i", 3, 3);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 11:
			p_bis("��i�", "��i���", "��i���", 4, 4);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 12:
			p_bis("������", "�������", "�������", 10, 5);
			system("pause");
			system("CLS");
			goto m3;
			break;
		case 13:
			p_bis("������", "�������", "������", 20, 0);
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
		title("���");
		cout << " 1. ������ ��� �� ��i�����\n 2. ������ ������ (25 ���)\n 3. ������ ������ (35 ���)\n 4. ����� � ��i���i� ������i (60 ���)\n 5. ������ ��� � �����������i (200 ���)\n 6. ����� � ��������i (500 ���)\n 7. �������� ��� �� ���� (1000 ���)\n";
		if (h_t[0] == 0)
			cout << " 8. ������� ������ (10 000 ��� / ����)";
		else
			cout << " 8. ��i������ ������ (+10 000 ��� / ����)";
		cout << "\n 9. ����������� � ����" << endl;
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
				cout << "�i����, �� ������� ������. ��� �i���� �� ����� ����������� ��� ���i���." << endl;
				rep_ev(10000, 0, 0, 0);
			}
			else {
				cout << "�� ��i������ ������, +10 000 ��� / ����." << endl;
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
		title("�������");
		cout << " 1. �������� �� ���������\n 2. ������ ������ (25 ���)\n 3. ������ ���� (35 ���)\n 4. ������ ���� (60 ���)\n 5. ������ �i��i (200 ���)\n 6. ������ ������� ������� (500 ���)\n 7. ������ ���������� ����(1000 ���)\n";
		if (h_t[1] == 0)
			cout << " 8. ���������� � ���� (10 000 ��� / ����)";
		else
			cout << " 8. �� ������ � ���� (+10 000 ��� / ����)";
		cout << "\n 9. ����������� � ����" << endl;
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
				cout << "�i����, �� ���������� � ����. ��� �i���� �� ����� ����������� ��� �����i�." << endl;
				rep_ev(10000, 0, 0, 0);
			}
			else {
				cout << "�� �������� ����, +10 000 ��� / ����." << endl;
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
		title("������'�");
		cout << " 1. ��������\n 2. ���i������ � �����(25 ���)\n 3. ������� �� ����������� �i���� (35 ���)\n 4. �i��i���� �������i�(60 ���)\n 5. �i��i���� ������ �i�����(200 ���)\n 6. �i��i���� ����� ��i�i��(500 ���)\n 7. �i�������� � i����i(1000 ���)\n 8. ������� ����i���\n 9. ";
		if (h_s[0] == 0)
			cout << "������� ������� (10 000 ��� / ����)";
		else
			cout << "��i������ ������� (+10 000 ��� / ����)";
		cout << "\n 10. ����������� � ����";
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
				cout << "������ ���i�� ��������\n";
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
					cout << "������ ���i�� ��������\n";
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
		title("���i��");
		cout << " 1. ��������� ��������\n";
		if (h_s[2] == 0)
			cout << " 2. ������� ������� �������� (100 ���)\n";
		else
			cout << " 2. �� ������� ������ ��������\n";
		if (h_s[3] == 0)
			cout << " 3. ���i����� ����� (30 000 ���)\n";
		else
			cout << " 3. �� ��� ��������� � ����i\n";
		if (h_s[4] == 0)
			cout << " 4. ���i����� ��� (50 000 ���)\n";
		else
			cout << " 4. ��� ���i�����!\n";
		if (h_s[5] == 0)
			cout << " 5. �i�� � ��������� ��� (100 000 ���)\n";
		else
			cout << " 5. �� ���i����� ��������� ���\n";
		if (h_s[6] == 0)
			cout << " 6. ���i����� ������� ��� (500 000 ���)\n";
		else
			cout << " 6. ��� ���i�����\n";
		if (h_s[7] == 0)
			cout << " 7. ������� ���������� (250 000 $)\n";
		else
			cout << " 7. �� ��� ��������� ����������\n";
		if (h_s[8] == 0)
			cout << " 8. ���i����� ������� (1 000 000 $)\n";
		else
			cout << " 8. ������� ���i�����\n";
		cout << " 9. ����������� � ����\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_s[2] == 0) {
				i = rand() % 10;
				if (i == 0) {
					cout << "�i����, �� ������� ������� ��������!" << endl;
					rep_ev(200, 3, -3, 1);
					h_s[2] = 1;
				}
				else {
					cout << "�� �i���� �� �������." << endl;
					rep_ev(0, 3, 3, 1);
				}
			}
			system("pause");
			system("CLS");
			goto m7;
			break;
		case 2:
			if (h_s[2] == 0 && money >= 100) {
				cout << "�i����! �� ������� ������� ��������." << endl;
				money = money - 100;
				rep_ev(100, 0, 0, 0);
				h_s[2] = 1;
				system("pause");
			}
			if (h_s[2] == 0 && money<100) {
				cout << "����������� ������!" << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 3:
			if (h_s[3] == 0 && money >= 30000) {
				cout << "�i����! �� ���i����� �����." << endl;
				money = money - 30000;
				rep_ev(200, 0, 0, 0);
				system("pause");
				h_s[3] = 1;
			}
			if (h_s[3] == 0 && money<15000) {
				cout << "����������� ������!" << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 4:
			if (h_s[3] == 1) {
				if (h_s[4] == 0 && money >= 50000) {
					cout << "�i����! �� ���i����� ���." << endl;
					money = money - 50000;
					rep_ev(500, 0, 0, 0);
					h_s[4] = 1;
					system("pause");
				}
				if (h_s[4] == 0 && money<50000) {
					cout << "����������� ������!" << endl;
					system("pause");
				}
			}
			else {
				cout << "��� �� ������� � ��� ���� �� �� ���i����� �����." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 5:
			if (h_s[3] == 1) {
				if (h_s[5] == 0 && money >= 100000) {
					cout << "�i����! �� �i���� � ��������� ���." << endl;
					system("pause");
					money = money - 100000;
					rep_ev(1000, 0, 0, 0);
					h_s[5] = 1;
				}
				if (h_s[5] == 0 && money<100000)
					cout << "����������� ������!" << endl;
					system("pause");
			}
			else {
				cout << "��� �� ������� � ��������� ��� ���� �� �� ���i����� �����." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 6:
			if (h_s[3] == 1 && h_t[5] == 1 || h_s[3] == 1 && h_t[6] == 1 || h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[6] == 0 && money >= 500000) {
					cout << "�i����! �� ���i���� ������� ���." << endl;
					money = money - 1000000;
					rep_ev(10000, 0, 0, 0);
					h_s[6] = 1;
					system("pause");
				}
				if (h_s[6] == 0 && money<500000) {
					cout << "����������� ������!" << endl;
					system("pause");
				}
			}
			else {
				cout << "��� �� ������� � ������� ���, ���� �� �� ���i����� ����� i �� ���� ������ ������ �� 50 000 ���." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 7:
			if (h_s[3] == 1 && h_t[5] == 1 || h_s[3] == 1 && h_t[6] == 1 || h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[7] == 0 && money2 >= 250000) {
					cout << "�i����! �� ���i����� ����������� ���." << endl;
					money2 = money2 - 250000;
					rep_ev(50000, 0, 0, 0);
					h_s[7] = 1;
					system("pause");
				}
				if (h_s[7] == 0 && money2<250000) {
					cout << "����������� ������!" << endl;
					system("pause");
				}
			}
			else {
				cout << "��� �� ������� � ����������� ���, ���� �� �� ���i����� ����� i �� ���� ������ ������ �� 50 000 ���." << endl;
				system("pause");
			}
			system("CLS");
			goto m7;
			break;
		case 8:
			if (h_s[3] == 1 && h_t[7] == 1 || h_s[3] == 1 && h_t[8] == 1 || h_s[3] == 1 && h_t[9] == 1) {
				if (h_s[8] == 0 && money2 >= 1000000) {
					cout << "�i����! �� ���i����� �������." << endl;
					money2 = money2 - 1000000;
					rep_ev(100000, 0, 0, 0);
					h_s[8] = 1;
					system("pause");
				}
				if (h_s[8] == 0 && money2<1000000) {
					cout << "����������� ������!" << endl;
					system("pause");
				}
			}
			else {
				cout << "��� �� ������� � �������, ���� �� �� ���i����� ����� i �� ���� ������ ������ �� 200 000 $." << endl;
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
		title("���������");
		if (h_t[2] == 1)
			SetColor(8, 0);
		cout << " 1. ������ ������ �� ��i�����\n";
		SetColor(7, 0);
		if (h_t[2] == 0)
			cout << " 2. ������ ���� (200 ���)\n";
		else
			cout << " 2. ������� ���� (+100 ���)\n";
		if (h_t[3] == 0)
			cout << " 3. ������ ����� (2 000 ���)\n";
		else
			cout << " 3. ������� ����� (+1 000 ���)\n";
		if (h_t[4] == 0)
			cout << " 4. ������ ������ (30 000 ���)\n";
		else
			cout << " 4. ������� ������ (+15 000 ���)\n";
		if (h_t[5] == 0)
			cout << " 5. ������ �/� BMW (100 000 ���)\n";
		else
			cout << " 5. ������� �/� BMW (+50 000 ���)\n";
		if (h_t[6] == 0)
			cout << " 6. ������ ���� Mercedes Benz (1 000 000 ���)\n";
		else
			cout << " 6. ������� �/� Mercedes Benz (+500 000)\n";
		if (h_t[7] == 0)
			cout << " 7. ������ ����� ����� (250 000 $)\n";
		else
			cout << " 7. ������� ����� ����� (+125 000 $)\n";
		if (h_t[8] == 0)
			cout << " 8. ������ Ferrari (1 000 000 $)\n";
		else
			cout << " 8. ������� Ferrari ( +500 000 $)\n";
		if (h_t[9] == 0)
			cout << " 9. ������ ��������� �i��� (2 500 000 $)\n";
		else
			cout << " 9. ������� ��������� �i��� (+1 250 000 $)\n";
		cout << " 10. ����������� � ����\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_t[2] == 0) {
				i = rand() % 10;
				if (i == 0) {
					cout << "�i����, �� ������� ����!" << endl;
					rep_ev(200, 3, -3, 1);
					h_t[2] = 1;
				}
				else {
					cout << "�� �i���� �� �������." << endl;
					rep_ev(0, 3, 3, 1);
				}
			}
			else
				cout << "�� ��� ���� ����!" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 2:
			if (h_t[2] == 0 && money >= 200) {
				cout << "�i����! �� ������ ����." << endl;
				money = money - 200;
				rep_ev(100, 0, 0, 0);
				h_t[2] = 1;
			}
			else if (h_t[2] == 0 && money<200)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� ����, +100 ���" << endl;
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
					cout << "�i����! �� ������ �����." << endl;
					money = money - 2000;
					rep_ev(200, 0, 0, 0);
					h_t[3] = 1;
				}
				else if (h_t[3] == 0 && money<2000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� �����, +1000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 1000;
					h_t[3] = 0;
				}
			}
			else
				cout << "������ ���i�� ����!" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 4:
			if (h_t[2] == 1) {
				if (h_t[4] == 0 && money >= 30000) {
					cout << "�i����! �� ������ ������." << endl;
					money = money - 30000;
					rep_ev(500, 0, 0, 0);
					h_t[4] = 1;
				}
				else if (h_t[4] == 0 && money<30000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� ������, +15000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 15000;
					h_t[4] = 0;
				}
			}
			else
				cout << "��� �� ��������� ������, ���� �� ���i" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 5:
			if (h_t[2] == 1) {
				if (h_t[5] == 0 && money >= 100000) {
					cout << "�i����! �� ������ �/� BMW." << endl;
					money = money - 100000;
					rep_ev(1000, 0, 0, 0);
					h_t[5] = 1;
				}
				else if (h_t[5] == 0 && money<100000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� �/� BMW, +50 000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 50000;
					h_t[5] = 0;
				}
			}
			else
				cout << "��� �� ��������� ������, ���� �� ���i" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 6:
			if (h_t[2] == 1) {
				if (h_t[6] == 0 && money >= 1000000) {
					cout << "�i����! �� ������ ���� Mercedes Benz." << endl;
					money = money - 1000000;
					rep_ev(10000, 0, 0, 0);
					h_t[6] = 1;
				}
				else if (h_t[6] == 0 && money<1000000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� �/� Mercedes Benz, +500 000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 500000;
					h_t[6] = 0;
				}
			}
			else
				cout << "��� �� ��������� ������, ���� �� ���i" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 7:
			if (h_t[2] == 1) {
				if (h_t[7] == 0 && money2 >= 250000) {
					cout << "�i����! �� ������ ����� �����." << endl;
					money2 = money2 - 250000;
					rep_ev(50000, 0, 0, 0);
					h_t[7] = 1;
				}
				else if (h_t[7] == 0 && money2<250000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� ����� �����, +125 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 125000;
					h_t[7] = 0;
				}
			}
			else
				cout << "��� �� ��������� ������, ���� �� ���i" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 8:
			if (h_t[7] == 1) {
				if (h_t[8] == 0 && money2 >= 1000000) {
					cout << "�i����! �� ������ Ferrari." << endl;
					money2 = money2 - 1000000;
					rep_ev(100000, 0, 0, 0);
					h_t[8] = 1;
				}
				else if (h_t[8] == 0 && money2<1000000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� Ferrari, +500000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 100;
					h_t[8] = 0;
				}
			}
			else
				cout << "��� �� ������� � ����� ��� ��������� ������" << endl;
			system("pause");
			system("CLS");
			goto m8;
			break;
		case 9:
			if (h_t[8] == 1) {
				if (h_t[9] == 0 && money2 >= 2500000) {
					cout << "�i����! �� ������ ��������� �i���." << endl;
					money2 = money2 - 2500000;
					rep_ev(100, 0, 0, 0);
					h_t[9] = 1;
				}
				else if (h_t[9] == 0 && money2<2500000)
					cout << "����������� ������!" << endl;
				else {
					cout << "�� ������� ��������� �i���, +1250000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 100;
					h_t[9] = 0;
				}
			}
			else
				cout << "��� �� ��������� �i���, ���� �� ��� Ferrari" << endl;
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
		title("�����");
		if (h_h[1] == 0)
			cout << " 1. ������ ������� ( 200 ��� )\n";
		else
			cout << " 1. ������� ������� ( + 100 ��� )\n";
		if (h_h[2] == 0)
			cout << " 2. ���������� �i����� � ���������� ( - 10 000 ��� / �i� )\n";
		else
			cout << " 2. �� ���������� �i����� � ���������� ( + 10 000 ��� / �i�)\n";
		if (h_h[3] == 0)
			cout << " 3. ���� � 3 �i������� �����i ( - 20 000 ��� / �i� )\n";
		else
			cout << " 3. ������ � 3 �i������� ������ ( + 20 000 ��� / �i� )\n";
		if (h_h[4] == 0)
			cout << " 4. ��i���� �������� ( - 30 000 ��� / �i� )\n";
		else
			cout << " 4. �� ��i���� �������� ( + 30 000 ��� / �i� )\n";
		if (h_h[5] == 0)
			cout << " 5. ��i���� i������ ( - 50 000 ��� / �i� )\n";
		else
			cout << " 5. ������ � i������ ( + 50 000 ��� / �i� )\n";
		if (h_h[6] == 0)
			cout << " 6. ������ �������� ( 500 000 ��� )\n";
		else
			cout << " 6. ������� �������� ( +250 000 ��� )\n";
		if (h_h[7] == 0)
			cout << " 7. ������ i������ ( 1 000 000 ��� )\n";
		else
			cout << " 7. ������� i������ ( 500 000 ��� )\n";
		if (h_h[8] == 0)
			cout << " 8. ������ �������� ���������� ( 50 000 $)\n";
		else
			cout << " 8. ������� �������� ���������� ( + 25 000 $)\n";
		if (h_h[9] == 0)
			cout << " 9. ������ ����� ���������� ( 150 000 $)\n";
		else
			cout << " 9. ������� ����� ���������� ( + 75 000 $)\n";
		if (h_h[10] == 0)
			cout << " 10. ������ ����i� ( 500 000 $)\n";
		else
			cout << " 10. ������� ����i� ( + 250 000 $)\n";
		if (h_h[11] == 0)
			cout << " 11. ������ ����� ������i� ( 1 500 000 $)\n";
		else
			cout << " 11. ������� ����� ������i� ( 750 000 $)\n";
		if (h_h[12] == 0)
			cout << " 12. ������ �����i�� ( 3 000 000 $)\n";
		else
			cout << " 12. ������� �����i�� ( 1 500 000 $)\n";
		if (h_h[13] == 0)
			cout << " 13. ������ ���������� ( 10 000 000 $)\n";
		else
			cout << " 13. ������� ���������� ( 5 000 000 $)\n";
		cout << " 14. ����������� � ����\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_h[1] == 0 && money >= 200) {
				cout << "�i����! �� ������ �������." << endl;
				money = money - 200;
				rep_ev(100, 0, 0, 0);
				h_h[1] = 1;
				goto m9_1;
			}
			else if (h_h[1] == 0 && money<200) {
				cout << "����������� ������!" << endl;
				goto m9_1;
			}
			else {
				cout << "�� ������� �������, +100 ���" << endl;
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
				cout << "�i����! �� �������� �i����� � ����������. " << h_date[2] << " ���, ������� �i����, � ��� ������ ����� 10 000 ���." << endl;
				rep_ev(200, 0, 0, 0);
				h_h[2] = 1;
			}
			else if (h_h[2] == 0 && money<10000) {
				cout << "����������� ������!" << endl;
				goto m9_2;
			}
			else {
				cout << "�� �i���� �� �������� �i����� � ����������." << endl;
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
				cout << "�i����! �� ������ � ����������. " << h_date[3] << " ���, ������� �i����, � ��� ������ ����� 20 000 ���." << endl;
				rep_ev(500, 0, 0, 0);
				h_h[3] = 1;
			}
			else if (h_h[3] == 0 && money<10000) {
				cout << "����������� ������!" << endl;
				goto m9_3;
			}
			else {
				cout << "�� �i���� �� �������� �i����� � ����������." << endl;
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
				cout << "�i����! �� ��i���� ��������. " << h_date[4] << " ���, ������� �i����, � ��� ������ ����� 30 000 ���." << endl;
				rep_ev(1000, 0, 0, 0);
				h_h[4] = 1;
			}
			else if (h_h[4] == 0 && money<30000) {
				cout << "����������� ������!" << endl;
				goto m9_4;
			}
			else {
				cout << "�� �i���� �� �������� �i�����." << endl;
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
				cout << "�i����! �� ��i���� i������. " << h_date[5] << " ���, ������� �i����, � ��� ������ ����� 50 000 ���." << endl;
				rep_ev(2000, 0, 0, 0);
				h_h[5] = 1;
			}
			else if (h_h[5] == 0 && money<10000) {
				cout << "����������� ������!" << endl;
				goto m9_5;
			}
			else {
				cout << "�� �i���� �� �������� �i����� � ����������." << endl;
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
					cout << "�i����! �� ������ ���� ��������." << endl;
					money = money - 500000;
					rep_ev(5000, 0, 0, 0);
					h_h[6] = 1;
				}
				else if (h_h[6] == 0 && money<500000) {
					cout << "����������� ������!" << endl;
					goto m9_6;
				}
				else {
					cout << "�� ������� ��������, +250 000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 250000;
					h_h[6] = 0;
					score = score - 5000;
				}
			}
			else
				cout << "��� �� ��������� ��������, ���� �� ���i" << endl;
		m9_6:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 7:
			if (h_t[2] == 1) {
				if (h_h[7] == 0 && money >= 1000000) {
					cout << "�i����! �� ������ i������." << endl;
					money = money - 1000000;
					rep_ev(15000, 0, 0, 0);
					h_h[7] = 1;
				}
				else if (h_h[7] == 0 && money<1000000) {
					cout << "����������� ������!" << endl;
					goto m9_7;
				}
				else {
					cout << "�� ������� i������, + 500 000 ���" << endl;
					rep_ev(0, 0, 0, 0);
					money = money + 500000;
					score = score - 15000;
					h_h[7] = 0;
				}
			}
			else
				cout << "��� �� ��������� i������, ���� �� ���i" << endl;
		m9_7:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 8:
			if (h_h[8] == 0 && money2 >= 50000) {
				cout << "�i����! �� ������ �������� ����������." << endl;
				money2 = money2 - 50000;
				rep_ev(40000, 0, 0, 0);
				h_h[8] = 1;
			}
			else if (h_h[8] == 0 && money2<50000) {
				cout << "����������� ������!" << endl;
				goto m9_8;
			}
			else {
				cout << "�� ������� ��������, + 25 000 $" << endl;
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
					cout << "�i����! �� ������ ����� ����������." << endl;
					money2 = money2 - 150000;
					rep_ev(100000, 0, 0, 0);
					h_h[9] = 1;
				}
				else if (h_h[9] == 0 && money2<150000) {
					cout << "����������� ������!" << endl;
					goto m9_9;
				}
				else {
					cout << "�� ������� ��������� �����, + 75 000 ;" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 75000;
					score = score - 100000;
					h_h[9] = 0;
				}
			}
			else
				cout << "��� �� ��������� �����, ���� �� ��� Ferrari" << endl;
		m9_9:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 10:
			if (h_t[9] == 1) {
				if (h_h[10] == 0 && money2 >= 500000) {
					cout << "�i����! �� ������ ����i�." << endl;
					money2 = money2 - 500000;
					rep_ev(200000, 0, 0, 0);
					h_h[10] = 1;
				}
				else if (h_h[10] == 0 && money2<500000) {
					cout << "����������� ������!" << endl;
					goto m9_10;
				}
				else {
					cout << "�� ������� ����i�, + 250 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 250000;
					score = score - 200000;
					h_h[10] = 0;
				}
			}
			else
				cout << "��� �� ��������� ����i�, ���� �� ��� ���������� �i����" << endl;
		m9_10:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 11:
			if (h_t[9] == 1) {
				if (h_h[11] == 0 && money2 >= 1500000) {
					cout << "�i����! �� ������ ����� ������i�." << endl;
					money2 = money2 - 1500000;
					rep_ev(500000, 0, 0, 0);
					h_h[11] = 1;
				}
				else if (h_h[11] == 0 && money2<1500000) {
					cout << "����������� ������!" << endl;
					goto m9_11;
				}
				else {
					cout << "�� ������� ����� ������i�, + 750 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 750000;
					score = score - 500000;
					h_h[11] = 0;
				}
			}
			else
				cout << "��� �� ��������� ����� ������i�, ���� �� ��� ���������� �i����" << endl;
		m9_11:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 12:
			if (h_t[9] == 1) {
				if (h_h[12] == 0 && money2 >= 3000000) {
					cout << "�i����! �� ������ �����i��." << endl;
					money2 = money2 - 3000000;
					rep_ev(1500000, 0, 0, 0);
					h_h[12] = 1;
				}
				else if (h_h[12] == 0 && money2<3000000) {
					cout << "����������� ������!" << endl;
					goto m9_12;
				}
				else {
					cout << "�� ������� �����i��, + 1 500 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 1500000;
					score = score - 1500000;
					h_h[12] = 0;
				}
			}
			else
				cout << "��� �� ��������� �����i��, ���� �� ��� ���������� �i����" << endl;
		m9_12:
			system("pause");
			system("CLS");
			goto m9;
			break;
		case 13:
			if (h_t[9] == 1) {
				if (h_h[13] == 0 && money2 >= 10000000) {
					cout << "�i����! �� ������ ����������." << endl;
					money2 = money2 - 10000000;
					rep_ev(15000000, 0, 0, 0);
					h_h[13] = 1;
				}
				else if (h_h[13] == 0 && money2<10000000) {
					cout << "����������� ������!" << endl;
					goto m9_13;
				}
				else {
					cout << "�� ������� ����������, + 5 000 000 $" << endl;
					rep_ev(0, 0, 0, 0);
					money2 = money2 + 5000000;
					score = score - 15000000;
					h_h[13] = 0;
				}
			}
			else
				cout << "��� �� ��������� ����������, ���� �� ��� ���������� �i����" << endl;
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
		title("�������i���");
		if (h_n[1] == 0)
			cout << " 1. ������ ������� ( 500 000 ��� )\n";
		else {
			cout << " 1. ������� ������� ( + ";
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
			cout << " ��� )\n";
		}
		if (h_n[2] == 0)
			cout << " 2. ������ �������� ( 1 000 000 ��� )\n";
		else {
			cout << " 2. ������� �������� ( + ";
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
			cout << " ��� )\n";
		}
		if (h_n[3] == 0)
			cout << " 3. ������ ����� ( 1 500 000 ��� )\n";
		else {
			cout << " 3. ������� ����� ( + ";
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
			cout << " ��� )\n";
		}
		if (h_n[4] == 0)
			cout << " 4. ������ ��i� ( 2 000 000 ��� )\n";
		else {
			cout << " 4. ������� ��i� ( + ";
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
			cout << " ��� )\n";
		}
		if (h_n[5] == 0)
			cout << " 5. ������ ������ ( 5 000 000 ��� )\n";
		else {
			cout << " 5. ������� ������ ( + ";
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
			cout << " ��� )\n";
		}
		if (h_n[0] == 0)
			cout << " 6. ������ ������ ( 10 000 000 ��� )\n";
		else {
			cout << " 6. ������� ������ ( + ";
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
			cout << " ��� )\n";
		}
		cout << " 7. ����������� � ����\n";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_n[1] == 0 && money >= 500000) {
				cout << "�i����! �� ������ �������." << endl;
				money = money - 500000;
				rep_ev(1000, 0, 0, 0);
				h_n[1] = 1;
			}
			else if (h_n[1] == 0 && money<500000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� �������, +";
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
				cout << " ���" << endl;
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
				cout << "�i����! �� ������ ��������." << endl;
				money = money - 1000000;
				rep_ev(2000, 0, 0, 0);
				h_n[2] = 1;
			}
			else if (h_n[2] == 0 && money<1000000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� �������, +";
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
				cout << " ���" << endl;
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
				cout << "�i����! �� ������ �����." << endl;
				money = money - 1500000;
				rep_ev(3000, 0, 0, 0);
				h_n[3] = 1;
			}
			else if (h_n[3] == 0 && money<1500000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� �����, +";
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
				cout << " ���" << endl;
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
				cout << "�i����! �� ������ ��i�." << endl;
				money = money - 2000000;
				rep_ev(4000, 0, 0, 0);
				h_n[4] = 1;
			}
			else if (h_n[4] == 0 && money<2000000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� ��i�, +";
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
				cout << " ���" << endl;
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
				cout << "�i����! �� ������ ������." << endl;
				money = money - 5000000;
				rep_ev(10000, 0, 0, 0);
				h_n[5] = 1;
			}
			else if (h_n[5] == 0 && money<5000000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� ������, +";
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
				cout << " ���" << endl;
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
				cout << "�i����! �� ������ ������." << endl;
				money = money - 10000000;
				rep_ev(2000, 0, 0, 0);
				h_n[0] = 1;
			}
			else if (h_n[0] == 0 && money<1000000)
				cout << "����������� ������!" << endl;
			else {
				cout << "�� ������� ������, +";
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
				cout << " ���" << endl;
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
		title("�i�����");
		cout << " 1. ������ $\n 2. ������ $ �� ��i �����i \n 3. ������ �����i \n 4. ������ �����i �� ��i ������\n 5. ����������� � ����\n\n ����:" << curs;
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			cout << "����i�� �i���i��� �����i�:" << endl;
			cin >> i;
			i = abs(i);
			if (money - i*curs >= 0) {
				money = money - i*curs;
				money2 = money2 + i;
				cout << "+" << i << "$" << endl;
			}
			else
				cout << "������� ������!" << endl;
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
			cout << "����i�� �i���i��� �������:" << endl;
			cin >> i;
			i = abs(int(i / curs));
			if (money2 >= i) {
				money = money + i*curs;
				money2 = money2 - i;
				cout << "+" << i * 30 << "���" << endl;
			}
			else
				cout << "������� ������!" << endl;
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
		title("�������");
		cout << " 1. �i������� �������� ( 200 ���)\n 2. ������ � ������ ( 1 000 ���)\n 3. ���� ����i ����� ( 2 000 ���)\n 4. ��������� � ���������� ( 5 000 ��� )\n 5. ������������ ( 10 000 ��� )\n 6. �������� ������� ( 50 000 ��� )\n 7. ������������ ( 100 000 ��� )\n 8. ������ ���������i� ( 500 000 ��� )\n 9. ������������ ( 1 000 000 ��� )\n ";
		if (h_e[2] == 0)
			cout << "10. �������� � ������i��� �����i���i� ( -";
		else
			cout << "10. �������� ������i��� �����i���i� ( +";
		cout << "5 000 ��� / ���� )\n 11. ����������� � ����\n";
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
		title("����i�");
		cout << " 1. ����������� �����\n 2. ��������� � ���������\n 3. ������ �������� � ��������� \n 4. ����������� ����������\n 5. ����������� ��������i�\n 6. ����������� �������\n 7. ����������� ���������i�\n 8. ����������� i��������i�\n 9. ����������� ��i�����\n 10. ����������� ����\n 11. ����������� �����\n 12. ����������� � ����";
		infbar();
		cin >> nom_menu2;
		switch (nom_menu2) {
		case 1:
			if (h_t[2] == 0 || score<200)
				cout << "������ ���i�� ���� i ��������� ������� �i����� �� 200" << endl;
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
				cout << "������ ���i�� ����, ��������� ������� �i����� �� 500 i ���i��i�� �����" << endl;
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
				cout << "������ ���i�� ����, ��������� ������� �i����� �� 1 000 i ���i��i�� ���" << endl;
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
				cout << "������ ���i�� �����, ��������� ������� �i����� �� 5 000 i ���i��i�� ���" << endl;
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
				cout << "������ ���i�� ������, ��������� ������� �i����� �� 10 000 i ���i��i�� ���" << endl;
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
				cout << "������ ���i�� BMW, ��������� ������� �i����� �� 15 000 i ���i��i�� ��������� ���" << endl;
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
				cout << "������ ���i�� BMW, ��������� ������� �i����� �� 30 000 i ���i��i�� ��������� ���" << endl;
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
				cout << "������ ���i�� Mercedes Benz, ��������� ������� �i����� �� 50 000 i ���i��i�� ������� ���" << endl;
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
				cout << "������ ���i�� ����� �����, ��������� ������� �i����� �� 75 000 i ���i��i�� ����������� ���" << endl;
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
				cout << "������ ���i�� Ferrari, ��������� ������� �i����� �� 150 000 i ���i��i�� ����������� ���" << endl;
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
				cout << "������ ���i�� ��������� �i���, ��������� ������� �i����� �� 300 000 i ���i��i�� �������" << endl;
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
		title("����");
		if (h_e[0] == 0)
			cout << " 1. ������ ������ �� 10 ��i� (10000 ���)";
		else
			cout << " 1. ������ �i� �� " << amulet_d << " ��i�";
		if (h_e[1] == 0)
			cout << "\n 2. ������� �������� ( -5 000 ��� / ���� )\n";
		else
			cout << "\n 2. ��i������ �������� ( +5 000 / ����)\n";
		cout << " 3. ����������� � ����\n";
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
					cout << "�� ������ ������ �� 10 ��i�. �������� ����� ����, �� ������ �i��� �������. ��� �������� �i����� �����, ����i�� ��������" << endl;
					system("pause");
				}
				else {
					cout << "���� ������!" << endl;
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
					cout << "�� ������� ��������. �i� ��� ������ i ������ �i��� �������." << endl;
					system("pause");
					l_dif = dif;
				}
				else {
					cout << "���� ������!" << endl;
					system("pause");
				}
			}
			else {
				cout << "�� ��i������ ��������!" << endl;
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
	is_beta = 0; //                        ��i���� �� 0 ���� ������� ��������
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