import threading
import random

def setInterval(func,time):
    e = threading.Event()
    while not e.wait(time):
        func()

def repeatFunction():
    adlar = ["serkan", "ozlem", "sebnem", "zeynep", "zehra", "gokhan", "umit", "yagmur", "nuray"]

    print "Merhaba %s" % adlar[random.randint(0,8)]

if __name__ == '__main__':
    setInterval(repeatFunction,5)