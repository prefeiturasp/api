Requirements
============

#### Ansible

```
sudo apt-add-repository ppa:ansible/ansible
sudo apt-get update
sudo apt-get install ansible
```

#### Ansistrano

Playbooks to deploy application

```
ansible-galaxy install carlosbuenosvinos.ansistrano-deploy carlosbuenosvinos.ansistrano-rollback
```

#### MongoDB

Playbook to provision database

```
ansible-galaxy install Stouts.mongodb
```

Installation
============

Ensure you have admin access on servers before start installation, and after,
configure and execute next commands.

#### Hosts
Creating a file with the name `webhosts` with a list of hosts (one per line), such as:
```
[webserver]
IP ADDRESS
```

Creating a file with the name `dbhosts` with a list of hosts (one per line), such as:
```
[dbserver]
IP ADDRESS
```

### Servers Provision

#### WebServer
```
sh ./install.sh web USERNAME PRIVATE_KEY "server_name=supermae.dev"
```

#### Database
```
sh ./install.sh db USERNAME PRIVATE_KEY
```

Deployment
==========

```
sh ./deploy.sh USERNAME "PRIVATE_KEY" "database_dsn=mongodb://DATABASE_IP_ADDRESS/"
```

Tests
=====

You can run tests after composer install, executing following command:
```
composer test
```
