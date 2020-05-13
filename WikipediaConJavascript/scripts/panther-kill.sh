#!/bin/bash

pid=`ps aux | grep -v grep | grep 9080 | awk '{print $2}'`
if [ "$pid" != '' ]; then
    echo "Killing Panther $pid"
    kill -9 $pid
fi