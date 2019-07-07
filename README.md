# Barcelona is magic
Project to post automatic content to an Instagram account.
This idea is based on this [read](https://medium.com/@chrisbuetti/how-i-eat-for-free-in-nyc-using-python-automation-artificial-intelligence-and-instagram-a5ed8a1e2a10), I recommend it ;)

### Start

    docker network create bcnismagic
    
    docker-compose up --build -d
    
    # Deploy Database

    docker run --rm -ti --network bcnismagic_external -v $PWD/db_postgres:/app -w /app sqitch/sqitch deploy db:pg://$POSTGRES_USER:$POSTGRES_PASSWORD@$POSTGRES_CONTAINER:5432/$POSTGRES_DB
    
### Console commands
    # From /php_posting/src
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app php php_posting php bin/console COMMAND 

### Test
#### Unit testing
    #  From path php/src
    
    docker run --rm -ti -v $PWD:/app -w /app devilbox/php-fpm-7.4 php vendor/bin/phpunit -c phpunit.xml --testsuite Unit

#### Integration testing
    #  From path php/src
    docker network create testing_network
    
    @ TODO: create a db container with structure and data for testing purpose
    
    docker run -d --network testing_network --name testing_db  
    
    @ end TODO:
    
    docker run --rm --network testing_network -ti -v $PWD:/app -w /app adrianet86/php-redis php vendor/bin/phpunit -c phpunit.xml --testsuite Integration
    
    docker rm --force testing_db
    
    docker network rm testing_network