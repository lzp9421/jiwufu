<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardGiven;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserLottery;
use Overtrue\LaravelWeChat\Facade as EasyWeChat;
use Illuminate\Http\Request;
use PhpRedis;

class FiveFuController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Request $request)
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $data = [];
        $data['wechat_id'] = $wechat_user['id'];
        $data['name'] = $wechat_user['name'];
        $data['nickname'] = $wechat_user['nickname'] ?? '';
        $data['avatar'] = $wechat_user['avatar'] ?? '';
        $data['email'] = $wechat_user['email'] ?? '';

        $data = User::updateOrCreate(['wechat_id' => $data['wechat_id']], $data)->toArray();

        // 判断是否有待领取的卡片
        $from_user_id = $request->input('from_user_id');
        $card_id = $request->input('card_id');
        $token = $request-> input('token');
        if ($from_user_id && $card_id && $token) {
            $data['given'] = compact('from_user_id', 'card_id', 'token');
        }

        // 剩余抽奖次数
        $max_lottery = self::getMaxLottery();

        $lottery_num = UserLottery::countByUserIdDay($data['id'], date('Ymd'));
        $data['residue'] = $max_lottery - $lottery_num;

        // 用户卡片列表
        $user_cards = UserCard::findByUserId($data['id'])->toArray();
        $tmp = [];
        foreach ($user_cards as $key => $user_card) {
            $card_id = $user_card['card_id'];
            $tmp[$card_id] = $user_card;
        }
        $user_cards = $tmp;
        $cards = Card::all()->toArray();
        foreach ($cards as &$card) {
            if (empty($user_cards[$card['id']])) {
                $card['num'] = 0;
                continue;
            }
            $user_card = $user_cards[$card['id']];
            $card['user_card_id'] = $user_card['id'];
            $card['num'] = $user_card['num'];
        }

        // 微信sdk配置文件
        $api_list = ['updateAppMessageShareData'];
        $wechat = EasyWeChat::officialAccount();
        $url = $request->url() . '/';
        $data['config'] = $wechat->jssdk->setUrl($url)->buildConfig($api_list, true, false, false);

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

        $key = config('const.CARD_LIST_TODAY');
        $card_id = PhpRedis::lPop($key);
        if (!$card_id) {
            // 返回广告随机卡片
            return $this->success([], '你没有抽到');
        }
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
     * 赠送
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function given(Request $request)
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $user = User::firstByWechatId($wechat_user['id']);
        if (!$user) {
            return $this->error(99, '用户不存在');
        }
        $user_id = $user['id'];
        $token = $request->input('token');
        $card_id = $request->input('card_id');

        $user_card = UserCard::firstByUserIdCardId($user_id, $card_id);
        if (!$user_card || $user_card['num'] < 1) {
            return $this->error(98, '您还没有这张卡片');
        }
        // 转移用户卡片到待赠送区
        $user_card->decrement('num');
        CardGiven::create(compact('user_id', 'card_id', 'token'));
        return $this->success([], '赠送成功');
    }

    /**
     * 接收
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function receive(Request $request)
    {
        $wechat_user = session('wechat.oauth_user'); // 拿到授权用户资料
        $wechat_user = reset($wechat_user)->toArray();
        $user = User::firstByWechatId($wechat_user['id']);
        if (!$user) {
            return $this->error(99, '用户不存在');
        }
        $user_id = $user['id'];
        $token = $request->input('token');
        $from_user_id = $request->input('from_user_id');
        $card_id = $request->input('card_id');

        $give_card = CardGiven::firstByUserCardToken($from_user_id, $card_id, $token);
        if (!$give_card || $give_card['status'] != CardGiven::STATUS_WAITING) {
            return $this->error(99, '手慢啦，卡片已经被别人抢走了~');
        }
        // 扣减待赠送区的卡片
        $give_card->status = CardGiven::STATUS_RECEIVED;
        $give_card->save();
        // 增加用户卡片
        $user_card = UserCard::firstByUserIdCardId($user_id, $card_id);
        if (!$user_id) {
            $num = 1;
            UserCard::create(compact('user_id', 'card_id', 'num'));
        } else {
            $user_card->increment('num');
        }
        $card = Card::firstById($card_id);
        return $this->success(compact('card'), '领取成功');
    }

    /**
     * 剩余抽奖次数
     * @return int
     */
    private static function getMaxLottery()
    {
        // 剩余抽奖次数
        $max_lottery = 1000;
        return $max_lottery;
    }

    public function addCardList()
    {
        $res = [];
        $key = config('const.CARD_LIST_TODAY');
        for ($i = 0; $i < 1000; $i++) {
            $res[] = phpRedis::rPush($key, mt_rand(1, 5));
        }
        return $res;
    }
}
