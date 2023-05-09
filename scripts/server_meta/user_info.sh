#!/bin/bash

if [[ "$(uname)" == "Darwin" ]]; then
    username=$(whoami)
    uid=$(id -u)
    gid=$(id -g)
    groups=$(id -Gn | tr ' ' ,)
    home=$(dscl . -read /Users/"$USER" NFSHomeDirectory | awk '{print $NF}')
    shell=$(dscl . -read /Users/"$USER" UserShell | awk '{print $NF}')
elif [[ "$(uname)" == "Linux" ]]; then
    username=$(whoami)
    uid=$(id -u)
    gid=$(id -g)
    groups=$(id -Gn | tr ' ' ,)
    home=$(getent passwd "$USER" | cut -d ':' -f 6)
    shell=$(getent passwd "$USER" | cut -d ':' -f 7)
fi

echo "{\"username\":\"$username\",\"uid\":$uid,\"gid\":$gid,\"groups\":\"$groups\",\"home\":\"$home\",\"shell\":\"$shell\"}"
