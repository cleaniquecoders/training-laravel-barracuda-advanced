<?php

$users = \App\User::all();

$users->each(function ($user) {
    \App\Jobs\MailJob::dispatch($user)->onQueue('blasting-emails');
    \App\Jobs\MailJob::dispatch($user)->onQueue('blasting-emails-delay')->delay(now()->addDays(7));
    // $user->notify(new \App\Notifications\DemoNotify);
});
