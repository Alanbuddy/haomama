<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Wechat\JSSDK;

use File;
use Storage;

class JSSDKController extends Controller
{
		public function index(Request $request){
			$appid="wx75f10d3752bb2616";
			$secret="0a952956f084e83c92ebf87c0d8eca73";
//			$jssdk = new JSSDK($appid,$secret);
//			$signPackage = $jssdk->GetSignPackage();
		}

		public function getResult($url, $postfield=[], $timeout=100, $method='get'){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				if($method=='post'){
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield); 
				}
				curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
				$data = curl_exec($ch);
				$httpCode =curl_getinfo($ch,CURLINFO_HTTP_CODE);
				curl_close($ch);
				return (array(
								'data' => $data,
								'code' => $httpCode
				));
		}
}
