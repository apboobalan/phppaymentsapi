MIGRATE=0;
CREATED=0;
while [ "$CREATED" = 0 ]&&[ "$MIGRATE" = 0 ]; do 
sleep 2;
  CREATED=`docker exec -it payments_web_1 /bin/bash ../migrate.sh | grep -c 'Migration table created successfully.'`;
  MIGRATE=`docker exec -it payments_web_1 /bin/bash ../migrate.sh | grep -c 'Nothing to migrate.'`;
done
docker exec -it payments_web_1 /bin/bash ../setstorageown.sh