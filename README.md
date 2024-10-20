# Excdev Test Task

## Балансы пользователей

## Требования

- PHP 8.3
- Composer
- Node.js 16+
- NPM
- Docker и Docker Compose

---


## Установка

### 1. Клонируйте репозиторий

```bash
git clone https://github.com/MatthewBozey/excdev-test-task.git
cd excdev-test-task
```

### 2. Установите зависимости

#### Установите зависимости PHP
```bash
composer install
```
#### Установите зависимости Node.js
```bash
npm install
```

### 3. Настройка окружения

Скопируйте .env.example в .env и настройте переменные окружения, такие как параметры базы данных, Redis, и RabbitMQ.

```bash
cp .env.example .env
```
**Не забудьте сгенерировать ключ приложения:**
```bash
php artisan key:generate
```

### 4. Запуск в Docker

Для запуска всех необходимых сервисов (PostgreSQL, Redis, RabbitMQ и приложения) используйте Docker Compose:

```bash
docker-compose up -d --build
```

### 5. Выполнение миграций

После запуска контейнеров выполните миграции базы данных:
```bash
docker-compose exec app php artisan migrate
```

### Команда для создания пользователя

Чтобы создать пользователя, необходимо ввести команду
```bash
php artisan user:create {username} {email} {password}
```

### Команда для создания операции пользователя

Чтобы создать операцию (начисление/списание), необходимо выполнить команду
```bash
php artisan balance:operation
```


### Структура проекта
- `app/` - Основной код приложения
- `database/` - Миграция, сидеры и фабрики базы данных
- `resources/` - Шаблоны Blade, vue и статические ресурсы
- `routes/` - Файлы маршрутизации
- `public/` - Публично доступные файлы
- `docker-compose.yaml` - Конфигурация Docker
