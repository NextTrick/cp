# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    
    config.vm.box = "nrel/CentOS-6.5-x86_64"
    config.vm.hostname = "CENTOS65-cp-ZEND"
    config.vm.boot_timeout = 120

    config.vm.network "private_network", ip: "192.168.56.21"
    #config.vm.synced_folder "D:\\xampp\\htdocs\\cp", "/opt/fcb/cp" #Change local project path
    config.vm.synced_folder "/Users/NextTrick/Projects/cp", "/opt/fcb/cp" 
    #config.vm.synced_folder "./", "/opt/fcb", type: "nfs"

    config.vm.provider "virtualbox" do |vb|
        vb.memory = 2048
        vb.cpus = 2
    end

    config.vm.provision :shell, path: "vagrant/ansible/script.sh", args: ["default"]

#    config.vm.provision "ansible" do |ansible|
#        ansible.playbook = "vagrant/provision/install.yml"
#        ansible.host_key_checking = false
#        ansible.sudo = true
#        ansible.tags = ['common']
#    end
    
#    config.vm.network "forwarded_port", host: 8080, guest: 80, auto_correct: true
#    config.vm.network "forwarded_port", host: 8081, guest: 8080, auto_correct: true
    
end


