# Queues

**Objective**

1. Understand what is queue.
2. Know when to use queue.
3. Know how to setup a queue.
	- driver
	- 
4. Know how to run a queue.
	- `php artisan queue:work --tries=3 --queue=emails`
	- `php artisan queue:listen`
5. Know how to monitor queues.
	- Redis Desktop Manager
	- Medis
	- Laravel Horizon
6. Managing Workers with Supervisor

## Configuration

Default queue driver is `sync`, as in `.env.example`.

Available drivers:

1. `QUEUE_DRIVER=redis` 
	- `composer require predis/predis`
	- Install Redis
	- Setup Redis Connection
2. `QUEUE_DRIVER=database` 
	- `php artisan queue:table && php artisan migrate`
3. `QUEUE_DRIVER=beanstalkd` 
	-  `composer require pda/pheanstalk`
	- Install Beanstalkd
	- Setup Connection Setting
4. `QUEUE_DRIVER=sqs` 
	- `composer require aws/aws-sdk-php`

## Jobs

### Creating Job

```
$ php artisan make:job MailActivationJob
$ php artisan make:job NewsletterJob
$ php artisan make:job Payroll/ProcessPayslipJob
```

### Dispatching Job

You can test it via tinker. `php artisan tinker`.

```
>>> \App\Jobs\MailActivationJob::dispatch($user);
>>> \App\Jobs\NewsletterJob::dispatch($user);
>>> \App\Jobs\Payroll\ProcessPayslip::dispatch($payroll, $user);
```

You can also delay the job.

```
>>> \App\Jobs\MailActivationJob::dispatch($user)->delay(now()->addMinute());
>>> \App\Jobs\NewsletterJob::dispatch($user)->delay(now()->addMinutes(10));
>>> \App\Jobs\Payroll\ProcessPayslip::dispatch($payroll, $user)->delay(now()->addMinutes(5));
```

You can chaining the job, means, you can run the job by sequence. Failing one job, the remaining will not executed.

```php
MailJob::withChain([
    new ActivationMail($user),
    new Newsletter($user)
])->dispatch();
```

### Max Attempts

```
$ php artisan queue:work --tries=3
```

OR

```php
...
public $tries = 3;
...
```

### Timeout

Add following method in your job.

```php
public function retryUntil()
{
    return now()->addSeconds(5);
}
```

## Managing Workers with Supervisor

```
$ sudo apt-get install supervisor
```

Create configuration for your worker:

```
$ nano /etc/supervisor/conf.d/your-app.conf
```

Add the following configuration:

```
[program:your-app-worker]
command=php artisan queue:work --daemon
directory=/apps/your-app
process_name=%(program_name)s_%(process_num)s
numprocs=7
redirect_stderr=false
serverurl=AUTO
autostart=true
autorestart=true
stdout_logfile=/apps/logs/your-app-worker.log
```

Then run the following commands:

```
$ supervisorctl reread
$ supervisorctl update
$ supervisorctl start your-app-worker:*
```

## References

1. [Scotch.io - Why Laravel Queues are Awesome](https://scotch.io/tutorials/why-laravel-queues-are-awesome)
2. [Appdividend.com - Laravel Queues Tutorial Example Scratch](https://appdividend.com/2017/12/21/laravel-queues-tutorial-example-scratch/)
3. [Laravel Extending Queues](https://medium.com/@assertchris/laravel-extending-queues-883bf32040b3)
