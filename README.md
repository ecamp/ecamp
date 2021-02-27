This is version 2.0 of eCamp

Contact:
Pirmin Mattmann <forte@musegg.ch>
Urban Suppiger <smiley@pfadiluzern.ch>


# Setup development environment

## Prerequisites
- Git [CLI](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) or [GUI](https://desktop.github.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop) (Windows/Mac) or [Docker compose](https://docs.docker.com/compose/install/) (Linux)

## Installation steps

1. git clone https://github.com/ecamp/ecamp.git
2. cd ecamp && cd dev
3. docker-compose up
4. Visit https://localhost:8080 to open PhpMyAdmin  
   login with user `ecamp2` and password `ecamp2`  
   import  `.database/ecamp_full_db.sql` into `ecamp2_dev` database
5. Visit https://localhost. Happy developing! :smile: