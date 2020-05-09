#!/bin/bash

ps cax | grep -v grep | grep Xvfb > /dev/null
if [ $? -ne 1 ]; then
    echo "Xvfb Process is running."
else
    echo "Starting Xvfb Process ..."
    sudo Xvfb :10 -ac &
fi

export DISPLAY=:10

ps cax | grep -v grep | grep selenium-server > /dev/null
if [ $? -ne 1 ]; then
    echo "Selenium Process is running."
else

    scriptdir=`dirname "$BASH_SOURCE"`
    jarFolder="$PWD/"$scriptdir"/../bin/"
    echo "Starting Selenium Process ... ($jarFolder)"

    java -Dwebdriver.chrome.driver=/usr/local/bin/chromedriver -Dwebdriver.chrome.whitelistedIps="127.0.0.1" -jar ./bin/selenium-server-standalone-3.141.59.jar &
fi