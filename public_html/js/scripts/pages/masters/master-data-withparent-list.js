/*=========================================================================================
  File Name: master-data-withparent-list.js
  Description: List page
==========================================================================================*/
$(function () {
  'use strict';

  var commonDataTable ;

  var dtUserTable = $('.data-list-table'),
    newSidebar = $('.new-data-modal'),
    newUserForm = $('.add-data-modal'),
    statusObj = {
      'No': { title: 'No', class: 'badge-light-warning' },
      'Yes': { title: 'Yes', class: 'badge-light-success' }
    };

    var groupColumn = 1;

  // Users List datatable
  if (dtUserTable.length) {

    commonDataTable = dtUserTable.DataTable({
      rowGroup: { dataSrc: 1 },
      order: [[1, 'asc']],
      serverSide: true,
      processing: true,
      cache: false,
      pageLength: 50,
      lengthMenu: [ [50, 100, 200], [50, 100, 200] ],
      ajax: baseUrl+'/getJsonList', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: 'id' },
        { data: 'name' },
        { data: 'parent' },
        { data: 'display' },
        { data: '' }
      ],
      columnDefs: [
        // { visible: false, targets: groupColumn },
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          // Name
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['name'];
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="d-flex flex-column">' + '<span class="font-weight-bold">' + $name + '</span>' + '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Parent Name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $parent = '';
            if(data==null)  $parent = '--';
            else $parent = data['name'];
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="d-flex flex-column">' +
                '<span class="font-weight-bold">' + $parent + '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // User Status
          targets: 3,
          render: function (data, type, full, meta) {
            var $checked = '';
            if(full['display'] == 'Yes')  $checked = ' checked="checked" ';
            var $row_output = '<div class="form-group"><div class="custom-control custom-control-success custom-checkbox">' + 
              '<input class="custom-control-input" style="opacity:1 !important;" type="checkbox" onclick="___updateDisplayStatus('+full['id']+');" value="'+full['id']+'" id="checkbox' + full['id'] +'" '+$checked+'/>'+
              '</div></div>';
              return $row_output;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="btn-group">' +
              '<a href="javascript:void(0)" data-toggle="modal" data-target="#modals-slide-in" class="dropdown-item" onclick="___getEditableRecords('+full['id']+');">' + feather.icons['edit'].toSvg({ class: 'font-small-4 mr-50' }) + '</a>' +
              '<a href="javascript:void(0)" class="dropdown-item delete-record" onclick="___deleteRecord('+full['id']+');">' + feather.icons['trash-2'].toSvg({ class: 'font-small-4 mr-50' }) + '</a>' +
              '</div>'
            );
          }
        }
      ],
      
      dom:
        '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
        '<"col-lg-12 col-xl-6" l>' +
        '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' + '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: 'Add New',
          className: 'add-new btn btn-primary mt-50',
          attr: {
            'data-toggle': 'modal',
            'data-target': '#modals-slide-in',
            'onclick': '___clearInputRecords()'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table',
            columnDefs: [
              {
                targets: 2,
                visible: false
              },
              {
                targets: 3,
                visible: false
              }
            ]
          })
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      },
      drawCallback: function(settings) {
        /*var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;

        api.column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                if (last !== group) {
                    $(rows)
                        .eq(i)
                        .before('<tr class="group"><td colspan="4">' + group + '</td></tr>');

                    last = group;
                }
            });*/
      }
    });

  
  }

  // Order by the grouping
    

  // Check Validity
  function checkValidity(el) {
    if(el.validate().checkForm()) submitBtn.attr('disabled', false);
    else                          submitBtn.attr('disabled', true);
  }

  // Form Validation
  if(newUserForm.length) {
    newUserForm.validate({errorClass:'error', rules:{'name':{required:true}}});
    newUserForm.on('submit', function(e){ var isValid = newUserForm.valid(); e.preventDefault(); if(isValid) ___saveDataFromSidebarModel(newSidebar);});
  }

  // To initialize tooltip with body container
  $('body').tooltip({ selector: '[data-toggle="tooltip"]', container: 'body' });
});
