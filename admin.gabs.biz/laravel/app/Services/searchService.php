<?php
namespace App\Services;
use App\Helpers\Helper;
use App\Models\Masters\Languages;
use Auth;

use Illuminate\Support\Facades\DB;

class searchService{
    public $datatable;
    public $params;
    public $filters;
    public $data_query;
    public $collection;
    public $keywords;
    public $keywords_params;
    public $orderSets;
    
    public function __construct($request, $data_query, $datatable) {
        $this->datatable    =   $datatable;
        $this->collection   =   $request;
        $this->data_query   =   $data_query;
        $this->search_data  =   '';
        $this->params       =   [];
        $this->filters      =   [];
        $this->orderSets    =   [];
    }
    public function setSearchConditions(){ 
        $this->data_query = Helper::__setDefaultSearchParams($this->data_query);
        $this->getSearchParams();  
        $this->setDataSortingParams();   
    }
    public function getSearchParams(){
        // dd($this->collection);
        if(isset($this->params) && count($this->params)>0){
            foreach($this->params as $index=>$indexData){
                $datacol        =   $indexData['datacol'];
                $dataval        =   $indexData['dataval'];
                $search_type    =   $indexData['search_type'];
                if($dataval==-1)    $dataval = '';    
                if(!empty($dataval))    $this->setSearchParams($search_type, $datacol, $dataval);
            }
        } 
        if(isset($this->filters) && count($this->filters)>0){
            foreach($this->filters as $index=>$indexData){
                $datacol        =   $indexData['datacol'];
                $dataval        =   $indexData['dataval'];
                $search_type    =   $indexData['search_type'];
                if($dataval==-1)    $dataval = '';
                if(!empty($dataval))    $this->setSearchParams($search_type, $datacol, $dataval);
            }
        } 

        if(isset($this->collection)){
            $search_data = $this->collection;
            // dd($search_data);
            $this->data_query->where(function($query) use ($search_data) {
                foreach($search_data as $val){
                    if(isset($val['searchable']) && $val['searchable'] == true){
                        if(!empty($val['data'])){
                            if(isset($val['search']['value']) && !empty($val['search']['value']))
                                $this->data_query->where($val['data'], 'LIKE', $val['search']['value'].'%');
                            else{                                
                                if(isset($this->collection->search['value']) && !empty($this->collection->search['value']))
                                    $this->data_query->where($val['data'], 'LIKE', $this->collection->search['value'].'%'); 
                            }
                        }   
                    }
                    else {
                        if(!empty($val['data'])){
                            if(isset($this->collection->search['value']) && !empty($this->collection->search['value']))
                                $this->data_query->where($val['data'], 'LIKE', $this->collection->search['value'].'%');   
                        } 
                    }         
                }
            });   
        } 

        // if ( isset($this->search_data) ) {
        //     $this->data_query->where(, 'LIKE', $this->search_data['value'].'%');
        // }
    }
    public function setDataSortingParams(){
        if(isset($this->orders[0]['column'])){
           $this->orderSets['order']    =    $this->collection[$this->orders[0]['column']]['data'];
           $this->orderSets['orderBy']  =    $this->orders[0]['dir'];
        }        
    }
    public function setSearchParams($search_type, $datacol, $dataval){
        // dd($search_type);
        switch($search_type){
            case 'like':
                $this->data_query->where($datacol, 'LIKE', '%'.$dataval.'%'); 
                break;
            case 'greater_than':
                $datacol = str_replace('_from', '', $datacol);
                $this->data_query->where($datacol, '>=', $dataval);
                break;
            case 'less_than':
                $datacol = str_replace('_to', '', $datacol);
                $this->data_query->where($datacol, '<=', $dataval);
                break;
            case 'range':
                $dataval_arr = explode('~', $dataval);
                if(is_array($dataval_arr) && count($dataval_arr)>0){
                    if(isset($dataval_arr[0]) && !empty($dataval_arr[0]))   $this->data_query->where($datacol, '>=', $dataval_arr[0]); 
                    if(isset($dataval_arr[1]) && !empty($dataval_arr[1]))   $this->data_query->where($datacol, '<=', $dataval_arr[1]);   
                }
                break;
            case 'date':
                $this->data_query->where(DB::raw('DATE('.$datacol.')'), '=', $dataval);
                break;
            case 'keyword':
                $this->setKeywordForSearch($dataval);                
                break;
            default:
                $this->data_query->where($datacol, $dataval); 
                break;
        }     
    }
    public function setKeywordForSearch($dataval){
        $this->keywords = explode(' ', $dataval);
        $this->setKewordsSearchParams();
        if(is_array($this->keywords) && count($this->keywords)>0){
            foreach($this->keywords as $keys){
                if(is_array($this->keywords_params) && count($this->keywords_params)>0){
                    $this->data_query->where(function($query) use ($keys) {
                        foreach($this->keywords_params as $params){
                            $query->orWhere($params, 'LIKE', '%'.$keys.'%');
                        } 
                    });                    
                }    
            }
        }
    }
    public function setKewordsSearchParams(){        
        switch($this->datatable){
            case 'vehicle_details':
                $this->keywords_params = [
                    'stock_number', 'location', 'vehicle_condition', 'vehicle_title', 'type', 'subtype',
                    'maker', 'model', 'modelcode', 'transmission', 'fuel', 'color', 'chassis_no',
                    'stock_title', 'dealer_shortname', 'mfg_year', 'reg_year'
                ];
                break;
            case 'web_captions':
                $this->keywords_params = ['name'];
                $this->webLanguages = Languages::where('for_web', 'Yes')->get(['alias']);
                if(isset($this->webLanguages) && count($this->webLanguages)>0){
                    foreach($this->webLanguages as $webLang){
                        $this->keywords_params[] = $webLang->alias;   
                    }
                }
                break;
        }     
    }
}

// if(isset($this->collection)){
//     $search_data = $this->collection;
//     $this->data_query->where(function($query) use ($search_data) {
//         foreach($search_data as $val){
//             if(isset($val['searchable']) && $val['searchable'] == true){
//                 if(!empty($val['data'])){
//                     if(isset($val['search']['value']) && !empty($val['search']['value']))
//                         $this->data_query->where($val['data'], 'LIKE', $val['search']['value'].'%');
//                     else{                                
//                         if(isset($this->collection->search['value']) && !empty($this->collection->search['value']))
//                             $this->data_query->where($val['data'], 'LIKE', $this->collection->search['value'].'%'); 
//                     }
//                 }   
//             }
//             else {
//                 if(!empty($val['data'])){
//                     if(isset($this->collection->search['value']) && !empty($this->collection->search['value']))
//                         $this->data_query->where($val['data'], 'LIKE', $this->collection->search['value'].'%');   
//                 } 
//             }         
//         }
//     });   
// }