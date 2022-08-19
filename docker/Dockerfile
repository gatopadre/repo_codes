# GET IMAGE
FROM ubuntu:20.04

# GET UPDATED DEPENDENCIES
RUN apt-get update

# INSTALLING PYTHON
RUN apt-get install -y python3 # to install python

# INSTALLING PIP FOR PYTHON
RUN apt-get install -y python3-pip # to install pip

# INSTALLING GIT
RUN apt-get install -y git

# INSTALLING FLASK
RUN pip install flask

# EXPOSING PORTS
EXPOSE 8080

# CREATING APP DIR
RUN mkdir -p /home/app

# SETTING WORKDIR
WORKDIR /home/app

# COPY CODE
COPY ./source /home/app/

# RUNNING FLASK
CMD [ "python3", "/home/app/main.py" ]
