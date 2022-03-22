<?php

namespace App\Http\Livewire\S3Objects;

use Carbon\Carbon;
use Livewire\Component;
use App\Jobs\UploadSermon;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
 
    public $sermon_date, $sermon;
 
    public function save()
    {
        $this->validate([
            'sermon_date' => 'required',
            'sermon' => 'required',
        ]);
 
        // $fileName  = $this->sermon->getClientOriginalName();
        // $sermonDate = Carbon::parse($this->sermon_date);
        // $dir = 'audio/'.$sermonDate->format('Y').'/'.$sermonDate->format('m');
        // $res = $this->sermon->storePubliclyAs($dir, $fileName, 's3');
 
        $sermonDate = Carbon::parse($this->sermon_date);
        $dir = 'audio/'.$sermonDate->format('Y').'/'.$sermonDate->format('m');

        $sermon = [
            'name' => $this->sermon->getClientOriginalName(),
            'path' => $this->sermon->getRealPath(),
        ];

        dispatch(new UploadSermon($sermon, $dir));

        redirect()->route('s3objects.index');
        
    }

    public function render()
    {
        return view('livewire.s3-objects.create');
    }
}
