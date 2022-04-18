## About

This is a private demo API application developed for Imara Software Solutions flutter class personal expense project.

## Features
CRUD for daily expenses and get summary for last 7 days

## Installation

```bash
composer install
cp .env.example .env OR copy .env.example .env
php artisan key:generate
```

- Create database and update the database credentials on .env file

```bash
php artisan migrate --seed
```

## Usage
### List expenses
    GET /api/expenses?page=1 HTTP/1.1

### Get expense
    GET /flutter_api/public/api/expenses/{expense-id} HTTP/1.1

### Add new expense
    POST /api/expenses HTTP/1.1
    Content-Type: application/json
    {
        "date": "2022-04-18",
        "title": "Transport",
        "amount": 99.99
    }

### Update existing expense
    PUT /flutter_api/public/api/expenses/{expense-id} HTTP/1.1
    Content-Type: application/json
    {
        "date": "2022-04-19",
        "title": "Food",
        "amount": 99.99
    }

### Delete expense
    DELETE /flutter_api/public/api/expenses/{expense-id} HTTP/1.1

### Get summary of last 7 days expense
    GET /flutter_api/public/api/expenses/summary HTTP/1.1
