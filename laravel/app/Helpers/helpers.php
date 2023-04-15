<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;


use Auth;
use Config;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\WebCaptions;
use App\Models\Masters\Currencies;

use App\Models\Companies;
use App\Models\Vehicles;
use Illuminate\Support\Facades\DB;

class Helper {
    public static $companies_id;
    public static $created_by_id;
    public static $query;
    public static $DifferenceSpecialAndRegularPrice;
    public static $DefultDifference;
    public static $currency;
    public static $regularPrice;
    public static $specialPrice;
    public static $returnMessage;

   

    public static function applClasses() {
        // Demo
        $fullURL = request()->fullurl();
        if(App()->environment() === 'production') {
            for($i=1; $i<7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if($contains === true)  $data = config('custom.' . 'demo-' . $i);
            }
        }
        else    $data = config('custom.custom');
        
        // default data array
        $DefaultData = [
          'mainLayoutType'          =>  'vertical',
          'theme'                   =>  'light',
          'sidebarCollapsed'        =>  false,
          'navbarColor'             =>  '',
          'horizontalMenuType'      =>  'floating',
          'verticalMenuNavbarType'  =>  'floating',
          'footerType'              =>  'static', //footer
          'layoutWidth'             =>  'full',
          'showMenu'                =>  true,
          'bodyClass'               =>  '',
          'bodyStyle'               =>  '',
          'pageClass'               =>  '',
          'pageHeader'              =>  true,
          'contentLayout'           =>  'default',
          'blankPage'               =>  false,
          'defaultLanguage'         =>  'en',
          'direction'               =>  env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType'            =>  array('vertical', 'horizontal'),
            'theme' => array('light'    =>  'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed'          =>  array(true, false),
            'showMenu'                  =>  array(true, false),
            'layoutWidth'               =>  array('full', 'boxed'),
            'navbarColor'               =>  array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType'        =>  array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass'       =>  array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType'    =>  array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass'               =>  array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType'                =>  array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader'                =>  array(true, false),
            'contentLayout'             =>  array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage'                 =>  array(false, true),
            'sidebarPositionClass'      =>  array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass'       =>  array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage'           =>  array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
            'direction'                 =>  array('ltr', 'rtl'),
        ];

        foreach($allOptions as $key => $value) {
            if(array_key_exists($key, $DefaultData)) {
                if(gettype($DefaultData[$key]) === gettype($data[$key])) {
                    if(is_string($data[$key])) {
                        if(isset($data[$key]) && $data[$key] !== null) {
                            if(!array_key_exists($data[$key], $value)) {
                                $result = array_search($data[$key], $value, 'strict');
                                if(empty($result) && $result !== 0) $data[$key] = $DefaultData[$key];
                            }
                        } 
                        else    $data[$key] = $DefaultData[$key];
                    }
                }
                else    $data[$key] = $DefaultData[$key];
            }
        }

        //layout classes
        $layoutClasses = [
            'theme'                     =>  $data['theme'],
            'layoutTheme'               =>  $allOptions['theme'][$data['theme']],
            'sidebarCollapsed'          =>  $data['sidebarCollapsed'],
            'showMenu'                  =>  $data['showMenu'],
            'layoutWidth'               =>  $data['layoutWidth'],
            'verticalMenuNavbarType'    =>  $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass'               =>  $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor'               =>  $data['navbarColor'],
            'horizontalMenuType'        =>  $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass'       =>  $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType'                =>  $allOptions['footerType'][$data['footerType']],
            'sidebarClass'              =>  'menu-expanded',
            'bodyClass'                 =>  $data['bodyClass'],
            'bodyStyle'                 =>  $data['bodyStyle'],
            'pageClass'                 =>  $data['pageClass'],
            'pageHeader'                =>  $data['pageHeader'],
            'blankPage'                 =>  $data['blankPage'],
            'blankPageClass'            =>  '',
            'contentLayout'             =>  $data['contentLayout'],
            'sidebarPositionClass'      =>  $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass'       =>  $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType'            =>  $data['mainLayoutType'],
            'defaultLanguage'           =>  $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction'                 =>  $data['direction'],
        ];
        
        if(!session()->has('locale'))                       app()->setLocale($layoutClasses['defaultLanguage']);
        if($layoutClasses['sidebarCollapsed'] == 'true')    $layoutClasses['sidebarClass'] = "menu-collapsed";
        if($layoutClasses['blankPage'] == 'true')           $layoutClasses['blankPageClass'] = "blank-page";
        
        return $layoutClasses;
    }


    public static function dashApplClasses() {
        // Demo
        $fullURL = request()->fullurl();
        if(App()->environment() === 'production') {
            for($i=1; $i<7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if($contains === true)  $data = config('custom.' . 'demo-' . $i);
            }
        }
        else    $data = config('custom.custom');
        
        // default data array
        $DefaultData = [
          'mainLayoutType'          =>  'vertical',
          'theme'                   =>  'light',
          'sidebarCollapsed'        =>  false,
          'navbarColor'             =>  '',
          'horizontalMenuType'      =>  'floating',
          'verticalMenuNavbarType'  =>  'floating',
          'footerType'              =>  'static', //footer
          'layoutWidth'             =>  'full',
          'showMenu'                =>  true,
          'bodyClass'               =>  '',
          'bodyStyle'               =>  '',
          'pageClass'               =>  '',
          'pageHeader'              =>  true,
          'contentLayout'           =>  'default',
          'blankPage'               =>  false,
          'defaultLanguage'         =>  'en',
          'direction'               =>  env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType'            =>  array('vertical', 'horizontal'),
            'theme' => array('light'    =>  'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed'          =>  array(true, false),
            'showMenu'                  =>  array(true, false),
            'layoutWidth'               =>  array('full', 'boxed'),
            'navbarColor'               =>  array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType'        =>  array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass'       =>  array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType'    =>  array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass'               =>  array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType'                =>  array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader'                =>  array(true, false),
            'contentLayout'             =>  array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage'                 =>  array(false, true),
            'sidebarPositionClass'      =>  array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass'       =>  array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage'           =>  array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
            'direction'                 =>  array('ltr', 'rtl'),
        ];

        foreach($allOptions as $key => $value) {
            if(array_key_exists($key, $DefaultData)) {
                if(gettype($DefaultData[$key]) === gettype($data[$key])) {
                    if(is_string($data[$key])) {
                        if(isset($data[$key]) && $data[$key] !== null) {
                            if(!array_key_exists($data[$key], $value)) {
                                $result = array_search($data[$key], $value, 'strict');
                                if(empty($result) && $result !== 0) $data[$key] = $DefaultData[$key];
                            }
                        } 
                        else    $data[$key] = $DefaultData[$key];
                    }
                }
                else    $data[$key] = $DefaultData[$key];
            }
        }

        //layout classes
        $layoutClasses = [
            'theme'                     =>  $data['theme'],
            'layoutTheme'               =>  $allOptions['theme'][$data['theme']],
            'sidebarCollapsed'          =>  $data['sidebarCollapsed'],
            'showMenu'                  =>  $data['showMenu'],
            'layoutWidth'               =>  $data['layoutWidth'],
            'verticalMenuNavbarType'    =>  $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass'               =>  $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor'               =>  $data['navbarColor'],
            'horizontalMenuType'        =>  $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass'       =>  $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType'                =>  $allOptions['footerType'][$data['footerType']],
            'sidebarClass'              =>  'menu-expanded',
            'bodyClass'                 =>  $data['bodyClass'],
            'bodyStyle'                 =>  $data['bodyStyle'],
            'pageClass'                 =>  $data['pageClass'],
            'pageHeader'                =>  $data['pageHeader'],
            'blankPage'                 =>  $data['blankPage'],
            'blankPageClass'            =>  '',
            'contentLayout'             =>  $data['contentLayout'],
            'sidebarPositionClass'      =>  $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass'       =>  $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType'            =>  $data['mainLayoutType'],
            'defaultLanguage'           =>  $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction'                 =>  $data['direction'],
        ];
        
        if(!session()->has('locale'))                       app()->setLocale($layoutClasses['defaultLanguage']);
        if($layoutClasses['sidebarCollapsed'] == 'true')    $layoutClasses['sidebarClass'] = "menu-collapsed";
        if($layoutClasses['blankPage'] == 'true')           $layoutClasses['blankPageClass'] = "blank-page";
        
        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs) {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if(App()->environment() === 'production') {
            for($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if($contains === true)  $demo = 'demo-' . $i;
            }
        }
        if(isset($pageConfigs)) {
            if(count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.'.$demo.'.'.$config, $val);
                }
            }
        }
    }
    public static function dashUpdatePageConfig($pageConfigs) {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if(App()->environment() === 'production') {
            for($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if($contains === true)  $demo = 'demo-' . $i;
            }
        }
        if(isset($pageConfigs)) {
            if(count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.'.$demo.'.'.$config, $val);
                }
            }
        }
    }

    public static function __getDataValueFromDataId($model, $id){
        $modelClass = "\App\Models\Masters\\".$model;
        $modelObj = new $modelClass();
        $__data = $modelObj::whereNotNull('name')->where('id', $id)->get();
        $returnData = array();
        if(isset($__data) && count($__data)>0){
            foreach($__data as $_dts){
                $returnData[] = $_dts->name;
            }
        }
        return implode(', ', $returnData);
    }

    public static function __getValueFromId($model, $id){
        $modelClass = "\App\Models\Masters\\".$model;
        $modelObj = new $modelClass();
        $__data = $modelObj::whereNotNull('name')->whereIn('id', $id)->get();
        $returnData = array();
        if(isset($__data) && count($__data)>0){
            foreach($__data as $_dts){
                $returnData[] = $_dts->name;
            }
        }
        return implode(', ', $returnData);
    }

    public static function __getValueFromIdByRootModel($model, $id){
        $modelClass = "\App\Models\\".$model;
        $modelObj = new $modelClass();
        $__data = $modelObj::whereNotNull('name')->whereIn('id', $id)->get();
        $returnData = array();
        if(isset($__data) && count($__data)>0){
            foreach($__data as $_dts){
                $returnData[] = $_dts->name;
            }
        }
        return implode(', ', $returnData);
    }

    public static function __diabledToFields($blocked_fields, $field){
        if(isset($blocked_fields) && is_array($blocked_fields) && in_array($field, $blocked_fields))     echo 'disabled="disabled"';
    }

    public static function __alertPlanUpgradePopupHover($blocked_fields, $field){
        if(isset($blocked_fields) && is_array($blocked_fields) && in_array($field, $blocked_fields))
            echo '<button type="button" data-toggle="popover" class="btn p-0 m-0 ml-3" data-content="'.__('locale.UpgradePackageText.text').'" data-trigger="hover" data-original-title="'.__('locale.UpgradePackage.caption').'"><i data-feather="alert-triangle" class="text-danger"></i> </button>';
    }

    public static function __alertInformationPopupHover($field){
        echo '<button type="button" data-toggle="popover" class="btn p-0 m-0 ml-2" data-content="'.__('locale.'.$field.'.text').'" data-trigger="hover" data-original-title="'.__('locale.'.$field.'.caption').'"><i data-feather="info" class="text-info"></i> </button>';
    }

    public static function __alertPopupHoverOnFormFields($field){
        $fieldArr = explode('|', $field);
        if(is_array($fieldArr) && count($fieldArr)>0){
            $TitleArr = [];
            foreach($fieldArr as $fl){
                $titleText = __('locale.'.$fl.'.text');
                if(!empty($titleText))  $TitleArr[] = $titleText;
            }
        }
        if(is_array($TitleArr) && count($TitleArr)>0) {
            $title = implode(' ', $TitleArr);
            echo ' data-toggle="tooltip" data-placement="top" title="'. $title.'" ';    
        }    
    }

    public static function __alertSingleLinePopupHover($field){
        //echo 'data-toggle="tooltip" data-placement="top" title="'.__('locale.'.$field.'.caption').'"';
        echo 'data-toggle="popover" data-original-title="'.__('locale.'.$field.'.caption').'" data-content="'.__('locale.'.$field.'.text').'" data-trigger="hover" data-animation="false"';
    }

    public static function __setMaxLengthDisplayFun($str, $max, $used=0){
        echo '<small class="textarea-counter-value.'.$str.' textarea-counter-value float-right"><span class="char-count-'.$str.' char-count">'.$used.'</span> / '.$max.'</small>';
    } 

    public static function __makeMeImplode($data, $seperator){
        if(is_array($data) && count($data)>0)   return implode($seperator, $data);
        return '';
    }

    public static function __makeMeExplode($data, $seperator){
        if(!empty($data))   return explode($seperator, $data);
        return [];
    }

    public static function __makeStockMetaSettings(){
    }

    public static function __splitNumChar($str){
        $arr = str_split($str);
        $i   = 0;
        foreach ($arr as $v) {
            if(is_numeric($v) && $v != '0') break;
            ++$i;
        }
        return $i;
    }

    public static function __setIdsAsPerLoggedUser($request){
        if(Auth::user()->user_type == 'Admin' || Auth::user()->user_type == 'Admin-Staff') {
            if(isset($request['dealer_id']) && $request['dealer_id']>0) {
                self::$companies_id   = $request['dealer_id'];
                self::$created_by_id  =  self::$companies_id;
            }
        }
        else if(Auth::user()->user_type == 'Company') {
            $user = Auth::user()->load('company');
            self::$companies_id  = $user->company->id;
            self::$created_by_id = self::$companies_id;
        }
        elseif(isset($request['dealer_id']) && $request['dealer_id']>0) {
            self::$companies_id  = $request['dealer_id'];
            self::$created_by_id = Auth::user()->id;
        }
    }

    public static function __setWhereConditionAsPerLogged(){
        if(Auth::user()->user_type == 'Admin' || Auth::user()->user_type == 'Admin-Staff')  return 0;
        else if(Auth::user()->user_type == 'Company') {
            $user = Auth::user()->load('company');
            return $user->company->id;
        }
    }

    public static function __setDealerIdOnBassisOfStaffs(){
        if(Auth::user()->user_type == 'Staff'){
            $user = Auth::user();
            $user->load('staffs');
            if(isset($user->staffs->company_id) && $user->staffs->company_id>0) {
                $comp = Companies::where('ref_id', $user->staffs->company_id)->first(['id']);
                self::$companies_id = $comp->id;
            }
        }
    }

    public static function __setDefaultSearchParams($data_query){
        if(Auth::user()->user_type == 'Admin'){ }
        elseif(Auth::user()->user_type == 'Company'){
            $user = Auth::user()->load('company');
            $data_query->where('companies_id', $user->company->id);
        }
        else{
            $data_query->where('created_by_id', Auth::id());
        }
        return $data_query;
    }

    ####    VEHICLE MANAGER SETTING HELPERS FUNCTIONS FOR CHECK SPECIAL PRICE COMPARE TO REGULAR PRICE ####
    public static function __checkSpecialPriceLessThanToRegularPrice(){
        self::$returnMessage = '';
        if(self::$specialPrice>0 && self::$regularPrice>0){
            self::__getCurrencyWiseSpecialPriceDifference();
            
            if((self::$regularPrice - self::$specialPrice) < self::$DifferenceSpecialAndRegularPrice){
                //echo '<br/>self::$regularPrice: '.self::$regularPrice;
                //echo '<br/>self::$specialPrice: '.self::$specialPrice;
                //echo '<br/>self::$DifferenceSpecialAndRegularPrice: '.self::$DifferenceSpecialAndRegularPrice;
                //echo '<br/>self::$Difference: '.(self::$regularPrice - self::$specialPrice);
                $message = [
                    self::__getWebCaptionMessage('Special_Offer_Price_Should_Be'),
                    number_format(self::$DifferenceSpecialAndRegularPrice),
                    self::$currency,
                    self::__getWebCaptionMessage('Less_Than_Regular_Price')
                ];
                self::$returnMessage = implode(' ', $message);
            }
        }
    }
    public static function __getWebCaptionMessage($caption){
        $lang = config('app.locale');
        $data = WebCaptions::where('name', $caption)->first();
        $WebCaptionMessageText = self::__getCaptionAndTextFromWebCaptionLangWise($lang, $data);
        return $WebCaptionMessageText;
    }
    public static function __getCurrencyWiseSpecialPriceDifference(){        
        $data = Currencies::where('name', self::$currency)->first(['special_price_difference']);
        if(isset($data->special_price_difference))  self::$DifferenceSpecialAndRegularPrice = $data->special_price_difference;
    }
    public static function __getCaptionAndTextFromWebCaptionLangWise($webLang, $wCap){
        if(isset($wCap->$webLang)){
            $capData = (array)json_decode($wCap->$webLang);
            if(isset($capData['caption']))  return $capData['caption'];
        }
    } 

    ####    VEHICLE MANAGER SETTING HELPERS FUNCTIONS FOR CHECK SPECIAL PRICE STOCK AVAILABILITY ENTRY FOR EVERY DEALER    ####
    public static function __checkSpecialPriceStockAvailability($companies_id){
        $ttlLimit           =   500;
        $ttlRecords         =   0;
        $ttlSpecialRecords  =   0;
        $ttlSpecialBalance  =   0;
        $ttlSpecialUploaded =   0;
        
        $ttlRecords = Vehicles::where('companies_id', $companies_id)->count();

        if($companies_id>0 && $ttlRecords>0){            
            $ttlSpecialUploaded     =   Vehicles::where('companies_id', $companies_id)->where('discounted_price', '>', 0)->count();
            $ttlSpecialRecordsLimit =   floor(($ttlRecords*40)/100);
            $ttlSpecialBalance      =   $ttlSpecialRecordsLimit - $ttlSpecialUploaded;   
        }
        return [
            'ttlLimit'              =>  $ttlLimit,
            'ttlRecords'            =>  $ttlRecords,
            'ttlBalance'            =>  $ttlLimit-$ttlRecords,
            'ttlSpecialRecords'     =>  $ttlSpecialRecordsLimit,
            'ttlSpecialUploaded'    =>  $ttlSpecialUploaded,  
            'ttlSpecialBalance'     =>  $ttlSpecialBalance,    
        ];
    }
}

