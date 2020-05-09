#!/bin/bash


pid=`ps aux | grep -v grep | grep selenium-server | awk '{print $2}'`
if [ "$pid" != '' ]; then
    echo "Killing Selenium $pid"
    kill -9 $pid
fi


pid=`ps aux | grep -v grep | grep Xvfb | awk '{print $2}'`
if [ "$pid" != '' ]; then
    echo "Killing Xvfb $pid"
    kill -9 $pid
 fi


pid=`ps aux | grep -v grep | grep chromedriver-74 | awk '{print $2}'`
if [ "$pid" != '' ]; then
    echo "Killing chromedriver-74 $pid"
    kill -9 $pid
 fi

pkill -f chrome

