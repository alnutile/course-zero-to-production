# Course Project


[![CI-CD](https://github.com/alnutile/course-zero-to-production/actions/workflows/ci-cd.yml/badge.svg)](https://github.com/alnutile/course-zero-to-production/actions/workflows/ci-cd.yml)




## Setup
Copy .env.example to .env

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
