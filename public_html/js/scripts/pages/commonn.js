//const { LazyResult } = require("postcss");

function ___bottomEndSweetAlert(msg, icon, ConfirmButtonFlag) {
    Swal.fire({
        position: 'bottom-end',
        icon: icon,
        title: msg,
        showConfirmButton: ConfirmButtonFlag,
        timer: 2000,
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
}

function ___centerSweetAlert(msg, icon, ConfirmButtonFlag) {
    Swal.fire({
        icon: icon,
        title: msg,
        showConfirmButton: ConfirmButtonFlag,
        timer: 3000,
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
}

function ___call_Ajax_Set_Data(ajaxurl, params, executeClass) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    $.post(ajaxurl, params,
        function(returnedData) {
            $('.' + executeClass).each(function() {
                $(this).empty();
                var selectAjax = $(this);
                var dataValue = selectAjax.attr('data-value');
                var JsonFormatData = returnedData['data'];
                selectAjax.wrap().select2({
                    dropdownAutoWidth: true,
                    dropdownParent: selectAjax.parent(),
                    data: JsonFormatData
                });
                selectAjax.val(dataValue);
                $(".selection span #select2-" + selectAjax.attr('id') + "-container").html($('#' + selectAjax.attr('id') + ' option:selected').text());
            });
        }
    );
}

function ___call_Ajax(method, ajaxurl, params, stop_to_reload, ttl = '') {
    if (ttl == '') ttl = 'Do you want to update this records ?';
    Swal.fire({
        title: ttl,
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, updated it!',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function(result) {
        if (result.value) {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
                type: method,
                url: ajaxurl,
                data: params,
                dataType: 'json',
                sync: true,
                success: function(data) {
                    Swal.fire({
                        icon: data['icon'],
                        title: data['title'],
                        text: data['message'],
                        customClass: { confirmButton: 'btn btn-success' }
                    });
                    if (stop_to_reload == 'Yes') {
                        if (data['status'] == true) setTimeout(function() { window.location.href = window.location.href; }, 2000);
                    }
                }
            });
        }
    });
}

function ___call_Ajax_Without_Alert(method, ajaxurl, params, stop_to_reload) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        type: method,
        url: ajaxurl,
        data: params,
        dataType: 'json',
        sync: true,
        success: function(data) {
            Swal.fire({
                icon: data['icon'],
                title: data['title'],
                text: data['message'],
                timer: 2000
            });
            if(stop_to_reload == 'Yes') {
                if (data['status'] == true) setTimeout(function() { window.location.href = window.location.href; }, 1500);
            }
        }
    });
}

function ___resoreRecord(id) {
    Swal.fire({
        title: 'Do you want to restore records?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function(result) {
        if (result.value) {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
            var type = "POST";
            var ajaxurl = baseUrl + '/restore/' + id;
            $.ajax({
                type: type,
                url: ajaxurl,
                dataType: 'json',
                sync: true,
                success: function(data) {
                    Swal.fire({
                        icon: data['icon'],
                        title: data['title'],
                        text: data['text'],
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    if (data['status'] == true) setTimeout(function() { window.location.href = window.location.href; }, 2000);
                }
            });
        }
    });
}

function ___deleteRecord(id) {
    Swal.fire({
        title: 'Do you want to delete records?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function(result) {
        if (result.value) {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
            var type = "POST";
            var ajaxurl = baseUrl + '/delete/' + id;
            $.ajax({
                type: type,
                url: ajaxurl,
                dataType: 'json',
                sync: true,
                success: function(data) {
                    Swal.fire({
                        icon: data['icon'],
                        title: data['title'],
                        text: data['text'],
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    // if (data['status'] == true) setTimeout(function() { window.location.href = window.location.href; }, 2000);

                    if (data['status'] == true) setTimeout(function() { 
                        dtTable.ajax.reload();
                    }, 2000);
                }
            });
        }
    });
}

function ___saveDataFromSidebarModel(newSidebar) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    var formData = $('#modelForm').serialize();
    var type = "POST";
    var ajaxurl = baseUrl + '/store';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        sync: true,
        success: function(data) {
            if (data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
                newSidebar.modal('hide');
                ___bottomEndSweetAlert(msg, icon, false);
            } else {
                if (data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message']['name'];
                    ___centerSweetAlert(msg, icon, false);
                }
            }

            // if (data['status'] == true) setTimeout(function() { window.location.href = window.location.href; }, 2000);
            if (data['status'] == true) setTimeout(function() { 
                dtTable.ajax.reload();
            }, 2000);
        }
    });
}

function ___clearInputRecords() {
    $("#modals-slide-in")
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
}

function ___getEditableRecords(id) {
    var type = "GET";
    var ajaxurl = baseUrl + '/edit/' + id;
    $.ajax({
        type: type,
        url: ajaxurl,
        dataType: 'json',
        sync: true,
        success: function(data) {
            $("#parent_id option").show();
            if(data['status'] == true) {
                $('#name').val(data['data']['name']);
                $('#parent_id').val(data['data']['parent_id']);
                if(data['data']['regions_id'] != undefined) $('#regions_id').val(data['data']['regions_id']);
                if(data['data']['countries_id'] != undefined) $('#countries_id').val(data['data']['countries_id']);
                if(data['data']['maker_id'] != undefined) {
                    $('#maker_id').val(data['data']['maker_id']);
                    var makerObj = $('#maker_id');
                    if(data['data']['model_id'] != undefined) insertId = data['data']['model_id'];
                    ___getDropDownData('model_id', makerObj, 'Models', true);
                }
                else if (data['data']['model_id'] != undefined) $('#model_id').val(data['data']['model_id']);
                
                if(data['data']['option_id'] != undefined) $('#option_id').val(data['data']['option_id']);
                if(data['data']['type_id'] != undefined) $('#type_id').val(data['data']['type_id']);
                if(data['data']['length'] != undefined) $('#length').val(data['data']['length']);
                if(data['data']['width'] != undefined) $('#width').val(data['data']['width']);
                if(data['data']['height'] != undefined) $('#height').val(data['data']['height']);
                if(data['data']['m3'] != undefined) $('#m3').val(data['data']['m3']);
                if(data['data']['symbol'] != undefined) $('#symbol').val(data['data']['symbol']);
                if(data['data']['caption'] != undefined) $('#caption').val(data['data']['caption']);
                if(data['data']['alias'] != undefined) $('#alias').val(data['data']['alias']);
                if(data['data']['orders'] != undefined) $('#orders').val(data['data']['orders']);
                if(data['data']['phone_code'] != undefined) $('#phone_code').val(data['data']['phone_code']);
                if(data['data']['country_code'] != undefined) $('#country_code').val(data['data']['country_code']);
                if(data['data']['url'] != undefined) $('#url').val(data['data']['url']);
                //if(data['data']['icon']!=undefined)         $('#icon').val(data['data']['icon']);
                if(data['data']['description'] != undefined) $('#description').val(data['data']['description']);
                if(data['data']['imported'] != undefined) $('#imported').val(data['data']['imported']);
                if(data['data']['amount'] != undefined) $('#amount').val(data['data']['amount']);
                if(data['data']['special_price_difference'] != undefined) $('#special_price_difference').val(data['data']['special_price_difference']);
                if(data['data']['icon'] != undefined) $('#upload-img').attr('src', window.location.origin + '/uploads/banks/' + data['data']['icon']);

                if(data['data']['display'] == 'Yes') $('#display').attr('checked', 'checked');
                else $('#display').removeAttr('checked');
                $('#id').val(data['data']['id']);
                $("#parent_id option[data-index=" + data['data']['id'] + "]").hide();
            }
        }
    });
}

function ___updateForWebStatus(id) {
    var $for_web = 'No';
    if ($('#checkbox' + id).prop('checked') == true) $for_web = 'Yes';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    var formData = 'for_web=' + $for_web + '&id=' + id;
    var type = "POST";
    var ajaxurl = baseUrl + '/update-forweb-status';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        sync: true,                                                              
        success: function(data) {
            if (data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
                $('#checkbox_forweb' + id).attr('disabled', 'disabled');
                ___bottomEndSweetAlert(msg, icon, false);
            } else {
                if (data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message'];
                    $('#checkbox_forweb' + id).prop('checked', false);
                    ___centerSweetAlert(msg, icon, false);
                }
            }
        }
    });
}

function ___updateDisplayStatus(id) {
    var $display = 'No';
    if ($('#checkbox' + id).prop('checked') == true) $display = 'Yes';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    var formData = 'display=' + $display + '&id=' + id;
    var type = "POST";
    var ajaxurl = baseUrl + '/update-status';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
                ___bottomEndSweetAlert(msg, icon, false);
            } else {
                if (data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message']['name'];
                    ___centerSweetAlert(msg, icon, false);
                }
            }
        }
    });
}

function ___updateAsFromStatus(id) {
    var $as_from = 'No';
    if ($('#AsFrom' + id).prop('checked') == true) $as_from = 'Yes';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    var formData = 'as_from=' + $as_from + '&id=' + id;
    var type = "POST";
    var ajaxurl = baseUrl + '/update-Asfrom';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
                ___bottomEndSweetAlert(msg, icon, false);
            } else {
                if (data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message']['name'];
                    ___centerSweetAlert(msg, icon, false);
                }
            }
        }
    });
}

function ___updateServiceStatus(id) {
    var $is_service = 'No';
    if ($('#checkbox' + id).prop('checked') == true) $is_service = 'Yes';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    var formData = 'is_service=' + $is_service + '&id=' + id;
    var type = "POST";
    var ajaxurl = baseUrl + '/update-status';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
            } else {
                if (data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message']['name'];
                }
            }
            ___bottomEndSweetAlert(msg, icon, false);
        }
    });
}

function ___updateOtherStatus(id){
    var $value = 'No';
    if($('#checkbox' + id).prop('checked') == true) $value = 'Yes';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':jQuery('meta[name="csrf-token"]').attr('content')}});

    var $col        =   $('#checkbox' + id).attr('data-col');
    var $mode       =   $('#checkbox' + id).attr('data-mode');
    var $is_master  =   $('#checkbox' + id).attr('data-master');

    var formData = 'id=' + id + '&col=' + $col + '&value=' + $value + '&mode=' + $mode + '&is_master=' + $is_master;
    var type = "POST";
    var ajaxurl = '/status-manager/update-other-status';
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function(data) {
            if(data['status'] == true) {
                var icon = data['icon'];
                var msg = data['message'];
                ___bottomEndSweetAlert(msg, icon, false);
            } 
            else {
                if(data['status'] == false) {
                    var icon = data['icon'];
                    var msg = data['message']['name'];
                    ___centerSweetAlert(msg, icon, false);
                }
            }
        }
    });
}

function getDealerData(dealerId) {
    if (dealerId != '') {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: '/get-dealer',
            type: 'POST',
            data: { dealer_id: dealerId },
            dataType: 'html',
            beforeSend: function() {
                $('div#dealer-details').removeClass('d-none');
                var loader = '<button class="btn btn-outline-primary d-flex mx-auto" type="button" disabled>';
                loader += '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                loader += '<span class="ml-25 align-middle">Loading...</span></button>';
                $('div#dealer-details').html(loader);
            },
            success: function(response) {
                $('div#dealer-details').html(response);
                var defaultcurrmult = $('#dealer_currencies').val();
                var defaultcurr = $('#dealer_default_currency').val();
                var dealercountry = $('#dealer_countryId').val();
                __dealerdefault(defaultcurr, defaultcurrmult, dealercountry);
                var params = {
                    mode: 'Yards',
                    is_parent_master: 'No',
                    is_multiple: 'No',
                    data_relation: 'No',
                    dealer_id: dealerId
                };
                ___call_Ajax_Set_Data('/masters/get-master', params, 'YardLocation');

            }
        });
    } else { $('div#dealer-details').html(''); }
}

function __dealerdefault(defaultcurr, defaultcurrmult, dealercountry) {
    $('.curren').html(defaultcurr);

    $('#location_id option').each(function() {
        var dealer_country = $(this).text();
        var dealer_country = dealer_country.split(",");
        if (isInArray(dealercountry, dealer_country) == true) {
            $(this).attr("selected", "selected");
            $(".selection span #select2-location_id-container").html(dealercountry);
        }
    });

    const e = new Event("change");
    const element = document.querySelector('#location_id')
    element.dispatchEvent(e);

    var multpcurr = defaultcurrmult.split(",");
    $('#currencies_id option').each(function() {
        var dealer_curren = $(this).text();
        if (defaultcurr == dealer_curren) {
            $(this).attr("selected", "selected");
            $(".selection span #select2-currencies_id-container").html(defaultcurr);
        }
        if (isInArray(dealer_curren, multpcurr) == false) $(this).remove();
    });
}
var JsonToArrayData = [];

function json2array() {
    var keys = Object.keys(lang_data);
    keys.forEach(function(key) {
        JsonToArrayData[key] = lang_data[key].caption;
    });
}

function isInArray(value, array) {
    var returnFlag = array.indexOf(value) > -1;
    console.log(returnFlag);
    return returnFlag;
}
/*function isInArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle)   return true;
    }
    return false;
}*/

json2array();

function __alertPopupHoverOnFormFields(field, thisObj) {
    var myArray = field.split("|");
    var tltArr = [];
    for (k in myArray) {
        tltArr.push(JsonToArrayData[myArray[k]]);
    }
    var tltArrStr = tltArr.join(' ');
    $(thisObj).attr('data-toggle', 'tooltip');
    $(thisObj).attr('data-placement', 'top');
    $(thisObj).attr('title', tltArrStr);
    $(thisObj).attr('data-trigger', "manual");
}
$(document).on('change', '.set-value-attribute', function() {
    var thisObjName = $(this).attr('name');
    var thisObjId = $(this).attr('id');
    var thisObjvalue = $('#' + thisObjId + ' option:selected').text();
    if ($('#valueAttribute_' + thisObjId) != undefined && $('#valueAttribute_' + thisObjId).length > 0) $('#valueAttribute_' + thisObjId).remove();
    var htmlData = '<input type="hidden" value="' + thisObjvalue + '" id="valueAttribute_' + thisObjId + '" name="valueAttribute[' + thisObjName + ']"/>';
    $('.setValueAttributeDivSection').append(htmlData);
});
$(document).on('change', '.set-multiple-value-attribute', function() {
    var thisObjIndex = $(this).attr('data-row');
    var thisObjName = $(this).attr('name');
    var thisObjId = $(this).attr('id');
    var thisObjvalue = $('#' + thisObjId + ' option:selected').text();
    if ($('#valueAttribute_' + thisObjId + '_' + thisObjIndex) != undefined && $('#valueAttribute_' + thisObjId + '_' + thisObjIndex).length > 0) $('#valueAttribute_' + thisObjId + '_' + thisObjIndex).remove();
    var htmlData = '<input type="hidden" value="' + thisObjvalue + '" id="valueAttribute_' + thisObjId + '_' + thisObjIndex + '" name="Attribute_' + thisObjName + '"/>';
    $('.setValueAttributeDivSection').append(htmlData);
});

var PageLeaveActionOnFocusValue = '';
var PageLeaveActionOnBlurValue = '';

$('.page-leave-action').on('blur', function() {
    var selectAjax = $(this);
    var selectType = $(this).attr('type');
    ___getHtmlTagValueAsPerType(selectAjax, selectType, 'blur');
});
$('.page-leave-action').on('focus', function() {
    var selectAjax = $(this);
    var selectType = $(this).attr('type');
    ___getHtmlTagValueAsPerType(selectAjax, selectType, 'focus');
});

function ___getHtmlTagValueAsPerType(thisObj, selectType, action) {
    switch (selectType) {
        case 'text':
            if (action == 'blur') PageLeaveActionOnBlurValue = thisObj.val();
            else if (action == 'focus') PageLeaveActionOnFocusValue = thisObj.val();
            break;
        case 'radio':
        case 'checkbox':
            if (action == 'blur') PageLeaveActionOnBlurValue = thisObj.prop('checked');
            else if (action == 'focus') PageLeaveActionOnFocusValue = thisObj.prop('checked');
            break;
        case 'textarea':
            break;
        case 'select':
            break;
        default:
            if (action == 'blur') PageLeaveActionOnBlurValue = $(thisObj).find('span').html();
            else if (action == 'focus') PageLeaveActionOnFocusValue = $(thisObj).find('span').html();
            break;
    }

    if (action == 'blur') {
        ___checkFocusAndBlurValueBeforePageLeave();
    }
}

function ___checkFocusAndBlurValueBeforePageLeave() {
    if(PageLeaveActionOnBlurValue != PageLeaveActionOnFocusValue) isAnyEnteredOrUpdated = true;
    //console.log('PageLeaveActionOnFocusValue: '+PageLeaveActionOnFocusValue);
    //console.log('PageLeaveActionOnBlurValue: '+PageLeaveActionOnBlurValue);
    //console.log('isAnyEnteredOrUpdated: '+isAnyEnteredOrUpdated);
}

window.addEventListener("beforeunload", function(e) {
    isAnyEnteredOrUpdated = false;
    if (isAnyEnteredOrUpdated == true) {
        var confirmationMessage = 'It looks like you have been editing something. ' + 'If you leave before saving, your changes will be lost.';
        (e || window.event).returnValue = confirmationMessage;
        return confirmationMessage;
    }
});

$(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});
$(document).on('focus', '.select2 select2-container', function(e) {
    ___getHtmlTagValueAsPerType(this, 'focus');
});
$(document).on('blur', '.select2 select2-container', function(e) {
    ___getHtmlTagValueAsPerType(this, 'blur');
});
$('select.select2').on('select2:closing', function(e) {
    $(e.target).data("select2").$selection.one('focus focusin', function(e) { e.stopPropagation(); });
});

/*$(document).on('keydown', 'input, select', function(e) {
    if(e.shiftKey) {
        if(e.key === "Enter") {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
            focusable = form.find('input, a, select, button, textarea').filter(':visible');
            next = focusable.eq(focusable.index(this) - 1);
            if(next.length)    next.focus();
            return false;
        }
    }
    if(e.key === "Enter") {
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input, a, select, button, textarea').filter(':visible');
        next = focusable.eq(focusable.index(this) + 1);
        if(next.length) next.focus();
        return false;
    }
});*/