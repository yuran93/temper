# Temper Assignment

## Building and started the docker container

```shell
docker-compose up
```

## Accessing the stuff
- API: localhost:8000
- WEB: localhost:8080

## Work done.
Main work that I've done related to backend can be found at.
- api/app/Services
- api/app/Repositories
- api/app/Http/Controllers
- api/app/Models

Main work that I've done related to backend can be found at.
- web/src/views

## Unit testing

Run following to get into api container
```shell
docker-compose exec api bash
```

Run following to execute PhpUNIT
```shell
vendor/bin/phpunit
```

PS: There was a CORS issue with connecting FE to backend locally so I went and host the api code in my VPS at http://temper.sugarcodex.com