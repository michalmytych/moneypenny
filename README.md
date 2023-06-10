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
```bash
Available commands for the "moneypenny" namespace:
  moneypenny:associate-personas                         Create personas associations for all transactions.
  moneypenny:categorize-all-transactions-debug          Categorize all transactions with debug info.
  moneypenny:categorize-import-transaction              Trigger transactions categorization by import.
  moneypenny:copy-decimal-volume-to-calculation-volume  Copy decimal value transaction column to calculation volume column.
  moneypenny:create-admin-user                          Create new admin user account.
  moneypenny:create-users-personal-accounts             Create personal accounts records for existing users.
  moneypenny:create-users-settings                      Create accounts settings for existing users.
  moneypenny:generate-reports                           Generate reports for currently stored transactions.
  moneypenny:pull-exchange-rates                        Fetch history exchange rates from external api for currently stored transactions
  moneypenny:saldo                                      Calculate users's current saldo.
  moneypenny:send-app-notification                      Send application notifification via notification broadcasting service.
  moneypenny:set-saldo-by-email                         Set user's default account saldo by e-mail.
  moneypenny:show-transactions-personas                 Print all transactions with associated personas.
  moneypenny:update-types                               Update transactions types based on raw volume column.
```

