<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRestablecerPass;
use Illuminate\Support\Facades\Crypt;

class MailRestablecerPassJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $playload = [
            'user_id' => $this->id,
            'expires_at' => now()->addMinutes(30)->toDateTimeString(),
        ];
        $token = Crypt::encrypt(json_encode($playload));
        $user = User::findOrFail($this->id);                
        Mail::to($user->email)->send(new EmailRestablecerPass($user, $token));
    }
}
