string = "  sample  "
string2 = "  sample   sa"

print(string.strip() == string.rstrip().lstrip() == string.replace(" ", ""))
string.upper()
string.swapcase()
string.lower()
string.casefold()  # same but supports Cyrillic
'abc'.islower()  # 'abc'.isupper()
string.title()  # istitle  # capitalize first letter of each word

"do some\ndo".capitalize()  # "Do some\ndo"
string.split(' ')  # rsplit()  # splitlines()
print(string in string2)  # print(str not in str2)
'a {} b {}'.format(1, 2)  # 'a 1 b 2'
'a {1} b {0} pi {2:.2f} {2:.2f}'.format(1, 2, 3.1415926535)  # 'a 2 b 1 pi 3.14 3.14'
'{a} {b}'.format(a=1, b=2)  # '1 2'
'A\b\110\x49!'  # "HI!"
"abc".center(7, ' ')  # "  abc  "
"abc".endswith('c', 1, 3)  # check if ends with 'c' on [1,3]  # startswith()
"abc".find('c')  # -1 on false  #rfind()
'abc'.index('c')  # error on false  #rindex()
