<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UploadSermon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sermon;
    public $dir;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sermon, $dir)
    {
        $this->sermon = $sermon;
        $this->dir = substr($dir, -1) == '/' ? $dir : $dir.'/';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::disk('s3')->put($this->dir.$this->sermon['name'], file_get_contents($this->sermon['path']), 'public');
    }
}
