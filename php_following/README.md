### PHP Following
Service to growing my following.

### Install 
    # From /php_following/src
        
    docker run --rm -ti -v $PWD:/app -w /app composer composer install --ignore-platform-reqs

### Config
    # From /php_following/src
    # Create new environment files and replace value of vars
    
    cp .env.example .env
    
    cp .env.dev .env.prod

### Console commands
##### Run command
    # From /php_following/src
    
    docker run --rm -ti --network bcnismagic_external -v $PWD:/app -w /app php_following php bin/console COMMAND 
    
##### Command list
* recollect-accounts 

