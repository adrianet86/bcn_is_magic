# Barcelona is magic
Project to post automatic content to an Instagram account.
This idea is based on this [read](https://medium.com/@chrisbuetti/how-i-eat-for-free-in-nyc-using-python-automation-artificial-intelligence-and-instagram-a5ed8a1e2a10), I recommend it ;)

### Start

    docker network create bcnismagic_external
    
    cp .env.example .env
    
    # Replace DB_PASSWORD value from .env file 
    
    docker-compose up --build -d
    
    # Deploy Database

    docker run --rm -ti --network bcnismagic_external -v $PWD/db_postgres/src:/app -w /app sqitch/sqitch deploy db:pg://$POSTGRES_USER:$POSTGRES_PASSWORD@$POSTGRES_CONTAINER:5432/$POSTGRES_DB
    
    # Install libraries php_posting service
    
    docker run --rm -ti -v $PWD/php_posting/src:/app -w /app composer composer install --ignore-platform-reqs
    
    # From /php_posting/src
    # Create new environment files and replace value of vars
    
    cp .env.example .env
    
    cp .env.dev .env.prod

#### Documentation
Each service has it own documentation in a README.md file on root path.

[DB_Postgres](/db_postgres/README.md)

[PHP Posting](/php_posting/README.md)

#### TODO
+ ~~Deploy on AWS.~~
+ ~~Cron jobs.~~
    + ~~Recollect images.~~
    + ~~Clean images.~~
    + ~~Post image.~~
+ Automatic deploy on AWS on github master branch change.
* AWS VPN server to connect to DB.
* Documentation AWS steps.