<?php

namespace App\Http\Controllers;

use App\Models\CardProvide;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function provideList(Request $request)
    {
        $start_time = $request->input('start_time') ?: date('Y-m-d', strtotime('-2 day'));
        $end_time = $request->input('end_time');

        $start_day = date('Ymd', strtotime($start_time));
        $end_day = $end_time ? date('Ymd', strtotime($end_time)) : 0;
        $data = compact('start_time', 'end_time');
        $data['data'] = CardProvide::getList($start_day, $end_day);
        return view('card_provide', $data);
    }
    
}
