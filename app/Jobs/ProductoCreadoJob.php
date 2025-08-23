<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProductoCreadoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
