<?php

namespace App\Models;

use Carbon\Carbon;
use Aws\S3\S3Client;

use Aws\S3\Exception\S3Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class S3Object extends Model
{
    use HasFactory;

    public static function listS3Objects($month=null, $year=null) {

        if (!$month) {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
        }
        
        $bucket = env('AWS_BUCKET');
        $s3Objects = [];
        
        // Instantiate the client.
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION')
        ]);
        
        // Use the high-level iterators (returns ALL of your objects).
        try {
            $results = $s3->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                "Prefix" => "audio/".$year."/".$month
            ]);
        
            foreach ($results as $result) {
                foreach ($result['Contents'] as $object) {
                    if ($object['Size']) {
                        $s3Objects[] = $object;
                    }
                }
            }
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $s3Objects;
    }
}
