<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use function Sodium\compare;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 成功返回json
     * @param array $data
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function success($data = [], $message = '')
    {
        if (!$data) {
            $data = new \stdClass;
        }
        $code = 200;
        return response(compact('code', 'data', 'message'));
    }

    /**
     * 失败返回json
     * @param array $data
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function error($code, $message = '', $data = [])
    {
        if (!$data) {
            $data = new \stdClass;
        }
        return response(compact('code', 'data', 'message'));
    }
}
