<?php

namespace App\Http\Controllers;

require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Data.php";
require_once __DIR__ . "/../Wechat/sdk/lib/WxPay.Api.php";
use App\Http\Wechat\sdk\lib\WxPayApi;
use App\Http\Wechat\sdk\lib\WxPayUnifiedOrder;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $items = Order::paginate(10);
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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
        //调用统一下单API
        $this->placeUnifiedOrder($order);

        return ['success' => true];
    }

    public function uuid()
    {
        return md5(uniqid(rand(), true));
    }

    public function placeUnifiedOrder($order)
    {
        Log::debug($order);
        $input = new WxPayUnifiedOrder();
        $input->SetBody('购买' . $order->title);
        $input->SetAttach("test");
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee($order->amount * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://baby.fumubidu.com.cn/wechat/payment/notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("32");
        $result = WxPayApi::unifiedOrder($input);
        dd($result);
        Log::debug('统一下单api返回值:' . json_encode($result));
        if ($result['result_code'] == 'FAIL') {
            throw  new \Exception(json_encode($result));
        }
        $url = $result["code_url"];
        return $url;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
