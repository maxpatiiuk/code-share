#include <iostream>
#include <string>
#include <time.h>
#include <windows.h>
using namespace std;
struct binaryTree {
	string value;
	binaryTree *left, *right, *prev;
};
binaryTree *bin = new binaryTree, *root = new binaryTree;
int i, ii;
void add() {
	binaryTree *temp = new binaryTree, *temp2 = new binaryTree;
	cout << "Value: ";
	cin >> temp->value;
	if (root->value.empty()) {
		root = temp;
		root->prev = root->right = root->left = NULL;
	}
	else {
		temp2 = root;
		if (temp2->value>temp->value) {
			while (1) {
				if (temp2->right != NULL)
					temp2 = temp2->right;
				else {
					temp2->right = temp;
					break;
				}
			}
		}
		else {
			while (1) {
				if (temp2->left != NULL)
					temp2 = temp2->left;
				else {
					temp2->left = temp;
					break;
				}
			}
		}
		temp->right = temp->left = NULL;
	}
}
void print(binaryTree *bin) {
	if (bin->left != NULL)
		print(bin->left);
	cout << bin->value << endl;
	if (bin->right != NULL)
		print(bin->right);
}
int counting(binaryTree *bin, int level) {
	if (level == i && bin->value.empty()==false) {
		ii++;
		return ii;
	}
	if (bin->left != NULL )
		counting(bin->left, level + 1);
	if (bin->right != NULL)
		counting(bin->right, level + 1);
	return ii;
}
void count() {
	cout << "Number of elements of which level do you want to count? (starting from 0)" << endl;
	cin >> i;
	ii = 0;
	cout << counting(root, 0) << endl;
}
void menu() {
	root->prev = root->right = root->left = NULL;
	while (1) {
		system("CLS");
		cout << "1. Add\n2. Print\n3. Count\n0. Exit\n";
		cin >> i;
		system("CLS");
		switch (i) {
		case 1:
			add();
			break;
		case 2:
			print(root);
			break;
		case 3:
			count();
			break;
		case 0:
			exit(0);
			break;
		}
		system("pause");
	}
}
void main() {
	menu();
}