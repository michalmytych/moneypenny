#!/bin/bash

if [[ "$OSTYPE" == "linux-gnu"* ]]; then
  # Linux
  disk_free=$(df -h --output=avail / | awk 'NR==2{print $1}')
elif [[ "$OSTYPE" == "darwin"* ]]; then
  # OSx
  disk_free=$(df -h -P / | awk 'NR==2{print $4}')
else
  echo "Nieobsługiwany system operacyjny"
  exit 1
fi

echo "{\"disk_free\":\"$disk_free\"}"
