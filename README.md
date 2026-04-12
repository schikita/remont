# Сантехника — лендинг + Filament

Production-ready одностраничный сайт услуг сантехника на **Laravel 11**, **Filament 3**, **Blade**, **SQLite**, **Tailwind CSS**, **Alpine.js**, **Vite**. Админка управляет контентом, SEO, скриптами аналитики, заявками и порядком секций.

## Требования

- PHP 8.3+
- Composer 2
- Node 20+ (для Vite)
- Расширения PHP: `intl`, `pdo_sqlite`, `zip`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` (опционально для изображений)

## Быстрый старт (локально)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Сайт: `http://127.0.0.1:8000`  
Админка: `http://127.0.0.1:8000/admin`

Стили и скрипты Filament попадают в `public/css` и `public/js` при **`composer install` / `composer update`** (скрипт в `composer.json`). Если админка без оформления — выполните вручную: `php artisan filament:assets`.

Учётные данные администратора задаются в `.env`:

- `ADMIN_EMAIL` (по умолчанию `admin@example.com`)
- `ADMIN_PASSWORD` (по умолчанию из сидера `ChangeMe!123` — **смените в продакшене**)

После изменения `.env` для нового пароля выполните:

```bash
php artisan migrate:fresh --seed
```

либо смените пароль через `php artisan tinker` и `Hash::make()`.

## Разработка (dev)

Два терминала:

```bash
php artisan serve
```

```bash
npm run dev
```

Либо `composer run dev` (если настроен concurrently в `composer.json`).

## Миграции

```bash
php artisan migrate
```

Полный сброс БД и демо-данные:

```bash
php artisan migrate:fresh --seed
```

## Продакшен на хостинге (без Docker)

Типичный сценарий: **VPS** или **виртуальный хостинг** с PHP 8.3+ и возможностью указать **корень сайта** в каталог `public` (или «public_html» → симлинк/копия содержимого `public` — лучше настроить веб-сервер на `…/santech/public`).

### 1. На сервере

- Загрузите проект (git clone / архив **без** `node_modules` и без `vendor`, либо с `vendor` после `composer install` на своей машине с той же ОС, что и хостинг — иначе пересоберите на сервере).
- Включите расширения PHP: как в разделе «Требования» (`pdo_sqlite`, `intl`, `mbstring`, и т.д.).
- **Document root** должен указывать на `public/`, не на корень репозитория.

**Nginx** (фрагмент): `root /path/to/santech/public;` и стандартный `try_files $uri $uri/ /index.php?$query_string;` для Laravel.

**Apache**: в каталоге `public` должен работать `mod_rewrite` и `AllowOverride` для `.htaccess` (как в стандартном Laravel).

### 2. Переменные окружения

```bash
cp .env.example .env
php artisan key:generate
```

В `.env` для продакшена:

- `APP_ENV=production`, `APP_DEBUG=false`
- `APP_URL=https://ваш-домен.by` (с протоколом и без слэша в конце)
- `ADMIN_EMAIL`, `ADMIN_PASSWORD` — надёжный пароль
- `DB_CONNECTION=sqlite` и путь к файлу (по умолчанию `database/database.sqlite`) — файл и каталог `database/` должны быть **доступны на запись** веб-серверу
- при необходимости почты: `MAIL_*` вместо `log`

Если хостинг **запрещает SQLite** или не даёт писать в `database/`, переключите на MySQL: раскомментируйте блок `DB_*` в `.env`, выполните `php artisan migrate --force`.

### 3. Зависимости и сборка фронта

На сервере (или локально перед выкладкой, если на хостинге нет Node):

```bash
composer install --no-dev --optimize-autoloader
```

Фронт (Vite):

```bash
npm ci
npm run build
```

В репозитории должны попасть артефакты в `public/build/` (или соберите на сервере, если есть Node 20+).

### 4. База и кэш Laravel

```bash
touch database/database.sqlite   # если файла ещё нет
php artisan migrate --force
php artisan db:seed --force      # только при первом деплое, если нужны демо-данные и админ из сидера
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Права (Linux): каталоги `storage/` и `bootstrap/cache/` — запись для пользователя PHP (часто `www-data`).

### 5. Очереди и cron

В проекте по умолчанию `QUEUE_CONNECTION=database`; если фоновые задачи не настроены, критичных очередей для лендинга обычно нет. Если позже появятся отложенные задачи — на сервере нужен постоянный `php artisan queue:work` (supervisor/systemd) или хостинг с «воркером очередей».

Планировщик Laravel (`schedule:run`) в `routes/console.php` не настроен — отдельный cron не обязателен.

### 6. После обновлений кода

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm run build   # при изменении фронта
php artisan optimize:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Docker (опционально, для локальной разработки)

Сборка и запуск (порт `8080`):

```bash
docker compose build
docker compose up -d
```

Перед первым запуском задайте `ADMIN_PASSWORD` в окружении хоста или в `docker-compose.yml`. При старте контейнера выполняются миграции и `storage:link`. Для **продакшена на хостинге** используйте раздел выше, Docker не обязателен.

## Архитектура (кратко)

- **Тонкие контроллеры**: `LandingController`, `LeadController`, `QuizController`, `PolicyPageController`, `SitemapController`, `RobotsController`.
- **Сервисы**: `LandingPageService`, `SeoService`, `JsonLdService`, `LeadSubmissionService`, `ScriptSettingsRenderer`.
- **Form Request**: `StoreLeadRequest`, `QuizCalculateRequest`.
- **Политики**: `LeadPolicy` (доступ в Filament для админов).
- **JSON-LD**: `JsonLdService` (Organization, PlumbingService как LocalBusiness-подтип, Offer, FAQPage, Review, AggregateRating при ≥2 отзывах).
- **Filament**: ресурсы для контента и настроек, виджет статистики заявок, `noindex` для панели.

## Публичные маршруты

| Метод | Путь              | Назначение              |
|-------|-------------------|-------------------------|
| GET   | `/`               | Лендинг                 |
| POST  | `/leads`          | Приём заявок (JSON)   |
| POST  | `/quiz/calculate` | Подсчёт квиза (JSON)  |
| GET   | `/policy/{slug}`  | Юридические страницы   |
| GET   | `/sitemap.xml`    | Карта сайта            |
| GET   | `/robots.txt`     | robots.txt             |

## Filament

- **Resources**: заявки, услуги, преимущества, этапы, галерея, отзывы, FAQ, политики, секции, соцсети, квиз (вопросы + варианты, результаты), настройки (брендинг, контакты, SEO, скрипты), Hero, О компании.
- **Pages**: стандартный Dashboard.
- **Widgets**: `LeadStatsOverview`, `AccountWidget`.

## Безопасность форм

CSRF, honeypot-поле `website`, throttling (`leads`: 8/мин/IP, `quiz`: 30/мин/IP), серверная валидация, клиентский вывод ошибок Alpine.

## Лицензия

MIT (как у Laravel skeleton). Замените демо-тексты, контакты и домены перед продакшеном.
