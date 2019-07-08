### PHP Posting
Service to get images from different providers and store them.
Process images to rank or discard to finally post it to IG.

### Console commands
##### Run command
    # From /php_posting/src
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app php php_posting php bin/console COMMAND 
    
##### Command list
* recollect-images 
* clean-images 

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