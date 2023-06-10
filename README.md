# http_mike/moneypenny

Moneypenny is project created as part of my BA thesis. It is a full-stack web application for personal budget management.

![ezgif com-video-to-gif](https://github.com/michalmytych/moneypenny/assets/59512535/726475dc-dcb8-4515-b319-a535a4e2a301)

### Setup
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
