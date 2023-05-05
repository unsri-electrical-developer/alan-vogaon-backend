<?php

use Illuminate\Support\Facades\Storage;

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
 *  Remove whitespace, special character, and turn string to lower case
 */
if (!function_exists('normalizeString')) {
    function normalizeString($input)
    {
        $res = preg_replace("/[^a-zA-Z]+/", "", $input);
        return strtolower($res);
    }
}


?>