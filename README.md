# http_mike/moneypenny

__Start Laravel Sail containers__
```bash
# First lauch docker, then:
./vendor/bin/sail up -d
```

__Migrate database__
```bash
# In docker php app container shell
php artisan migrate
```

__Seed database__
```bash
# In docker php app container shell
php artisan db:seed
```
