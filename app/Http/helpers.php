<?php

if (! function_exists('uploadFile')) {
    function uploadFile($file, $publicPath) {
        $name = $file->getClientOriginalName();
        $fileName = microtime() . '-' . $name;
        return $file->storeAs((string)$publicPath, $fileName, ['disk' => 'image']);
    }
}

