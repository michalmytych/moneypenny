[program:moneypenny-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/epi/19_mytych/moneypenny/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=19_mytych
numprocs=8
redirect_stderr=true
stdout_logfile=/home/19_mytych/supervisor/moneypenny-queue-worker.log
stopwaitsecs=3600

[program:moneypenny-schedule-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/epi/19_mytych/moneypenny/artisan schedule:work
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=19_mytych
numprocs=8
redirect_stderr=true
stdout_logfile=/home/19_mytych/supervisor/moneypenny-schedule-worker.log
stopwaitsecs=3600
