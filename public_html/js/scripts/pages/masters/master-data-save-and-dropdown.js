var data_id           = '';
var is_parent_master  = false;
var insertId          = 0;
var formData          = ''; 

var masterRoute = '/masters';

___openRightPanelModal = function(MasterModuleName, mode, dataId, isParentMaster, is_dealer_id=false){
  var newSidebar = $('.data-modal');
  $('#name').val('');
  $('#id').val('');
  $('#caption').html(MasterModuleName);
  $('#module').val(MasterModuleName);
  $('#name').attr('placeholder', 'Enter '+MasterModuleName);
  $('#mode').val(mode);
  if(is_dealer_id==true)  $('#dealer_id_modal').val($('#dealer_id').val());
  $('#modals-slide-in').modal();
  data_id = dataId;
  is_parent_master = isParentMaster;
  ___setReferncesModelValue();
}

___saveRightPanelModalData = function(){
  $.ajaxSetup({ headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')} });
  formData = $('#modelForm').serialize();
  ___setReferncesModelValue();
  var type = "POST";
  var ajaxurl = masterRoute+'/save-master';
  $.ajax({
    type:type,
    url:ajaxurl,
    data:formData,
    dataType:'json',
    success:function (data) {
      if(data['status'] == true){
        var icon = data['icon'];
        var msg  = data['message'];
        insertId = data['insert_id'];
        var newSidebar = $('.data-modal');
        newSidebar.modal('hide');
        ___fillMasterDataDropDown(data, data_id);
        ___bottomEndSweetAlert(msg, icon, false);
      }
      else{
        if(data['status'] == false){
          var icon = data['icon'];
          var msg  = data['message']['name']; 
          ___centerSweetAlert(msg, icon, false);
        }
      }      
    }
  });
}

___getMaster = function(mode, is_parent_master, data_id){
  var postData = 'mode='+mode+'&is_parent_master='+is_parent_master;
  var type = "POST";
  var ajaxurl = masterRoute+'/get-master'; 
  ___callAjaxToGetFillMasterData(postData, type, ajaxurl, data_id);
}

___fillMasterDataDropDown = function(data, data_id){
  $('#'+data_id).empty();
  if(data['data'].length>0){
    for(k in data['data']){
      $('#'+data_id).append($("<option></option>").attr("value", data['data'][k]['id']).text(data['data'][k]['name'])); 
    }
    if(parseInt(insertId)>0)  $('#'+data_id).val(insertId);
  }
}

___callAjaxToGetFillMasterData = function(postData, type, ajaxurl, data_id){
  $.ajaxSetup({ headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')} });
  $.ajax({type:type,url:ajaxurl,data:postData,dataType:'json',
    success:function(data) { ___fillMasterDataDropDown(data, data_id); }
  });  
}

___setReferncesModelValue = function(){
  switch(data_id){
    case 'subtype_id': $('#references').val('type_id|'+$('#type_id option:selected').val()); break;
    case 'model_id': $('#references').val('maker_id|'+$('#maker_id option:selected').val()); break;
    case 'modelcode_id': $('#references').val('model_id|'+$('#model_id option:selected').val()); break;
    default: $('#references').val(''); break;
  }   
}

___getDropDownData = function(master_id, thisObj, mode, is_parent_master){
  var thisObjId = $(thisObj).attr('id');
  var postData = 'mode='+mode+
  '&is_parent_master='+is_parent_master+
  '&obj_id='+thisObjId+
  '&obj_value='+$('#'+thisObjId+' option:selected').val();
  var type = "POST";
  var ajaxurl = masterRoute+'/get-master'; 
  ___callAjaxToGetFillMasterData(postData, type, ajaxurl, master_id);
}