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
```
php artisan migrate --seed
```

### 10 Open the project in the browser
Site:
http://localhost:8000

phpMyAdmin:
http://localhost:8080

user: root <br>
password: root <br>
DB: cineverse