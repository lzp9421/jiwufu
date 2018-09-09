<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserLottery;
use Illuminate\Http\Request;

class FiveFuController extends Controller
{
    public function index()
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $data = [];
        $data['wechat_id'] = $wechat_user['id'];
        $data['name'] = $wechat_user['name'];
        $data['nickname'] = $wechat_user['nickname'] ?? '';
        $data['avatar'] = $wechat_user['avatar'] ?? '';
        $data['email'] = $wechat_user['email'] ?? '';

        $data = User::updateOrCreate($data)->toArray();

        // 剩余抽奖次数
        $max_lottery = 10;

        $lottery_num = UserLottery::countByUserIdDay($data['id'], date('Ymd'));
        $data['residue'] = $max_lottery - $lottery_num;

        // 用户卡片列表
        $user_cards = UserCard::findByUserId($data['id'])->toArray();
        foreach ($user_cards as $key => $user_card) {
            unset($user_cards[$key]);
            $card_id = $user_card['card_id'];
            $user_cards[$card_id] = $user_card;
        }
        $cards = Card::all()->toArray();
        foreach ($cards as &$card) {
            if (empty($user_cards[$card['id']])) {
                $card['num'] = 0;
                continue;
            }
            $user_card = $user_cards[$card['id']];
            $card['num'] = $user_card['num'];
        }

        $data['cards'] = $cards;
        return view('fivefu', compact('data'));
    }

    /**
     * 获取用户资料
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public function info()
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $data = [];
        $data['wechat_id'] = $wechat_user['id'];
        $data['name'] = $wechat_user['name'];
        $data['nickname'] = $wechat_user['nickname'] ?? '';
        $data['avatar'] = $wechat_user['avatar'] ?? '';
        $data['email'] = $wechat_user['email'] ?? '';

        $data = User::updateOrCreate($data)->toArray();

        // 剩余抽奖次数
        $max_lottery = 10;

        $lottery_num = UserLottery::countByUserIdDay($data['id'], date('Ymd'));
        $data['residue'] = $max_lottery - $lottery_num;

        // 用户卡片列表
        $user_cards = UserCard::findByUserId($data['id'])->toArray();
        foreach ($user_cards as $key => $user_card) {
            unset($user_cards[$key]);
            $card_id = $user_card['card_id'];
            $user_cards[$card_id] = $user_card;
        }
        $cards = Card::all()->toArray();
        foreach ($cards as &$card) {
            if (empty($user_cards[$card['id']])) {
                $card['num'] = 0;
                continue;
            }
            $user_card = $user_cards[$card['id']];
            $card['num'] = $user_card['num'];
        }

        $data['cards'] = $cards;


        return $this->success($data, '用户信息');
    }

    public function lottery()
    {
        $data = [];
        return $this->success($data, '抽取成功');
    }
}
