# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # base box
  config.vm.box = "chef/ubuntu-14.04"

  # machine configuration
  # config.vm.provider "virtualbox" do |v|
  #   v.memory = 1024
  #   v.gui = true
  # end

  # provision
  config.vm.provision :shell, path: "bootstrap.sh"

  # http port
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # make application folder writable by web server
  config.vm.synced_folder "./", "/vagrant",
    owner: "vagrant",
    group: "www-data",
    mount_options: ["dmode=775,fmode=664"]

end
