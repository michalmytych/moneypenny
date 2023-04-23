#!/bin/bash

if [[ $(uname) == "Darwin" ]]; then
  top_output=$(top -l 1 -n 10 -stats pid,user,cpu,mem,command | tail +12 | awk '{print "{\"PID\":" $1 ",\"USER\":\"" $2 "\",\"CPU\":\"" $3 "\",\"MEM\":\"" $4 "\",\"COMMAND\":\"" $5 "\"},"}')
else
  top_output=$(top -bn1 | head -n 12 | tail -n +8 | awk '{print "{\"PID\":" $1 ",\"USER\":\"" $2 "\",\"PR\":\"" $3 "\",\"NI\":\"" $4 "\",\"VIRT\":\"" $5 "\",\"RES\":\"" $6 "\",\"SHR\":\"" $7 "\",\"S\":\"" $8 "\",\"CPU\":\"" $9 "\",\"MEM\":\"" $10 "\",\"TIME\":\"" $11 "\",\"COMMAND\":\"" $12 "\"},"}')
fi

top_output="[$top_output"
top_output=${top_output::-1}
top_output+="]"

echo "$top_output"
