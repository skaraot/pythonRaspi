from threading import Timer


def hello():
    print "merhaba Sam"

def main():
    print "Basladi"
    t = Timer(30.0, hello)
    t.start()

if __name__ == '__main__':
    main()

