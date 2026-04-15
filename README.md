# Разворот проекта

## копируем env файл

```bash
cp .env.example .env
```

## Если необходим .htaccess

```bash
cp public/.htaccess.example public/.htaccess
```

## устанавливаем переменные окружения
### Указываем свободные порты для следующих директив:
```
APP_PORT=
VITE_PORT=
FORWARD_DB_PORT=
FORWARD_REDIS_PORT=
FORWARD_TYPESENSE_PORT=
FORWARD_MAILPIT_PORT=
FORWARD_MAILPIT_DASHBOARD_PORT=
FORWARD_PMA_PORT=
```

### Указываем WWWUSER равный пользователю на реальном ПК
```
WWWUSER=laravel
```

## устанавливаем бекэнд зависимости
```bash
composer install --ignore-platform-reqs
```

## Запускаем docker контейнеры
```bash
./vendor/bin/sail up -d 
```

## Выполняем команду
```bash
./vendor/bin/sail php artisan key:generate &&
./vendor/bin/sail php artisan storage:link &&
./vendor/bin/sail php artisan migrate --seed
```



## Prerender
```
php artisan inertia:start-ssr
php artisan inertia:stop-ssr
```

## Swagger
Документация: [/api/documentation]
```
php artisan l5-swagger:generate
```
## Тесты
```bash
./vendor/bin/sail artisan test
```
