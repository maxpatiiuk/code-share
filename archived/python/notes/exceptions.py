import random

try:
    if not type('d') is int:
        raise TypeError('do')
    elif random.randrange(0, 1):
        raise Exception('do')
except TypeError:  # NameError (undefined) ValueError # or use bare except
    print("undefined variable")
else:
    print("all good")
finally:
    print("done")
