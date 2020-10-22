my_type = 1

# 1  y = ax2
# 2  y = v/t
# 3  y = ir
# 4  y = 1/2*mr2
# 5  y = mx+b
# 6  y = ax**0.5

if(my_type == 1):
  a = 0.1
  x = 4
  da = 0.5
  dx = 0.8
  print((((x**2)*da)**2+(2*a*x*dx)**2)**0.5)
elif(my_type == 2):
  v = 8.7
  t = 8.5
  dv = 0.6
  dt = 1.8
  print(((dv/t)**2+(-v*dt/(t**2))**2)**0.5)
elif(my_type == 3):
  i = 5.3
  r = 42.2
  di = 0.2
  dr = 0.3
  print(((r*di)**2+(i*dr)**2)**0.5)
elif(my_type == 4):
  m = 7.34
  r = 18.34
  dm = 0.03
  dr = 0.39
  print(((r*r/2*dm)**2+(dr*m*r)**2)**0.5)
elif(my_type == 5):
  m = 4
  x = 0.8
  b = 2.4
  dm = 0.1
  dx = 0.2
  db = 0.6
  print(((x*dm)**2+(m*dx)**2+(db)**2)**0.5)
elif(my_type == 6):
  a = 2
  x = 1.3
  da = 0.2
  dx = 0.7
  print((((x**5)*da)**2+(dx*a/(2*(x**0.5)))**2)**0.5)