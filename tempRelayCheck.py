#!/usr/bin/env python
# coding=utf-8

import RPi.GPIO as GPIO
from connectDB import connectDB
from sicaklik import sicaklik

def main():
    veri = connectDB()
    sicaklik = veri.select('select deger from setsicaklik')

    for xes in sicaklik:
        data = xes[0]
    print (data)

if __name__ == '__main__':
    main()

