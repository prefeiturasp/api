#!/bin/bash

USERNAME=$2
PRIVATE_KEY=$3
EXTRAVARS=$4

case "$1" in
    "db")
        PYTHONUNBUFFERED=1 \
        ANSIBLE_FORCE_COLOR=true \
        ANSIBLE_HOST_KEY_CHECKING=false \
        ANSIBLE_SSH_ARGS='-o UserKnownHostsFile=/dev/null -o ControlMaster=auto -o ControlPersist=60s' \
        ansible-playbook \
        --private-key=$PRIVATE_KEY \
        --user=$USERNAME \
        --connection=ssh \
        --limit='dbservers' \
        --inventory-file=dbhosts \
        --become \
        --become-method=sudo \
        "$(pwd)/env/install-dbservers.yml"
        ;;
    "web")
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
        -e "$EXTRAVARS" \
        "$(pwd)/env/install-webservers.yml"
        ;;
    "*")
        echo "Usage: $NAME {db|web}" >&2
        exit 3
        ;;
esac