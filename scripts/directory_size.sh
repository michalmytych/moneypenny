#!/bin/bash

# Sprawdź, czy została podana ścieżka jako argument
if [ -z "$1" ]
  then
    echo "Podaj ścieżkę jako argument"
    exit 1
fi

# Sprawdź, czy uruchamiamy skrypt na systemie Linux czy macOS
if [ "$(uname)" == "Linux" ]
then
  # Użyj polecenia du, aby obliczyć rozmiar katalogu podanego jako argument na systemie Linux
  folder_size=$(du -sh "$1" | awk '{print $1}')
elif [ "$(uname)" == "Darwin" ]
then
  # Użyj polecenia du, aby obliczyć rozmiar katalogu podanego jako argument na systemie macOS
  folder_size=$(du -sh "$1" | cut -f 1)
else
  echo "Nieznany system operacyjny"
  exit 1
fi

# Utwórz obiekt JSON i przypisz wartość do zmiennej json_output
json_output=$(printf '{"folder_size": "%s"}' "$folder_size")

# Wyświetl wynik na ekranie
echo "$json_output"
