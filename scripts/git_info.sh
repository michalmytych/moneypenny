#!/bin/bash

# check if git is installed
if ! command -v git &> /dev/null
then
    echo "Error: git is not installed"
    exit 1
fi

# get repository root directory
root=$(git rev-parse --show-toplevel)

# get branch name
branch=$(git rev-parse --abbrev-ref HEAD)

# get last commit hash and message
commit_hash=$(git rev-parse --short HEAD)
commit_msg=$(git log -1 --pretty=format:"%s")

# get remote repository URL
remote=$(git config --get remote.origin.url)

# get current user's name and email
user_name=$(git config user.name)
user_email=$(git config user.email)

# format output as JSON
echo "{\"root\":\"$root\",\"branch\":\"$branch\",\"commit_hash\":\"$commit_hash\",\"commit_msg\":\"$commit_msg\",\"remote\":\"$remote\",\"user_name\":\"$user_name\",\"user_email\":\"$user_email\"}"
