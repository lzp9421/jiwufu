<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\LaravelWeChat\Facade as EasyWeChat;

class WechatController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function serve()
    {
        $wechat = EasyWeChat::officialAccount();
        $response = $wechat->server->serve();
        return $response;
    }
}
