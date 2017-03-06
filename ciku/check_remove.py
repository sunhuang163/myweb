#coding:utf-8
str=['baidu','soso','bing','others']
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

