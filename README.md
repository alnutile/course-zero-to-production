# Course Project


[![CI-CD](https://github.com/alnutile/course-zero-to-production/actions/workflows/ci-cd.yml/badge.svg)](https://github.com/alnutile/course-zero-to-production/actions/workflows/ci-cd.yml)




## Setup
Setup .env

```bash 
cp .env.example .env
composer install
npm install
npm run dev
```

You can update your .env to have a password for admins

```env
ADMIN_ONE=bobbelcher@gmail.com
ADMIN_ONE_PASSWORD=makeagoodone

ADMIN_TWO=bobbelcher+101@gmail.com
ADMIN_TWO_PASSWORD=makeagoodone 
```

```bash 
php artisan migrate --seed
```

### Other seeding options

```bash 
php artisan db:seed --class=BooksSeeder
```


## Forge Deply

```bash 
cd /home/forge/books.alfrednutile.info
git add .
git stash

git pull origin $FORGE_SITE_BRANCH

npm install 
npm run build

$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock

if [ -f artisan ]; then
    $FORGE_PHP artisan migrate --force
fi

```
