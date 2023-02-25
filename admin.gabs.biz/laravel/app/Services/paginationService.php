<?php
namespace App\Services;

class paginationService{
    public $offset;
    public $limit;

    public function __construct() {
        $this->offset   =   0;
        $this->limit    =   50;
    }

    public function setPaginationData($request){
        if(isset($request->length)) $this->limit = $request->length;
        if(isset($request->start))  $this->offset = $request->start;
    }
}
