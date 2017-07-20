#!/usr/bin/env python
# coding=utf-8
import mysql
import random
import mysql.connector
from mysql.connector import Error

class connectDB(object):
    __instance = None

    __session = None
    __connection = None

    __host = None
    __user = None
    __password = None
    __database = None

    def __new__(cls, *args, **kwargs):
        if not cls.__instance:
            cls.__instance = super(connectDB, cls).__new__(cls, *args, **kwargs)
        return cls.__instance

    def __init__(self, host='localhost', user='root', password='', database='test'):
        self.__host = host
        self.__user = user
        self.__password = password
        self.__database = database

    def baglan(self):
        try:
            cnx = mysql.connector.connect(host=self.__host, database=self.__database, user=self.__user, password=self.__password,connect_timeout=2000,buffered=True)
            self.__connection = cnx
            self.__session = cnx.cursor()

            if self.__connection.is_connected():
                print("baglanti OK!")
            """
                id = random.randrange(1, 101, 2)
                print (id)
                #self.insert(id, "ethem", "oneki")
                #self.select()
                self.__connection.close()
            """
        except Error as e:
            print(e)

    def kopar(self):
        self.__connection.close()
        self.__session.close()

    def select(self, *args):
        try:
            result = None
            self.baglan()
            query = "select * from turtud"
            print(query)
            self.__session.execute(query)
            rows = self.__session.fetchall()

            for row in rows:
                #print row
                print str(row[2])
                #print "%s %s %s" % (row["id"], row["kul_ad"], row["yorum"])

            self.__connection.commit()

        except Error as e:
            print(e)
"""
    def insert(self, iid, kul_ad, yorum):
        conn = self.baglan()
        try:
            cursor = conn.cursor()
            insert = "insert into turtud (iid, kul_ad, yorum) values (%s,%s,%s)"
            addon = (iid, kul_ad, yorum)

            cursor.execute(insert,addon)
            if cursor.lastrowid:
                print('last insert id', cursor.lastrowid)
            else:
                print('last insert id not found')

            conn.commit()
        except Error as e:
            print(e)
        finally:
            cursor.close()
"""