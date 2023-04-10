<?php

namespace App\Observers;

use App\Models\MasterDataTranslation;
use Illuminate\Database\Eloquent\Model;

class MasterDataTranslationObserver
{
    /**
     * Handle the MasterDataTranslation "created" event.
     *
     * @param  \App\Models\MasterDataTranslation  $masterDataTranslation
     * @return void
     */
    public function created($modal)
    {   
        $modalNamespace = get_class($modal);
        
        if(($modal->parent_id == "0") || $modal->parent_id == null ){

            $master_data_trans =  new MasterDataTranslation;
    
            if($master_data_value_exist =  $master_data_trans->where('value', $modal->name)->first())
            {
                $db_models =   $master_data_value_exist->db_models;
                if(!in_array($modalNamespace ,$db_models)){
                    array_push($db_models,$modalNamespace);
                    $master_data_value_exist->db_models = $db_models;
                    $master_data_value_exist->save();
                }
            }else{
                $master_data_trans->value = $modal->name;
                $master_data_trans->db_models = [$modalNamespace];
                $master_data_trans->save();
    
            }
        }

    }

    /**
     * Handle the MasterDataTranslation "updated" event.
     *
     * @param  \App\Models\MasterDataTranslation  $masterDataTranslation
     * @return void
     */
    public function updated($modal)
    {  
       
        
        $modalNamespace = get_class($modal);

        $masterDataTransModal  =  new MasterDataTranslation;

        $oldName =  $modal->getOriginal()['name'];                
        $oldParentId =  $modal->getOriginal()['parent_id'];                
        $newName =  isset($modal->getChanges()['name'])? $modal->getChanges()['name'] : $modal->getOriginal()['name'] ;
        $newParentId =  isset($modal->getChanges()['parent_id'])? $modal->getChanges()['parent_id'] : $modal->getOriginal()['parent_id'] ;

        //when parent is update and parent become child
        if(($oldParentId != $newParentId) && $newParentId != 0 ){
          //in this case we delete the model referance   
            if($oldValueExist =  MasterDataTranslation::where('value',$oldName)->first()){
                $oldDbModalData = $oldValueExist->db_models;
                if (($key = array_search($modalNamespace, $oldDbModalData)) !== false) {
                            unset($oldDbModalData[$key]);
                }
                //delete if $oldDbModalData is empty
                if(count($oldDbModalData) < 1){
                    $oldValueExist->delete();
                }else{
                    $oldValueExist->update(['db_models' => $oldDbModalData ]);
                }
    
            }  

        }else{

            // we have insert or update data in master_data_translatio db_models filed 
            //when the value is parent we don`t have entry for child
                // if($newName != $oldName){
                        //remove old values in master data translation db models array
            if($oldValueExist =  MasterDataTranslation::where('value',$oldName)->first()){
                $oldDbModalData = $oldValueExist->db_models;

                if (($key = array_search($modalNamespace, $oldDbModalData)) !== false) {
                    unset($oldDbModalData[$key]);
                }    
                //delete if $oldDbModalData is empty
                if(count($oldDbModalData) < 1){
                    $oldValueExist->delete();
                }else{
                    $oldValueExist->update(['db_models' => $oldDbModalData ]);
                }

            }

                //in case when the new  newName is exist in master data translation 
            if($value_exist =  $masterDataTransModal->where('value',$newName)->first()){
                $db_models =   $value_exist->db_models;
                //update and push new value in db_models array 
                array_push($db_models, $modalNamespace);
                $value_exist->update(['db_models' => $db_models ]);
            }else{

                $masterDataTransModal->value = $newName;
                $masterDataTransModal->db_models = [ $modalNamespace];
                $masterDataTransModal->save();
            }
        }



        // //in case when name is update and parent is update 
        // if( ($newName != $oldName) && ($oldParentId != $newParentId)  ){

        //      //remove old values in master data translation db models array
        //      if($oldValueExist =  MasterDataTranslation::where('value',$oldName)->first()){
        //         $oldDbModalData = $oldValueExist->db_models;

        //             if (($key = array_search($modalNamespace, $oldDbModalData))
        //                 !== false) {
        //                 unset($oldDbModalData[$key]);
        //             }
                    
        //             //delete if $oldDbModalData is empty
        //             if(count($oldDbModalData) < 1){
        //                 $oldValueExist->delete();
        //             }else{
        //                 $oldValueExist->update(['db_models' => $oldDbModalData ]);
        //             }

        //     }
        //         //in case when the new  newName is exist in master data translation 
        //     if($value_exist =  $masterDataTransModal->where('value',$newName)->first()){
        //         $db_models =   $value_exist->db_models;
        //         //update and push new value in db_models array 

        //         if(($oldParentId == 0) && ($newParentId > 0)){

        //             if (($key = array_search($modalNamespace, $db_models))
        //             !== false) {
        //             unset($db_models[$key]);
        //              }
        //              if(count($db_models) < 1){
        //                 $value_exist->delete();
        //             }else{
        //                 $value_exist->update(['db_models' => $db_models ]);
        //             } 

        //         }else{
        //             array_push($db_models, $modalNamespace);
        //             $value_exist->update(['db_models' => $db_models ]);
        //         }

        //     }else{
        //         if($newParentId == 0){
        //             $masterDataTransModal->value = $newName;
        //             $masterDataTransModal->db_models = [ $modalNamespace];
        //             $masterDataTransModal->save();
        //         }
        //     }

          
        //  //in case when only name is update    
        // }else if($newName != $oldName){
        //       //remove old values in master data translation db models array
        //       if($oldValueExist =  MasterDataTranslation::where('value',$oldName)->first()){
        //         $oldDbModalData = $oldValueExist->db_models;

        //             if (($key = array_search($modalNamespace, $oldDbModalData))
        //                 !== false) {
        //                 unset($oldDbModalData[$key]);
        //             }
                    
        //             //delete if $oldDbModalData is empty
        //             if(count($oldDbModalData) < 1){
        //                 $oldValueExist->delete();
        //             }else{
        //                 $oldValueExist->update(['db_models' => $oldDbModalData ]);
        //             }

        //     }
        //         //in case when the new  newName is exist in master data translation 
        //     if($value_exist =  $masterDataTransModal->where('value',$newName)->first()){
        //         $db_models =   $value_exist->db_models;
        //         //update and push new value in db_models array 
        //         array_push($db_models, $modalNamespace);
        //         $value_exist->update(['db_models' => $db_models ]);
        //     }else{

        //         $masterDataTransModal->value = $newName;
        //         $masterDataTransModal->db_models = [ $modalNamespace];
        //         $masterDataTransModal->save();
        //     }

        // }//in case when only parent id is change  
        // else if($oldParentId != $newParentId){

        //     if(($oldParentId == 0) && ($newParentId > 0)){

        //         //delete when a parent become child the we have delete the refrance
        //         // from master_data_translation->table  db_models->field  remove form array element or delete row
        //         $checkForParentUpdate =  MasterDataTranslation::where('value',$oldName)->first();

        //         $dbModeldata = $checkForParentUpdate->db_models;
        //         //search the model namespace and remove from array and 
        //         // if no value exist in array then delete the value else update the array 
        //         if (($key = array_search($modalNamespace, $dbModeldata))
        //                 !== false) {
        //                 unset($dbModeldata[$key]);
        //             }  
        //         if( count($dbModeldata) < 1){
        //                 $checkForParentUpdate->delete();
        //         }else{
        //             $checkForParentUpdate->update(['db_models' => $dbModeldata ]);
        //         }
        //     }
        // }

        


    }

    /**
     * Handle the MasterDataTranslation "deleted" event.
     *
     * @param  \App\Models\MasterDataTranslation  $masterDataTranslation
     * @return void
     */
    public function deleted($modal)
    {   
        
        $master_data_trans =  new MasterDataTranslation;
        $modalNamespace = get_class($modal);
            if($master_data_value_exist =  $master_data_trans->where('value', $modal->name)->first())
            {   

                $db_models_array = $master_data_value_exist->db_models;

                if(in_array($modalNamespace , $db_models_array) ){

                    if(count($db_models_array) == 1){
                        $master_data_value_exist->delete();
                    }else{
                        if (($key = array_search($modalNamespace, $db_models_array)) !== false) {
                            unset($db_models_array[$key]);

                            $master_data_value_exist->update(['db_models' => $db_models_array]);
                        }
                    }
                }
            }
    }

    /**
     * Handle the MasterDataTranslation "restored" event.
     *
     * @param  \App\Models\MasterDataTranslation  $masterDataTranslation
     * @return void
     */
    public function restored($modal)
    {
        //
    }

    /**
     * Handle the MasterDataTranslation "force deleted" event.
     *
     * @param  \App\Models\MasterDataTranslation  $masterDataTranslation
     * @return void
     */
    public function forceDeleted($modal)
    {
        //
    }
}
