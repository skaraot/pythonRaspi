#!/usr/bin/env python
# coding=utf-8
from connectDB import connectDB

def main():
    print ("test")
    db = connectDB()
    db.select()

if __name__ == '__main__':
    main()