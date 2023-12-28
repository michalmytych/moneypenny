# http_mike/moneypenny

Moneypenny is a project created as part of my BA thesis. It is a full-stack web application for personal budget management.

![ezgif com-video-to-gif](https://github.com/michalmytych/moneypenny/assets/59512535/726475dc-dcb8-4515-b319-a535a4e2a301)

### Automated basic local setup
If you have `php8.2`, `Composer 2.*` and some relational database (`mysql`, `postgresql`, etc.) installed in your system, you can try automated setup.
```bash
composer install
php artisan moneypenny:setup-app
```

__Useful commands__
```
Available commands for the "moneypenny" namespace:
  moneypenny:associate-personas                         Create personas associations for all transactions.
  moneypenny:categorize-all-transactions-debug          Categorize all transactions with debug info.
  moneypenny:categorize-import-transaction              Trigger transactions categorization by import.
  moneypenny:copy-decimal-volume-to-calculation-volume  Copy decimal value transaction column to calculation volume column.
  moneypenny:create-admin-user                          Create new admin user account.
  moneypenny:create-users-personal-accounts             Create personal accounts records for existing users.
  moneypenny:create-users-settings                      Create accounts settings for existing users.
  moneypenny:pull-exchange-rates                        Fetch history exchange rates from external api for currently stored transactions
  moneypenny:saldo                                      Calculate user's current saldo.
  moneypenny:send-app-notification                      Send application notification via notification broadcasting service.
  moneypenny:set-saldo-by-email                         Set user's default account saldo by e-mail.
  moneypenny:setup-app                                  Perform basic local application setup.
  moneypenny:show-transactions-personas                 Print all transactions with associated personas.
  moneypenny:update-types                               Update transactions types based on raw volume column.
```

