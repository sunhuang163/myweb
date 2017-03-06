#coding:utf-8
import requests
from bs4 import BeautifulSoup
import codecs
url ="http://top.so.com/hotnews/detail"
body = requests.get(url).text
html=BeautifulSoup(body,"html5lib").find_all('a',class_="rankitem__name")
str=[]
for h in html:
    print(h.get_text())
    str.append(h.get_text().strip())

with codecs.open("soso.txt","a+","utf-8") as f:
    f.write("\r\n".join(str))

