<?php
/**
 * Created by PhpStorm.
 * User: liminggui
 * Date: 2018/9/10
 * Time: 10:39
 */

const SECRET = 'addewf4';

/**
 * 数据签名
 * @param array ...$vars
 * @return string
 */
function create_token(...$vars) {
    sort($vars);
    $token = md5(serialize($vars) . SECRET);
    return $token;
}

/**
 * 校验数据
 * @param $token
 * @param array ...$vars
 * @return bool
 */
function verify_data($token, ...$vars) {
    sort($vars);
    $cale_token = md5(serialize($vars) . SECRET);
    return $token === $cale_token;
}

/**
 * @return string
 */
function current_url()
{
    $pageURL = 'http';

    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}