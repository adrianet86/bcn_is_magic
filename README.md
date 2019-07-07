# Barcelona is magic
Project to post automatic content to an Instagram account.
This idea is based on this [read](https://medium.com/@chrisbuetti/how-i-eat-for-free-in-nyc-using-python-automation-artificial-intelligence-and-instagram-a5ed8a1e2a10), I recommend it ;)

### Start

    docker network create bcnismagic
    
    docker-compose up --build -d
    
    # Deploy Database

    docker run --rm -ti --network bcnismagic_external -v $PWD/db_postgres:/app -w /app sqitch/sqitch deploy db:pg://$POSTGRES_USER:$POSTGRES_PASSWORD@$POSTGRES_CONTAINER:5432/$POSTGRES_DB

#### Documentation
Each service has it own documentation in a README.md file on root path.

[DB_Postgres](/db_postgres/README.md)

[PHP Posting](/php_posting/README.md)
