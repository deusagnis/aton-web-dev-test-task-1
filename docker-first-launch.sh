#!/bin/bash

mkdir "./maria-db"
mkdir "./public/js/dist"

docker-compose up -d
docker-compose exec app npm install
docker-compose exec app npm run build
docker-compose exec app composer update
docker-compose exec app composer run-script migrate
docker-compose exec app composer run-script seed