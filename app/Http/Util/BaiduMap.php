<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-11
 * Time: 下午5:28
 */

namespace App\Http\Util;


use Illuminate\Http\Request;

trait BaiduMap
{
    use Curl;

// 示例 http://baby.com/3rd/map/render?lat=40.00135&lon=116.4021
// 返回值
//renderReverse&&renderReverse({"status":0,"result":{"location":{"lng":116.40209999999994,"lat":40.001350069859537},"formatted_address":"北京市朝阳区慧忠路隧道","business":"亚运村,奥运村,大屯","addressComponent":{"country":"中国","country_code":0,"province":"北京市","city":"北京市","district":"朝阳区","adcode":"110105","street":"慧忠路隧道","street_number":"","direction":"","distance":""},"pois":[{"addr":"北京市朝阳区北辰东路15号","cp":"","direction":"内","distance":"0","name":"奥林匹克公园","poiType":"旅游景点","point":{"x":116.39912219884669,"y":40.00120939978231},"tag":"旅游景点","tel":"","uid":"451614f6ebe67020843304a2","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"国家体育场南路一号","cp":" ","direction":"北","distance":"315","name":"国家体育场(鸟巢)","poiType":"运动健身","point":{"x":116.402841183658,"y":39.999247267799699},"tag":"运动健身;体育场馆","tel":"","uid":"480b24d05abb06f29cec2b2f","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"朝阳区国家体育场南路1号(鸟巢北门火炬广场附件)","cp":" ","direction":"西北","distance":"268","name":"鸟巢文化中心","poiType":"旅游景点","point":{"x":116.40389220110467,"y":40.000103980303148},"tag":"旅游景点;文物古迹","tel":"","uid":"8c99548453a319be901fc960","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"北京市朝阳区慧忠路隧道","cp":" ","direction":"东","distance":"285","name":"旅游综合服务区","poiType":"交通设施","point":{"x":116.39953541938128,"y":40.00130612312851},"tag":"交通设施;服务区","tel":"","uid":"667ca1b0778f630b0782c2dd","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"北京市朝阳区","cp":" ","direction":"东","distance":"300","name":"北京市公安局朝阳分局奥林匹克公园派出所国家体育馆巡逻警务站","poiType":"政府机构","point":{"x":116.39940965660988,"y":40.001195582150149},"tag":"政府机构;公检法机构","tel":"","uid":"ff291b06cf8ff7120a5cb3b4","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"国家体育场北路8号","cp":" ","direction":"东南","distance":"385","name":"玲珑塔","poiType":"旅游景点","point":{"x":116.40028999600966,"y":40.00362053343522},"tag":"旅游景点;风景区","tel":"","uid":"fb0ff16d9dbfbc8014b54b5a","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"北京市朝阳区国家体育场北路临6号","cp":" ","direction":"南","distance":"418","name":"玲珑小馆","poiType":"美食","point":{"x":116.40077508098504,"y":40.00405577191256},"tag":"美食;中餐厅","tel":"","uid":"db97cc0f2e8f10f08f55ecee","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"北京市朝阳区国家体育场北路","cp":" ","direction":"东南","distance":"415","name":"北京市公安局朝阳分局奥林匹克公园派出所玲珑塔巡逻警务站","poiType":"政府机构","point":{"x":116.39953541938128,"y":40.00343400180307},"tag":"政府机构;公检法机构","tel":"","uid":"87d79f7755180a2d7069d3a2","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}},{"addr":"北京市朝阳区国家体育场南路1号(鸟巢)","cp":" ","direction":"北","distance":"530","name":"北京奥运博物馆","poiType":"旅游景点","point":{"x":116.40314660753139,"y":39.99777563151652},"tag":"旅游景点;博物馆","tel":"","uid":"72cb7b11046b6a59fe0eb011","zip":"","parent_poi":{"name":"国家体育场(鸟巢)","tag":"运动健身;体育场馆","addr":"国家体育场南路一号","point":{"x":116.402841183658,"y":39.999247267799699},"direction":"北","distance":"315","uid":"480b24d05abb06f29cec2b2f"}},{"addr":"北京市朝阳区湖景东路11号新奥购物中心天虹百货北京新奥天虹地下二层","cp":" ","direction":"南","distance":"568","name":"新奥购物中心","poiType":"购物","point":{"x":116.40292203115389,"y":40.00522330258551},"tag":"购物;购物中心","tel":"","uid":"005568f651afb240eb12e45a","zip":"","parent_poi":{"name":"","tag":"","addr":"","point":{"x":0.0,"y":0.0},"direction":"","distance":"","uid":""}}],"roads":[],"poiRegions":[{"direction_desc":"内","name":"奥林匹克公园","tag":"旅游景点"}],"sematic_description":"奥林匹克公园内,国家体育场(鸟巢)北315米","cityCode":131}})
    public function renderReverse(Request $request)
    {
        $lat = $request->lat;
        $lon = $request->lon;
        $ak = 'Z1TNDqndqADPoB9Q7DiVcv50XD9ZgPjC';
        //示例地址 http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location=39.983424,116.322987&output=json&pois=1&ak=您的ak
        $url = 'http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location=' . $lat . ',' . $lon . '&output=json&pois=1&ak=' . $ak;
        $response=self::request($url);
        return $response['data'];
    }

}