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
        $max_lottery = self::getMaxLottery();

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
        return view('fivefu', $data);
    }

    /**
     * 抽取
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function lottery()
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $user = User::firstByWechatId($wechat_user['id']);
        if (!$user) {
            return $this->error(99, '用户不存在');
        }

        // 剩余抽奖次数
        $max_lottery = self::getMaxLottery();
        $lottery_num = UserLottery::countByUserIdDay($user['id'], date('Ymd'));
        if ($max_lottery - $lottery_num <= 0) {
            return $this->error(101, '您今天的抽奖次数用光了，请明天再来');
        }

        $card_id = 1;
        $user_id = $user['id'];
        $day = date('Ymd');
        // 抽奖记录
        UserLottery::create(compact('user_id', 'card_id', 'day'));

        // 用户卡包
        $user_card = UserCard::firstByUserIdCardId($user['id'], $card_id);
        if (!$user_card) {
            $num = 1;
            UserCard::create(compact('user_id', 'card_id', 'num'));
        } else {
            $user_card->increment('num');
        }
        $card = Card::firstById($card_id);
        return $this->success(compact('card'), '抽取成功');
    }

    /**
     * 剩余抽奖次数
     * @return int
     */
    private static function getMaxLottery()
    {
        // 剩余抽奖次数
        $max_lottery = 10;
        return $max_lottery;
    }
}
