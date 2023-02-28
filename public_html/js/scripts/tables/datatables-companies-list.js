'use strict';

// Filter column wise function
function filterColumn(i, val) {  
  var table = $('.dt-advanced-search').DataTable();
  table.column(i).search(val, false, true).draw();
}

$(function () {
  var dt_adv_filter_table = $('.dt-advanced-search'), assetPath = '../../../app-assets/';
  if($('body').attr('data-framework') === 'laravel')  assetPath = $('body').attr('data-asset-path');
  
  // Advanced Search
  // Advanced Filter table
  if(dt_adv_filter_table.length) {
    var dt_adv_filter = dt_adv_filter_table.DataTable({
      serverSide: true,
      processing: true,
      cache: false,
      pageLength: 50,
      lengthMenu: [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
      ajax: baseUrl+'/getJsonList',
      columns: [
        { data: 'id' },
        { data: 'membership_type' },
        { data: 'company_name' },
        { data: 'email1' },
        { data: 'short_name' },
        { data: 'city' },        
        { data: '' },
      ],
      columnDefs: [ 
        {
          className: 'control',
          orderable: true,
          responsivePriority: 7,
          targets: 0
        },
        {
          targets: 1,
          render: function (data, type, full, meta) {
            var $row_output = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column"><span class="font-weight-bold">' + full['membership_type'] + '</span></div></div>';
            return $row_output;
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            var $row_output = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column"><span class="font-weight-bold">' + full['company_name'] + '</span></div></div>';
            return $row_output;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var $row_output = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column"><span class="font-weight-bold">' + full['city'] + '</span></div></div>';
            return $row_output;
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            var $row_output = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column"><span class="font-weight-bold">' + full['email1'] + '</span></div></div>';
            return $row_output;
          }
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            var $row_output = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column"><span class="font-weight-bold">' + full['mobile1'] + '</span></div></div>';
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
                '<a href="'+baseUrl+'/edit/'+full['id']+'" target="_blank" class="dropdown-item m-0 p-0">' + feather.icons['edit'].toSvg({ class: 'font-small-4  m-0 p-0' })+'</a>' 
                + '&nbsp;&nbsp;' + 
                '<a href="'+baseUrl+'/show/'+full['id']+'" target="_blank" class="dropdown-item m-0 p-0">' + feather.icons['eye'].toSvg({ class: 'font-small-4  m-0 p-0' })+'</a>' 
                + '&nbsp;&nbsp;' + 
                '<a href="javascript:void(0)" class="dropdown-item delete-record m-0 p-0" onclick="___deleteRecord('+full['id']+');">' + feather.icons['trash-2'].toSvg({ class: 'font-small-4  m-0 p-0' }) +'</a>' +
              '</div>'
            );
          }
        }
      ],
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      orderCellsTop: true,
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table'
          })
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      }
    });
  }

  // on key up from input field
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-columns'), $(this).val());
  });

  $('select.dt-select-mul').on('change', function () {
    filterColumn($(this).attr('data-columns'), $(this).val());
  });

  // // Filter form control to default size for all tables
  $('.dataTables_filter .form-control').removeClass('form-control-sm');
  $('.dataTables_length .custom-select').removeClass('custom-select-sm').removeClass('form-control-sm');
});
