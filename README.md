# Laravel Product API (Test Task)

REST API на Laravel 12 для товаров, комментариев и истории покупок.
Проект запускается в Docker (`nginx + php-fpm + MariaDB`).

## Реализовано

- Регистрация и логин пользователей (Sanctum token).
- CRUD категорий и товаров (создание/изменение/удаление для `admin`).
- Комментарии к товарам (просмотр для всех, добавление/изменение/удаление для авторизованных).
- Фильтры товаров: категория, диапазон цен, сортировка по цене и популярности.
- История покупок пользователя (`orders`), доступная роли `user`.
- Seed-данные для быстрой демонстрации API.

## Технологии

- PHP 8.3
- Laravel 12
- MariaDB 11
- Docker + Docker Compose
- Laravel Sanctum

## Быстрый запуск в Docker

1. Скопировать окружение:

```bash
cp .env.example .env
```

2. Обновить переменные БД в `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

3. Поднять контейнеры:

```bash
docker compose up -d --build
```

4. Установить зависимости и подготовить приложение:

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

5. Приложение доступно по адресу:

- `http://localhost:8080`

## Тестовые пользователи (из сидов)

- `admin@example.com` / `password` (роль `admin`)
- `user@example.com` / `password` (роль `user`)

## Аутентификация

### Регистрация

- `POST /api/register`

```json
{
  "name": "Ivan Petrov",
  "email": "ivan@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Логин

- `POST /api/login`

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

Ответ содержит `token`. Дальше использовать:

```text
Authorization: Bearer <token>
```

### Логаут

- `POST /api/logout` (требует Bearer token)

## API Эндпоинты

## 1) Категории

- `GET /api/categories` - список
- `GET /api/categories/{id}` - одна категория
- `POST /api/categories` - создать (`admin`)
- `PUT /api/categories/{id}` - обновить (`admin`)
- `DELETE /api/categories/{id}` - удалить (`admin`)

## 2) Товары

- `GET /api/products` - список
- `GET /api/products/{id}` - один товар
- `POST /api/products` - создать (`admin`)
- `PUT /api/products/{id}` - обновить (`admin`)
- `DELETE /api/products/{id}` - удалить (`admin`)

Фильтры для списка товаров:

- `category_id` - фильтр по категории
- `min_price` - минимальная цена
- `max_price` - максимальная цена
- `sort`:
  - `popular`
  - `price` или `price_asc`
  - `price_desc`
- `per_page` - пагинация

Пример:

`GET /api/products?category_id=1&min_price=10&max_price=300&sort=popular&per_page=10`

## 3) Комментарии

- `GET /api/products/{product}/comments` - комментарии товара
- `GET /api/comments/{comment}` - один комментарий
- `POST /api/products/{product}/comments` - добавить (`auth`)
- `PUT /api/comments/{comment}` - обновить (`auth`, автор или admin)
- `DELETE /api/comments/{comment}` - удалить (`auth`, автор или admin)

Пример создания комментария:

- `POST /api/products/1/comments`

```json
{
  "text": "Excellent product, recommend it."
}
```

## 4) История покупок

- `GET /api/orders` - список заказов текущего пользователя (`user`)
- `GET /api/orders/{id}` - один заказ текущего пользователя (`user`)

## Сиды

Добавлены сиды:

- `UsersSeeder`
- `CategoriesSeeder`
- `ProductsSeeder`
- `CommentsSeeder`
- `OrdersSeeder`

Запуск отдельно:

```bash
docker compose exec app php artisan db:seed
```

## Полезные команды

Очистить БД и заново заполнить:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Остановить контейнеры:

```bash
docker compose down
```

Остановить и удалить volume БД:

```bash
docker compose down -v
```
