## Description
The project have two parts.
1) Activity service - save website activities in database, and return activity statistics using json-rpc API. Json-RPC endpoints explained in config/service.yaml file.
2) Landing - website that send own activities in every webpages hits. Stack: **Symfony 6**, **RabbitMq**.
## Steps to install
    1. make build   
    2. make migration (choose [yes])
## Start project
    make up
## Hosts
Add hosts to the /etc/hosts/. <br/>
For example:<br/>

    192.168.240.4   landing.test        
    192.168.240.4   activity.test         