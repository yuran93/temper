# Temper Assignment

## Building and starting the docker container

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

Main work that I've done vuejs can be found at.
- web/src/views

## Unit testing

Run following to get into api container.
```shell
docker-compose exec api bash
```

Run following to inside the container.
```shell
vendor/bin/phpunit
```

## API documentation

Accessing the chart data from weekly retention curves.
```shell
GET: localhost:8000/api/weekly-retention
```

| Parameter  | Description                         | Mandatory |
|------------|-------------------------------------|-----------|
| start_date | Start date for the searching period | yes       |
| end_date   | End date fro the searching period   | yes       |

Success Response
```json
{
    "data": {
        "title": {},
        "xAxis": {},
        "yAxis": {},
        "legend": {},
        "plotOptions": {},
        "series": [],
        "responsive": {}
    },
    "success": true,
    "status": 200
}
```
Failed Response
```json
{
    "success": false,
    "message": ...,
    "status": 500
}
```

PS: There was a CORS issue with connecting FE to backend locally so I went and host the api code in my VPS at http://temper.sugarcodex.com