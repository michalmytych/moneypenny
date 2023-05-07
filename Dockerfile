FROM ubuntu:latest
LABEL authors="mike"

ENTRYPOINT ["top", "-b"]
