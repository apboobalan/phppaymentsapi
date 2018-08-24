docker-compose down > /dev/null
docker-compose up -d --build
./dockermigrate.sh > /dev/null