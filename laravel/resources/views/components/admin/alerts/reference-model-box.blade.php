{{-- model box --}}
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="referanceModal" tabindex="-1" aria-labelledby="referanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="referanceModalLabel">Referance Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
            <div >
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Module</th>
                        <th scope="col">Count</th>
                      </tr>
                    </thead >
                    <tbody id="referanceData">

                    </tbody>
                  </table>
            </div>
          
        </div>
      </div>
    </div>
  </div>
{{-- model box --}}


@push('script')
<script>

function showReferanceData(data){
    
    $.ajax({
                type: "POST",
                url: "{{ route('check-reference-data') }}",
                data: {data:data ,"_token": "{{ csrf_token() }}"},
                success: function(data) {       
                    if(data.response.length > 0 ){       

                      let  response = '';
                    
                        $.each(data.response, function(key, value){
                            response += '<tr>'+
                                                '<td>'+ value.module +'</td>'+
                                                '<td> <a href='+value.url+' target="_blank">'+ value.count +'</a></td>'+
                                         '</tr>';
                        });
                      $('#referanceModal').modal('show');  
                      $('#referanceData').html(response);  
                                       
                    }               
                }
        });

}
</script>

@endpush