# stockpress - task

### Instalation:

##### 1. Clone repository

##### 2. Install frontend packages:

From root folder

```
cd frontend
npm install
```

##### 3. Start containers:

From root folder run

```
docker-compose up -d
```

##### 4. Install backend packages:

From root folder

```
cd app
composer install
```

##### 4. Run database migrations.

From root folder run

```
docker-compose run --rm php artisan migrate
docker-compose run --rm php artisan storage:link
```

or from root folder run

```
docker exec -it  php bash
php artisan migrate
php artisan storage:link
```

##### 5. Open ready project on: http://localhost:3000/
