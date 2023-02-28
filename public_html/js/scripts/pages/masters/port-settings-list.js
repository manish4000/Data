/*=========================================================================================
    File Name: regions-list.js
    Description: Regions List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
  'use strict';

  var dtUserTable = $('.data-list-table'),
    newSidebar = $('.new-data-modal'),
    newUserForm = $('.add-data-modal'),
    statusObj = {
      'No': { title: 'No', class: 'badge-light-warning' },
      'Yes': { title: 'Yes', class: 'badge-light-success' }
    };

  // Users List datatable
  if (dtUserTable.length) {
    dtUserTable.DataTable({
      ajax: baseUrl+'/getJsonList', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: 'id' },
        { data: 'country' },
        { data: 'port' },
        { data: 'inspection_id' },
        { data: 'shipping_methods' },
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          // Region Name
          targets: 1,
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
          // Region Name
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
          // User full name and username
          targets: 3,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['inspection_id'];
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="d-flex flex-column">' + '<span class="font-weight-bold">' + $name + '</span>' + '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // User full name and username
          targets: 4,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['shipping_methods'];
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-left align-items-center">' +
              '<div class="d-flex flex-column">' + '<span class="font-weight-bold">' + $name + '</span>' + '</div>' +
              '</div>';
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
        '<"col-sm-12 col-md-6"p>' +
        '>',
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
            'data-target': '#modals-slide-in'
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
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
          .columns(3)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="parent" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Filter by Display </option></select>'
            )
              .appendTo('.user_role')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
              });
          });
      }
    });
  }

  // Check Validity
  function checkValidity(el) {
    if (el.validate().checkForm()) {
      submitBtn.attr('disabled', false);
    } else {
      submitBtn.attr('disabled', true);
    }
  }

  // Form Validation
  if (newUserForm.length) {
    newUserForm.validate({
      errorClass: 'error',
      rules: {
        'name': {
          required: true
        }
      }
    });

    newUserForm.on('submit', function (e) {
      var isValid = newUserForm.valid();
      e.preventDefault();
      if (isValid) {
        ___saveDataFromSidebarModel(newSidebar);
      }
    });
  }

  // To initialize tooltip with body container
  $('body').tooltip({
    selector: '[data-toggle="tooltip"]',
    container: 'body'
  });
});
