#!/bin/bash

if [[ "$(uname)" == "Darwin" ]]; then
    ipv4=$(ifconfig en0 | grep inet | awk '$1=="inet" {print $2}')
    ipv6=$(ifconfig en0 | grep inet6 | awk '$1=="inet6" {print $2}')
    gateway=$(route -n get default | grep gateway | awk '{print $2}')
elif [[ "$(uname)" == "Linux" ]]; then
    ipv4=$(ip addr show | grep -E "inet\s" | awk '{print $2}' | cut -d'/' -f1 | head -n1)
    ipv6=$(ip addr show | grep -E "inet6\s" | awk '{print $2}' | cut -d'/' -f1 | head -n1)
    gateway=$(ip route show | grep "default via" | awk '{print $3}')
fi

echo "{\"ipv4\":\"$ipv4\",\"ipv6\":\"$ipv6\",\"gateway\":\"$gateway\"}"
