<?php 

if (!function_exists('generateFiledCode')) {
    function generateFiledCode($code)
    {
        $result = $code . '-' . date('s') . date('Y') . date('m') . date('d') . date('h') . date('i') . mt_rand(1000, 9999);

        return $result;
    }
}

?>