<?php

namespace App\Traits;

use App\Observers\MasterDataTranslationObserver;

trait MasterDataTrait
{   
   
    public static function bootMasterDataTrait()
    {
        static::observe(new MasterDataTranslationObserver);
    }
}
?>