<?php

namespace App\Http\Controllers;

require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Data.php";
require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Api.php";
use App\Http\Wechat\sdk\lib\WxPayApi;
use App\Http\Wechat\sdk\lib\WxPayOrderQuery;
use App\Http\Wechat\sdk\lib\WxPayUnifiedOrder;
use App\Http\Wechat\WxApi;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Order::orderBy('id', 'desc')->paginate(10);
//        dd($items);
        return view('admin.order.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();
        $course = Course::findOrFail($request->get('course_id'));
        $order->title = 'buy course ' . $course->name;
        $order->product_id = $course->id;
        $order->amount = $course->price;
        $order->uuid = $this->uuid();
        auth()->user()->orders()->save($order);
        return $order;
    }

    public function uuid()
    {
        return md5(uniqid(rand(), true));
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin.order.show', ['item' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function placeUnifiedOrder($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody('购买' . $order->title);
        $input->SetAttach("test");
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee($order->amount * 100);
        $input->SetTotal_fee(1);//dev set to 1 cent
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://baby.fumubidu.com.cn/wechat/payment/notify");
        $input->SetTrade_type("JSAPI");//交易类型为公众号支付
        $input->SetProduct_id("32");
        $input->SetOpenid(auth()->user()->openid);
        $result = WxPayApi::unifiedOrder($input);
//        dd($result);
        Log::debug('统一下单api返回值:' . json_encode($result));
        if ($result['result_code'] == 'FAIL') {
            throw  new \Exception(json_encode($result));
        }
        return $result;
    }

    public static function queryOrder(Request $request, $uuid)
    {
        $payOrderQuery = new WxPayOrderQuery();
        $payOrderQuery->SetOut_trade_no($uuid);
        $result = WxPayApi::orderQuery($payOrderQuery);
        dd($result);
        return $result;
    }

    public static function updatePaymentStatus(Request $request, $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $result = self::queryOrder($request, $order->uuid);
        if ('SUCCESS' == $result['result_code']) {
            $order->status = 'paid';
            $order->wx_transaction_id = $result['transaction_id'];
            $order->wx_total_fee = $result['total_fee'];
            $order->save();
        }
        dd($result);
    }

    public function pay(Request $request)
    {
        $order = $this->store($request);
        try {
            //调用统一下单API
            $ret = $this->placeUnifiedOrder($order);
            dd($ret);

            $appId = $ret['appid'];
            $timeStamp = time();
            $nonceStr = WxApi::getNonceStr();
            $prepayId = $ret['prepay_id'];
            $package = 'prepay_id=' . $prepayId;
            $signType = 'MD5';
            $values = compact(
                'appId', 'timeStamp', 'nonceStr', 'package', 'signType'
            );
            $sign = WxApi::makeSign($values);
            $data = array_merge($values, compact('sign', 'prepayId', 'order'));
            return view('admin.order.pay', $data);
        } catch (\Exception $e) {
            print($e->getMessage());
//            return ['success' => false];
            return view('admin.order.pay');
        }
    }
}
