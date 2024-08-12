<?php

namespace App\Providers;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;
# use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Storage;

class OciObjectStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
if (config('filesystems.default') != 'oci') {
            return;
        }
        
        Storage::extend('s3', function($app, $config) {
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => '2006-03-01',
                'bucket_endpoint' => true,
                'endpoint' => $config['url']
            ]);

		$adapter = $adapter = new AwsS3V3Adapter(
 		   // S3Client
    			$client,
    			// Bucket name
    			$config['bucket']
		);
	
		return new Filesystem($adapter);
            
            return new Filesystem(new AwsS3V3Adapter($client, $config['bucket'], $config['bucket']));
        });

    }
}
