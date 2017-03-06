#coding:utf-8
import requests
from bs4 import BeautifulSoup
import urllib
import codecs
import datetime
now=datetime.datetime.now()
hot_type = '2'
hot_date = now.strftime('%Y%m%d')  
# 基本Url
base_url = 'http://news.baidu.com/n?m=rddata&v=hot_word'
hot_type = '0'

parameters = {'type': hot_type,'date':hot_date}

# 获取 JSON 数据
r = requests.get(base_url, params=parameters)
#print(r.url)

hot_words_dict = r.json()

str=[]
# 输出热搜关键词
for hot_word in hot_words_dict.get('data'):
	str.append(hot_word.get('query_word'))
with codecs.open("baidu.txt","a+","utf-8") as f:
	f.write("\r\n".join(str))
str=['baidu']
import os
import codecs
for s in str:
    m=1024*1024
    size =(os.stat(s+".txt").st_size)/m
    if size>50:
        os.remove(s+".txt")
    else:
        obuff = []
        for ln in codecs.open(s+".txt","r","utf-8"):
            if ln in obuff:
                continue
            obuff.append(ln)
        with codecs.open(s+".txt", 'w',"utf-8") as handle:
            handle.writelines(obuff)



