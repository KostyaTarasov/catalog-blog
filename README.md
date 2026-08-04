# Каталог + Блог

Сайт: каталог товаров с фильтром и блог.

Всё запускается из Docker.

## Демо

Сайт развёрнут на сервере: [http://194.226.126.238/](http://194.226.126.238/)
Админка: [http://194.226.126.238/admin](http://194.226.126.238/admin)

## Стек

- PHP 8.4-fpm, Laravel 13
- MySQL 9.7, Redis 8 (кэш + сессии)
- Blade + Tailwind CSS 4 + Alpine.js + Vite 8
- Livewire 4 — фильтр каталога
- Filament 5 — админка (`/admin`)
- Pest 4 — тесты

## Локальный запуск

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
```

Затем сгенерировать ключ приложения, накатить миграции с сидами и открыть доступ к загруженным файлам:

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
```


| Адрес                                                      | Что это            |
| ---------------------------------------------------------- | ------------------ |
| [http://localhost:8080](http://localhost:8080)             | сайт               |
| [http://localhost:8080/admin](http://localhost:8080/admin) | админка (Filament) |


Логин в админку создаётся отдельной командой (спросит имя, email и пароль):

```bash
docker compose exec app php artisan make:filament-user
```

Логин: test@yandex.ru
Пароль: 1234