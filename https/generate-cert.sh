#!/bin/bash

curl -JLO "https://dl.filippo.io/mkcert/latest?for=linux/amd64"
chmod +x mkcert-v*-linux-amd64
cp mkcert-v*-linux-amd64 /usr/local/bin/mkcert

mkdir -p /etc/nginx/certs/

ME=$(basename $0)
KEY=/etc/nginx/certs/private.pem
CERT=/etc/nginx/certs/certificate.pem

export CAROOT=/etc/nginx/CA && mkcert -install && mkcert -key-file $KEY -cert-file $CERT $APP_SERVICE *.$APP_SERVICE localhost 127.0.0.1 $CERT_DOMAINS
echo "$ME: Server certificate has been generated."