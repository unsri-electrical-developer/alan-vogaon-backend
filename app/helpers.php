<?php

use Illuminate\Support\Facades\Storage;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client;

if (!function_exists('generateFiledCode')) {
    function generateFiledCode($code)
    {
        $result = $code . '-' . date('s') . date('Y') . date('m') . date('d') . date('h') . date('i') . mt_rand(1000000, 9999999);


        return $result;
    }
}

/*
 *  Encode base64 image and save to Storage
 */
if (!function_exists('uploadFotoWithFileName')) {
    function uploadFotoWithFileName($base64Data, $file_prefix_name, $dir = '')
    {
        $file_name = generateFiledCode($file_prefix_name) . '.png';

        //Check if storage map exists
        $storageDir = Storage::disk('public')->path($dir);
        // return $storageDir;
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0777, true);
        }

        $insert_image = Storage::disk('public')->put($dir . '/' . $file_name, normalizeAndDecodeBase64Photo($base64Data));

        if ($insert_image) {
            return $dir . '/' . $file_name;
        }

        return false;
    }

    function normalizeAndDecodeBase64Photo($base64Data)
    {
        $replaceList = array(
            'data:image/jpeg;base64,',
            'data:image/jpg;base64,',
            'data:image/png;base64,',
            '[protected]',
            '[removed]',
        );
        $base64Data = str_replace($replaceList, '', $base64Data);

        return base64_decode($base64Data);
    }
}

/*
 *  Encode base64 image and save to Storage
 */
if (!function_exists('uploadFotoToGStorage')) {
    function uploadFotoToGStorage($base64Data, $file_prefix_name, $dir = '')
    {
        $file_name = generateFiledCode($file_prefix_name) . '.png';

        //Check if storage map exists
        $storageDir = Storage::disk('public')->path($dir);
        // return $storageDir;
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0777, true);
        }

        $insert_image = Storage::disk('public')->put($dir . '/' . $file_name, replaceBase64Photo($base64Data));

        if ($insert_image) {
            $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
            $fullPath = $storagePath . $dir . '/' . $file_name;

            $googleConfigFile = file_get_contents(config_path('risqi-ardiansyah-5b98c8df2185.json'));
            $storage = new StorageClient([
                'keyFile' => json_decode($googleConfigFile, true)
            ]);
            $storageBucketName = config('googlecloud.storage_bucket');
            $bucket = $storage->bucket($storageBucketName);
            $fileSource = fopen($fullPath, 'r');
            $newFolderName = 'vogaon';
            $googleCloudStoragePath = $newFolderName . '/' . $file_name;
            /* Upload a file to the bucket.
        Using Predefined ACLs to manage object permissions, you may
        upload a file and give read access to anyone with the URL.*/
            $bucket->upload($fileSource, [
                // 'predefinedAcl' => 'publicRead',
                'name' => $googleCloudStoragePath
            ]);

            return [
                "url" => url($googleCloudStoragePath),
                "google_storage_url" => 'https://storage.cloud.google.com/' . $storageBucketName . '/' . $googleCloudStoragePath
            ];

            // return $storagePath . $dir . '/' . $file_name;
        }

        return false;
    }

    function replaceBase64Photo($base64Data)
    {
        $replaceList = array(
            'data:image/jpeg;base64,',
            'data:image/jpg;base64,',
            'data:image/png;base64,',
            '[protected]',
            '[removed]',
        );
        $base64Data = str_replace($replaceList, '', $base64Data);

        return base64_decode($base64Data);
    }
}

if (!function_exists('getImage')) {
    function getImage($file, $icon = false)
    {
        if (empty($file)) {
            if ($icon) {
                return asset('/image/icon.png');
            }
            return asset('/def/default.png');
        }
        return env('ADMIN_DOMAIN') . $file;
    }
}

if (!function_exists('checkCaptcha')) {
    function checkCaptcha($token = '')
    {
        $secret = env('CAPTCHA_SECRET_KEY');
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token";

        $client = new Client();
        $response = $client->request("POST", $url, [
            "headers" => [
                "Content-type" => "application/json",
            ],
        ]);
        $dataResponse = json_decode($response->getBody()->getContents(), true);

        return (object)$dataResponse;
    }
}

if (!function_exists('getFABarcode')) {
    function getFABarcode($token = '', $email = 'GAMEONLINE')
    {
        $site = env('GAUTH_SITE');
        $url = $site."pair.aspx?AppName=VOGAON&AppInfo=$email&SecretCode=$token";

        $client = new Client();
        $response = $client->request("GET", $url, [
            // "headers" => [
            //     "Content-type" => "text/html; charset=utf-8",
            // ],
        ]);
        $dataResponse = $response->getBody(true)->getContents();

        return $dataResponse;
    }
}

if (!function_exists('pairFA')) {
    function pairFA($pin = '', $token = '')
    {
        $site = env('GAUTH_SITE');
        $url = $site."Validate.aspx?Pin=$pin&SecretCode=$token";

        $client = new Client();
        $response = $client->request("GET", $url, [
            // "headers" => [
            //     "Content-type" => "text/html; charset=utf-8",
            // ],
        ]);
        $dataResponse = $response->getBody(true)->getContents();

        return $dataResponse;
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

/*
 *  Remove whitespace, special character, and turn string to lower case
 */
if (!function_exists('normalizeString')) {
    function normalizeString($input)
    {
        $res = preg_replace("/[^a-zA-Z]+/", "", $input);
        return strtolower($res);
    }
}
