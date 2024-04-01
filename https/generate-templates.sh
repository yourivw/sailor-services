#!/bin/bash

ME=$(basename $0)

mkdir -p /etc/nginx/templates;

services_env=$(echo ${SSL_SERVICES}|tr -d '\n');
readarray -d ';' -t services <<< "$services_env"
for service in "${services[@]}"; do    
    delim="${service//[^:]}"
    if [ ${#delim} -ne 2 ]; then
        continue;
    fi

    readarray -d ':' -t parts <<< "$service";
    service_host=$(echo ${parts[0]}|tr -d '\n');
    service_port=$(echo ${parts[1]}|tr -d '\n');
    service_ssl_port=$(echo ${parts[2]}|tr -d '\n');

    template_file="/etc/nginx/templates/$service_host.conf.template";
    cp /etc/nginx/stubs/default.conf.stub $template_file;
    sed -i "s/%SERVICE_HOST%/$service_host/g" $template_file;
    sed -i "s/%SERVICE_PORT%/$service_port/g" $template_file;
    sed -i "s/%SERVICE_SSL_PORT%/$service_ssl_port/g" $template_file;

    echo "$ME: Added proxy for service $service_host:$service_port on SSL port $service_ssl_port.";
done