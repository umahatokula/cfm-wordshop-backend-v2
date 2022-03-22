<?php

namespace App\Http\Livewire\S3Objects;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\S3Object;

class Index extends Component
{
    public $s3Objects, $months = [], $years = [], $filter_month, $filter_year;
    public $s3Object;

    // public function mount() {
        
    //     $month = Carbon::now()->format('m');
    //     $year = Carbon::now()->format('Y');

    //     $this->s3Objects = S3Object::listS3Objects($month, $year);


    //     $years = [];
    //     $startYear = (date('Y') - 5);
    //     $endYear = (date('Y') + 5);
    //     for ($year=$startYear; $year <= $endYear; $year++) { 
    //         $this->years[$year] = $year;
    //     }

    //     $this->months = [
    //         '01' => 'January',
    //         '02' => 'February',
    //         '03' => 'March',
    //         '04' => 'April',
    //         '05' => 'May',
    //         '06' => 'June',
    //         '07' => 'July',
    //         '08' => 'August',
    //         '09' => 'September',
    //         '10' => 'October',
    //         '11' => 'November',
    //         '12' => 'December',
    //     ];
    // }

    public function mount() {
        
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $this->s3Objects = [
            ['Key' => 'errerer', 'Size' => 23],
            ['Key' => 'dkdsksd', 'Size' => 12],
            ['Key' => 'erlmcmkl', 'Size' => 27],
        ];


        $years = [];
        $startYear = (date('Y') - 5);
        $endYear = (date('Y') + 5);
        for ($year=$startYear; $year <= $endYear; $year++) { 
            $this->years[$year] = $year;
        }

        $this->months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }

    public function onFilterObjects() {
        dd($this->filter_month, $this->filter_year);

        $this->s3Objects = S3Object::listS3Objects($this->filter_month, $this->filter_year);
    }

    public function render()
    {
        return view('livewire.s3-objects.index');
    }
}
