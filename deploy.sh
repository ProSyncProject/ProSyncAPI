docker build . -t prosync:app
docker pull mariadb:10.4
docker swarm init
docker stack deploy -c docker-compose.yml prosync
