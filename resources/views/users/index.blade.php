@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="{{route('users-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="{{route('user-save')}}" readonly>
<input type="hidden" class="form-control" id="delete-route" value="{{route('user-delete')}}" readonly>

<div class="main container">
    <header>
        Users Settings
    </header>
    <div class="container container-theme">
        <div id="records-container"></div>
    </div>
</div>

<!--- MODAL -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="z-index:1 !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            ADD NEW RECORD
        </h5>
        <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
          <span class="h4" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="form">
        <div class="modal-body">
            <p class="alert alert-info small">
                <strong><i class="fa fa-info-circle"></i> NOTE:</strong> Fields marked with <span class="required">*</span> are required.
            </p>
            @csrf

            <div class="form-floating mb-2">
                <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="Employee ID #" autocomplete="off">
                <label for="name">Employee ID # <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="name" name="name" class="form-control" placeholder="Complete Name" autocomplete="off">
                <label for="name">User's Complete Name <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email Address" autocomplete="off">
                <label for="email">Email Address <span class="required">*</span></label>
            </div>

            <div class="form-floating my-5">
                <select class="form-select" name="campus_id" id="campus_id">
                    <option value="" disabled selected>SELECT</option>
                    @foreach($data['campuses'] as $campus)
                        <option value="{{$campus->id}}">{{strtoupper($campus->campus_name)}}</option>
                    @endforeach
                </select>
                <label for="name">Campus <span class="required">*</span></label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select" name="user_type" id="user_type">
                    <option value="ADMIN" selected>ADMIN</option>
                    <option value="SUPER ADMIN">SUPER ADMIN</option>
                </select>
                <label for="user_type">Account Type <span class="required">*</span></label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn close btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-save">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<button class="btn add-new fixed-button theme" data-toggle="modal" data-target="#modal"
    data-backdrop="static" data-keyboard="false">
    <i class="fa fa-plus"></i>
</button>

<script>
    $(function(){
        $(document).on('click','.deactivate', function(){
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed.'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{route('user-deactivate')}}",
                        method:'POST',
                        data:{
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id:id
                        },
                        dataType:'json',
                        success:function(response){
                            if(response.success) {
                                alert('success', response.success);
                                view();
                            } else {
                                alert('error', response.error);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
