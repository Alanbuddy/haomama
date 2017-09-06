#!/bin/bash
 
 
#提示“请输入姓名”并等待30秒，把用户的输入保存入变量name中
read -t 30 -p "请输入用户名称:" name
echo -e "\n"
echo "用户名为:$name"
 
#提示“请输入密码”并等待30秒，把用户的输入保存入变量age中，输入内容隐藏
read -t 30 -s -p "请输入用户密码:" age
echo -e "\n"
echo "用户密码为:$age"
 
#提示“请输入性别”并等待30秒，把用户的输入保存入变量sex中，只接受一个字符输入
read -t 30 -n 1 -p "请输入用户性别:" sex
echo -e "\n"
echo "性别为$sex"
