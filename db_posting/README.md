### Database Postgres managed by Sqitch
##### Start

    docker pull sqitch/sqitch
    docker run --rm -ti -v ~/projects/devops/postgres/src:/app -w /app sqitch/sqitch --engine pg init devops

##### Deploy 
    # From /db_posting/src
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app sqitch/sqitch deploy db:pg://$DB_USER:DB_PASSWORD@DB_HOST:DB_PORT

##### Revert
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app sqitch/sqitch revert --to 20181118_user_table db:pg://$DB_USER:DB_PASSWORD@DB_HOST:DB_PORT

##### Add new schema

    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app sqitch/sqitch add 20181118_user_table -n 'Add basic user table'
        
##### Dump and restore a backup
    # BACKUP_NAME=date +%Y-%m-%d;

    # Go to path where you want to download the backup

    # Run instruction to dump a backup (replace variables by values from .env file)
    docker run --rm -it --workdir=/postgresql --network=bcnismagic_external --env PGPASSWORD=$POSTGRES_PASSWORD jbergknoff/postgresql-client pg_dump -h postgresql -U $POSTGRES_USER --data-only --disable-triggers -d $POSTGRES_DB > $BACKUP_NAME.sql

    # Find the id of the postgres container

    docker ps | grep postgres

    # Restore the backup
    cat PATH_WHERE_IS_THE_FILE/$BACKUP_NAME.sql | docker exec -i POSTGRES_CONTAINER_ID psql -U $POSTGRES_USER $POSTGRES_PASSWORD
