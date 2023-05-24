<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use App\Mail\MailVerifyToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $data, $user)
    {
        $this->user = $user;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'verify') {
            Mail::to($this->user)->send(new MailVerifyToken($this->data));
        }

        if ($this->type == 'complete_task') {
            Mail::to($this->user)->send(new MailNotify($this->data));
        }

    }
}
