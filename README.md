# To install the project, follow the instructions


### 1. Start
Create an empty folder on your desktop.

Open it through IDE.

Open a terminal.

### 2. Clone repository
```
git clone https://github.com/GylkaRoman/Gulica_Roman_practica_fullstack_cineverse.git
```

Go to the folder
```
cd Gulica_Roman_practica_fullstack_cineverse
```

### 3. Start Docker
```
docker-compose up -d --build
```

### 4. Enter container
```
docker exec -it cineverse_app bash
```

Go to the folder
```
cd laravel
```

### 5. Install dependencies to create the .vendor folder
```
composer install
```

### 6. Setup environment
```
cp .env.example .env
```

### 7. Generate app key
```
php artisan key:generate
```
### 8. Generate JWT secret
```
php artisan jwt:secret
```

### 9. Run migrations and seeder with test data
While executing the following commands, may appear "APPLICATION IN PRODUCTION" and "Are you sure you want to run this command / YES / NO"  then use the arrow keys to select yes and press enter.

```
php artisan migrate:fresh --seed
```

### 10. Add rights
```
mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache && chmod -R 777 storage bootstrap/cache && php artisan optimize:clear
```

### 11 Open the project in the browser
Site:
http://localhost:8000

phpMyAdmin:
http://localhost:8080

To enter phpMyAdmin: <br>
user: root <br>
password: root <br>
DB: cineverse

To enter admin panel in page login: <br>
email: admin@cineverse.com<br>
password: admin123<br>
And then in nav menu click button Admin<br>