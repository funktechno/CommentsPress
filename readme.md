![Logo](./images/site/logo.png)

# CommentsPress — Comments Administration (PHP)

> A lightweight, open-source PHP application for managing comments. Jamstack-friendly and easy to self-host.

## Quick start

1. Start a simple PHP server for local testing:

```bash
php -S 127.0.0.1:8000
# then open http://localhost:8000 in your browser
```

2. Ensure you have a running MySQL instance. You can use Docker:

```bash
# MySQL 5.7
docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:5.7.29
# or an ARM-compatible image
docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d arm64v8/mysql:8
```

3. Import the schema and (optionally) dummy data:

```bash
# Run the schema first (be careful not to overwrite an existing DB)
mysql -u root -p < sql/acme-db.sql
# Optional: import dummy data
mysql -u root -p < sql/acme-data.sql
```

Notes:
- If your schema doesn't match, update table columns manually.
- Tables used include: `users`, `comments`, `pages`, `contactForms`, `configuration`.

## Configuration & deployment

1. Copy the connections template and edit database/mail/JWT settings:

```bash
cp ./config/connections-backup.php ./config/connections.php
# edit ./config/connections.php with your DB and mail settings
```

  * verify db connection working http://localhost:8000/?action=bootstrap

2. Mail provider

- Copy `mailConfig-back.php` to `mailConfig.php` in `mail/` and configure.
- If you use SendGrid, you can copy `library/mailFunctions-sendGrid.php` to `library/mailFunctions.php`.

3. Files to deploy

Copy the project files to your host, excluding the `assets`, `rest`, and `mail` folders if you plan different deployment strategies. Adjust file ownership and permissions for your web server.

4. Admin access

Register a new account or use an existing one. To grant admin access, set `clientLevel` >= 2 for the user in the `users` table.

## Testing

Install dependencies and run tests:

```bash
composer install
php tests/initialize.php   # uncomment resetDb() when you want tests to reset the DB
./vendor/bin/phpunit
# or on Windows: .\vendor\bin\phpunit
```

To run a single test class or filter:

```bash
./vendor/bin/phpunit --filter testPageComments
```

## Documentation

See the `rest/` folder for API endpoints (comments, registration, contact forms).

## Requirements

- PHP 7+
- MySQL (or compatible)
- Composer (for running the unit tests)
- Mail provider account (SendGrid, SMTP, etc.)

## Features

- ✅ JWT authentication (uses adhocore/php-jwt)
- ✅ Configuration flags
- ✅ Comment moderation (approve/require moderation)
- ✅ Contact form support (send/view messages)
- ✅ API endpoints for comments and forms
- User management:
  - ✅ Register
  - ✅ Login
  - ✅ Change password
  - ✅ Update display name
  - ✅ View own comments

Planned:

- SSO integrations (Google, Facebook)
- [ ] Comment filtering / flagging system

## Notes & warnings

- Be careful when running SQL files against existing databases — these can overwrite data.
- The example Docker commands are helpful for local development but evaluate security and persistence for production use.
