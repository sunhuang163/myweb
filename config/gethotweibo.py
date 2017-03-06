#coding:utf-8
import requests
from bs4 import BeautifulSoup
import re
import codecs

def getWeiBo(url,filename):
	# url ='http://s.weibo.com/top/summary?cate=realtimehot'
	user_agent = 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT)'  
	headers = { 'User-Agent' : user_agent } 
	r=requests.get(url,headers=headers)
	html=r.text
	soup = BeautifulSoup(html,"html5lib")
	str=[]
	for tag in soup.find_all(href=re.compile("Refer=top"),target="_blank"):
		if tag.string is not None:
			print(tag.string)  
			str.append(tag.string)

	with codecs.open(filename,"a+","utf-8") as f:
		f.write("\n".join(str))

url1="http://s.weibo.com/top/summary?cate=realtimehot"
url2="http://s.weibo.com/top/summary?cate=total&key=all"
url3="http://s.weibo.com/top/summary?cate=total&key=films"

getWeiBo(url1,"hot.txt")
getWeiBo(url2,"hot.txt")
getWeiBo(url3,"hot.txt")


#coding:utf-8
str=['hot']
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
