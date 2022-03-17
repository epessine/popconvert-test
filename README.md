# Popconvert Test

## Instructions to run

Install dependencies using:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Run usual commands to prep a Laravel Sail app:

```bash
sail up

sail artisan key:generate

sail artisan migrate

sail npm i

sail npm run dev
```

