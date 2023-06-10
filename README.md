# http_mike/moneypenny

Moneypenny is project created as part of my BA thesis. It is a full-stack web application for personal budget management.

![ezgif com-video-to-gif](https://github.com/michalmytych/moneypenny/assets/59512535/726475dc-dcb8-4515-b319-a535a4e2a301)

### Setup
__Start Laravel Sail containers__
```bash
# First start docker, then:
./vendor/bin/sail up -d
```

__Migrate database__
```bash
# (In docker php app container shell)
php artisan migrate
```

__Seed database__
```bash
# (In docker php app container shell)
# Seed database
php artisan db:seed
# Create users personal accounts
php artisan moneypenny:create-users-personal-accounts
```

__Build frontend__
```bash
# (In docker php app container shell)
npm run build
# Optionally, if you want hot reloading:
npm run dev
```

__Other usefull commands__

<img width="1109" alt="image" src="https://github.com/michalmytych/moneypenny/assets/59512535/d93880e8-8765-41bb-af83-7cf1a85b03ca">

