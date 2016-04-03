#!/usr/bin/env bash

### Update Repositories
##sudo apt-get update
##
### Determine Ubuntu Version
##. /etc/lsb-release
##
### Decide on package to install for `add-apt-repository` command
###
### USE_COMMON=1 when using a distribution over 12.04
### USE_COMMON=0 when using a distribution at 12.04 or older
##USE_COMMON=$(echo "$DISTRIB_RELEASE > 12.04" | bc)
##
##if [ "$USE_COMMON" -eq "1" ];
##then
##    sudo apt-get install -y software-properties-common
##else
##    sudo apt-get install -y python-software-properties
##fi
##

# Add Ansible Repository & Install Ansible
#sudo add-apt-repository -y ppa:ansible/ansible
#sudo apt-get update
#sudo apt-get install -y ansible

yum install wget
wget dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
rpm -ivh epel-release-6-8.noarch.rpm

sudo yum install -y ansible


# Setup Ansible for Local Use and Run
cp /opt/fcb/cp/vagrant/ansible/inventories/dev /etc/ansible/hosts -f
chmod 666 /etc/ansible/hosts
cat /opt/fcb/cp/vagrant/ansible/files/authorized_keys >> /home/vagrant/.ssh/authorized_keys
sudo ansible-playbook /opt/fcb/cp/vagrant/ansible/play-book.yml -e hostname=$1 --connection=local
