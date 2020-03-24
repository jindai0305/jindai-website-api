<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

if (!function_exists('move_file')) {
    function move_file($from, $to)
    {
        $dirname = dirname($to);
        if (file_exists($from)) {
            if (!is_dir($dirname)) {
                mkdir($dirname, 0777, true);
            }
            rename($from, $to);
        }
    }
}

if (!function_exists('get_file_name')) {
    function get_file_name($file)
    {
        if (strpos($file, '.') === false) {
            return $file;
        }
        $file_array = explode('/', $file);
        return end($file_array);
    }
}

if (!function_exists('var_export_data')) {
    function var_export_data($data, $prefix = '')
    {
        $file_name = app_path() . '/../storage/logs/' . $prefix . date('Ymd') . '.log';
//        if (!is_file($file_name)) {
//            touch($file_name);
//        }
        file_put_contents(
            $file_name, date('Y-m-d H:i:s') . PHP_EOL . '  ' . var_export($data, true) . PHP_EOL, FILE_APPEND
        );
    }
}

if (!function_exists('is_production_env')) {
    function is_production_env()
    {
        return app()->environment() === 'production';
    }
}

if (!function_exists('response_send_data')) {
    function response_send_data($data, $error_code = 0, $error_msg = 'success')
    {
        return compact('error_code', 'error_msg', 'data');
    }
}

function build_cache_key($uri)
{
    return md5(ltrim($uri, '/'));
}
