#!/bin/bash

USERNAME=$1
PRIVATE_KEY=$2
EXTRAVARS=$3

PYTHONUNBUFFERED=1 \
ANSIBLE_FORCE_COLOR=true \
ANSIBLE_HOST_KEY_CHECKING=false \
ANSIBLE_SSH_ARGS='-o UserKnownHostsFile=/dev/null -o ControlMaster=auto -o ControlPersist=60s' \
ansible-playbook \
--private-key=$PRIVATE_KEY \
--user=$USERNAME \
--connection=ssh \
--limit='webservers' \
--inventory-file=webhosts \
--become \
--become-method=sudo \
-e \
"$EXTRAVARS" \
env/deploy.yml
