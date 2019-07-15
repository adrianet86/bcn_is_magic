### PHP Posting
Service to get images from different providers and store them.
Process images to rank or discard to finally post it to IG.

### TODO:
+ ~~Discard image in recollect service by aspect ratio and/or resize to desired aspect ratio.~~
+ ~~Use AWS S3 to storage images.~~ 
+ Add more unit tests and create new integration tests.
+ Add captions in spanish and catalan.
+ Add more hashtags and tags.
+ Improve image cleaner.
+ Integrate more image providers.
+ Rate picture based on metadata and tags ¿?.
+ Check existing image tags with our tags.
+ Travis CI.

### Install 
    # From /php_posting/src
        
    docker run --rm -ti -v $PWD:/app -w /app composer composer install --ignore-platform-reqs

### Console commands
##### Run command
    # From /php_posting/src
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app php_posting php bin/console COMMAND 
    
##### Command list
* recollect-images 
* clean-images 
* post-image 

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