#!/bin/bash

# Sprawdź, czy bieżący system to macOS
if [[ $(uname) == "Darwin" ]]; then
  # Jeśli tak, uruchom polecenie top z opcjami, które wyświetlają tylko podstawowe informacje
  top_output=$(top -l 1 -n 10 -stats pid,user,cpu,mem,command | tail +12 | awk '{print "{\"PID\":" $1 ",\"USER\":\"" $2 "\",\"CPU\":\"" $3 "\",\"MEM\":\"" $4 "\",\"COMMAND\":\"" $5 "\"},"}')
else
  # W przeciwnym razie, uruchom polecenie top z opcjami, które wyświetlają tylko podstawowe informacje
  top_output=$(top -bn1 | head -n 12 | tail -n +8 | awk '{print "{\"PID\":" $1 ",\"USER\":\"" $2 "\",\"PR\":\"" $3 "\",\"NI\":\"" $4 "\",\"VIRT\":\"" $5 "\",\"RES\":\"" $6 "\",\"SHR\":\"" $7 "\",\"S\":\"" $8 "\",\"CPU\":\"" $9 "\",\"MEM\":\"" $10 "\",\"TIME\":\"" $11 "\",\"COMMAND\":\"" $12 "\"},"}')
fi

# Dodaj początkowy nawias kwadratowy
top_output="[$top_output"

# Usuń przecinek z końca outputu i zamień go na zamykający nawias klamrowy
top_output=${top_output::-1}
top_output+="]"

# Wyświetl output jako poprawny obiekt JSON
echo "$top_output"
