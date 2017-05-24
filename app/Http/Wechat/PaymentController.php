<?php

namespace App\Http\Controllers\Wechat;
require_once "sdk/lib/WxPay.Api.php";

use App\Facades\Price;
use App\Http\Controllers\Wechat\sdk\lib\WxPayApi;
use App\Http\Controllers\Wechat\sdk\lib\WxPayCloseOrder;
use App\Http\Controllers\Wechat\sdk\lib\WxPayOrderQuery;
use App\Http\Controllers\Wechat\sdk\lib\WxPayUnifiedOrder;
use App\Models\Order;
use App\Services\PriceService;
use App\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use File;
use DB;
use Illuminate\Support\Facades\Log;
use Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }


    public function qr(Request $request)
    {
        $referer=$request->header('Referer');
        if($referer){
            //add product page uri to session for sake of tracking if user finished payment.
            session(['product_uri'=>$referer]);
        }
//        $order = Order::where('product_id', $request->get('product_id'))
//            ->where('user_id', auth()->user()->id)
//            ->where('pay_type', 'wechat')
//            ->first();
        try {
//            if (true) {
//            if (!$order) {
                $order = $this->store($request);
//            } else {
//                $order->uuid = $this->uuid();
//                $order->save();
//                $r=$this->closeOrder($order);
//                Log::debug('close order'.json_encode($r));
//            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            if ($request->ajax())
                return ['success' => 'false', 'msg' => $e->getMessage()];
            return back();
        }
        $url = $this->placeUnifiedOrder($order);
        if ($request->ajax())
            return ['success' => 'true', 'data' => $url];
        return view('payment.qr', [
            'url' => $url,
            'order'=>$order
        ]);
    }

    public function qrcode()
    {
        require_once __DIR__ . '/sdk/example/phpqrcode/phpqrcode.php';
        $url = urldecode($_GET["data"]);
        QRcode::png($url);
    }

    public function uuid()
    {
        return str_replace('-', '', DB::select('select UUID() as uuid;')['0']->uuid);
    }

    //保存本地订单，返回这个订单对象
    public function store(Request $request)
    {
        $product_id = $request->get('product_id');
        $order = new Order();
        $order->uuid = $this->uuid();
        $order->user_id = auth()->user()->id;
        $order->status = 0;
        $order->product_id = $product_id;
        $order->product_type = 'sessions';
        $order->pay_type = 'wechat';

        $product = null;
        switch ($request->get('type')) {
            case 'course':
                $product = Session::find($product_id);
                if (!$product) {
                    throw new \Exception('Invalid product_id:' . $product_id);
                }
                break;
        }
        if($request->has('code')){
            $pricedata = Price::getPriceByCoupon($product_id,'sessions',$request->get('code'));
            if ($pricedata['code']==1) {
                $product->price=$pricedata['price'];
                $order['coupon_id']=$pricedata['couponId'];
            } else {
                throw new \Exception('price by coupon error');
            }
        }else{
            $product->price=Price::price($product_id,'sessions');
        }

        Log::info($product->price);
        if ($product->price <= 0) {
            throw new \Exception('price can not be negative');
        }
        $order->title = '课程' . $product->name;
        $order->totalprice = $product->price;
        $order->save();
        Log::debug('local order saved!');
        return $order;
    }

    public function placeUnifiedOrder($order)
    {
        Log::debug($order);
        $input = new WxPayUnifiedOrder();
        $input->SetBody('购买'.$order->title);
        $input->SetAttach("test");
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee($order->totalprice * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://www.shiyibao.com/wechat/payment-notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("32");
        $result = $this->GetPayUrl($input);
        Log::debug('统一下单api返回值:' . json_encode($result));
        if ($result['result_code'] == 'FAIL') {
            throw  new \Exception(json_encode($result));
        }
        $url = $result["code_url"];
        return $url;
    }

    public function GetPayUrl($input)
    {
        if ($input->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($input);
            return $result;
        }
    }

    public function closeOrder($order)
    {
        $input = new WxPayCloseOrder();
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $result = WxPayApi::closeOrder($input);
        return $result;
    }

    public function paymentNotify()
    {
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }

    public function ifPaied(Request $request,Order $order)
    {
       if($order->status==3){
           $session=Session::find($order->product_id);
           if ($session->type==5) {
               $exam=DB::table('exam_session')->where('session_id',$session->id)->first();
               session(['product_uri'=>'/exam/'.$exam->exam_id.'/entry/'.$session->id]);
           }
           return ['success'=>true,'msg'=>'支付成功','data'=>['uri'=>session('product_uri')]];
       }else{
           return ['success'=>false,'msg'=>'请稍后查询'];
       }
    }

    public static function queryOrder(Request $request)
    {
        $payOrderQuery=new WxPayOrderQuery();
        $payOrderQuery->SetTransaction_id($request->route('order'));
        $result = WxPayApi::orderQuery($payOrderQuery);
        return $result;
    }
}
