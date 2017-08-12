<?php

namespace App\Http\Controllers;

require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Data.php";
require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Api.php";
use App\Http\Wechat\sdk\lib\WxPayApi;
use App\Http\Wechat\sdk\lib\WxPayOrderQuery;
use App\Http\Wechat\sdk\lib\WxPayRefund;
use App\Http\Wechat\sdk\lib\WxPayUnifiedOrder;
use App\Http\Wechat\WxApi;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use ErrorTrait;

    /**
     *
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
        $order->amount = $course->price?:$course->original_price;
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

    //调用统一下单API
    public function placeUnifiedOrder($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody('购买' . $order->title);
        $input->SetAttach("test");
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee($order->amount * 100);
//        $input->SetTotal_fee(1);//dev set to 1 cent
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://baby.fumubidu.com.cn/haomama/wechat/payment/notify");
        $input->SetTrade_type("JSAPI");//交易类型为公众号支付
        $input->SetProduct_id("32");
        $input->SetOpenid(auth()->user()->openid);
        $result = WxPayApi::unifiedOrder($input);
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
        return $result;
    }

    public static function updatePaymentStatus(Request $request, $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $result = self::queryOrder($request, $order->uuid);
        if ('SUCCESS' == $result['result_code']) {
            $order->status = $result['trade_state'] == 'SUCCESS' ? 'paid' : 'refunded';
            $order->wx_transaction_id = $result['transaction_id'];
            $order->wx_total_fee = $result['total_fee'];
            $order->update();
        }
        Log::info(json_encode($result));
        dd($result, $result['result_code']);
    }

    public function pay(Request $request)
    {
        Log::info(__FILE__ . __LINE__);
        $order = $this->store($request);
        try {
            //调用统一下单API
            $ret = $this->placeUnifiedOrder($order);
//            dd($ret);
            Log::info(__FILE__ . __LINE__);
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
            if ($request->ajax()) {
                return ['success' => true, 'data' => $data];
            }
            return view('admin.order.pay', $data);
        } catch (\Exception $e) {
            print($e->getMessage());
            $this->logError('wxpay.unifiedOrder', $e->getMessage(), '', '');
//            return ['success' => false];
            if ($request->ajax()) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
            return view('admin.order.pay');
        }
    }

    //退款
    public function refund(Request $request, $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        $input = new WxPayRefund();
        $input->SetOut_trade_no($order->uuid);
        $input->SetOut_refund_no($order->uuid);
        //如果SetRefund_fee(0)，$result会是签名错误
        $input->SetRefund_fee($order->wx_total_fee);//单位为分 //$input->SetRefund_fee(1);
        $input->SetTotal_fee($order->wx_total_fee);//单位为分
        $input->SetOp_user_id(config('wechat.mch.mch_id'));
        $result = WxPayApi::refund($input);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $order->status = 'refunded';
            $order->save();
            if($request->has('course_id')){
                $course=Course::findOrFail($request->course_id);
                $course->students()->detach($order->user_id);
                MessageFacade::sendRefundCompletedMessage(User::find($order->user_id), $course);
                return view('setting.refund',compact('course'));
            }
            return ['success' => true];
        } else {
            return [
                'success' => false,
                'message' => array_key_exists('err_code', $result)
                    ? $result['err_code']
                    : $result['return_msg']
            ];
        }
    }


    public function tmp(Request $request)
    {
        $course = Course::find($request->course_id);
        return view('setting.show', compact('course'));
    }
}
