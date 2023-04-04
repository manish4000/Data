@if(Session::get('success_message'))

@push('script')
<script>
window.onload = function() { Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: ' {{session()->get('success_message')}}',
  showConfirmButton: false,
  timer: 2000
});
}
</script>
@endpush

@endif

@if( Session::get('error_message'))
  @push('script')
    <script>
    window.onload = function() { Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: '{{session()->get('error_message')}}',
      showConfirmButton: false,
      timer: 2000
    });
    }
    </script>
  @endpush


@endif
