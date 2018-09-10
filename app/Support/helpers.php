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
