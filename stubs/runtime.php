<?php

$appRoot = $_ENV['LAMBDA_TASK_ROOT'];

/* START_VENDOR_DOWNLOADING */

fwrite(STDERR, 'Downloading the vendor archive');

exec(
    sprintf('/opt/awscli/aws s3 presign s3://%s/%s-vendor.zip --expires-in 300',
        $_ENV['VAPOR_ARTIFACT_BUCKET_NAME'],
        $_ENV['VAPOR_ARTIFACT_NAME']
    ),
    $output
);

file_put_contents('/tmp/vendor.zip', fopen($output[0], 'r'));

$zip = new ZipArchive;

$zip->open('/tmp/vendor.zip');

$zip->extractTo('/tmp/vendor');

$zip->close();

unlink('/tmp/vendor.zip');

/* END_VENDOR_DOWNLOADING */

require $appRoot.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap The Runtime
|--------------------------------------------------------------------------
|
| If the application is being served by the console layer, we will require in the
| console runtime. Otherwise, we will use the FPM runtime. Vapor will setup an
| environment variable for the console layer that we will use to check this.
|
*/

if (isset($_ENV['APP_RUNNING_IN_CONSOLE']) &&
    $_ENV['APP_RUNNING_IN_CONSOLE'] === 'true') {
    return require __DIR__.'/cliRuntime.php';
} else {
    return require __DIR__.'/fpmRuntime.php';
}
