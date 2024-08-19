<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;
    public $subject;
    public $body;

    public function __construct($user , $subject , $body )
    {
        $this->user = $user; 
        $this->subject = $subject; 
        $this->body = $body; 
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['msg'] = $this->body ;
                    
        $send['email'] = $this->user->email;
        $send['name'] = $this->user->name;
        
        \Mail::send('emails.general', $data, function ($message) use ($send) {
            $message->to( $send['email'] , $send['name']);
            $message->subject($this->subject);
        });   
    
    }
}
