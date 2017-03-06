import requests
from bs4 import BeautifulSoup
import re

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

	with open(filename,"a") as f:
		f.write("\n".join(str))

url1="http://s.weibo.com/top/summary?cate=realtimehot"
url2="http://s.weibo.com/top/summary?cate=total&key=all"
url3="http://s.weibo.com/top/summary?cate=total&key=films"

getWeiBo(url1,"hot.txt")
getWeiBo(url2,"hot.txt")
getWeiBo(url3,"hot.txt")
