<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-6-22
 * Time: 下午4:52
 */

namespace app\Http\ViewComposers;

use App\Http\Wechat\JSSDK;
use Illuminate\View\View;

class WxComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $jsSdk = new JSSDK(config('wechat.mp.app_id'), config('wechat.mp.app_secret'));
        $signPackage = $jsSdk->getSignPackage();
        $view->with('signPackage', $signPackage);
    }
}