#!/bin/bash

if [ -z "$1" ]
  then
    echo "Podaj ścieżkę jako argument"
    exit 1
fi

if [ "$(uname)" == "Linux" ]
then
  folder_size=$(du -sh "$1" | awk '{print $1}')
elif [ "$(uname)" == "Darwin" ]
then
  folder_size=$(du -sh "$1" | cut -f 1)
else
  echo "Nieznany system operacyjny"
  exit 1
fi

json_output=$(printf '{"folder_size": "%s"}' "$folder_size")

echo "$json_output"
