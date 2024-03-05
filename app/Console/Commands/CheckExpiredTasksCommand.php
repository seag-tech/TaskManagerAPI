<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;

use App\Notifications\TaskExpiredNotification;
use Illuminate\Console\Command;
use App\Models\Task;

class CheckExpiredTasksCommand extends Command
{
    protected $signature = 'tasks:check-expired';

    protected $description = 'Check for expired tasks and send mail';

    public function handle()
    {
        $task = Task::where('due_date', '<', now())->get()->first();
        if ($task) {
            $task->notify(new TaskExpiredNotification());
            $this->info('Notified user ' . $task->user_id . ' for expired task: ' . $task->id);
        }
    }
}
