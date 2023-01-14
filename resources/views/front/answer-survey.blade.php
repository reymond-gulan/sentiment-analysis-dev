@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="#" readonly>

<div class="main container">
    <div class="container container-theme border rounded shadow-lg p-4" id="modal">
        <h3 class="border-bottom py-2 mb-4">
            <b>Client Information Form</b>
        </h3>
        <form action="" method="POST" id="client-form">
            @csrf
            <div class="row mb-2 @if($data['hasEmail']) d-none @endif">
                <div class="col-sm-4">
                    <label for="email_address" class="text-right">Email Address #: </label>
                    <input type="text" class="form-control w-100 small" name="email_address" id="email_address"
                        @if($data['hasEmail']) value="{{$data['email_address']}}" readonly @endif>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">
                    <label for="id_number" class="text-right">ID #: </label>
                    <input type="text" class="form-control w-100 small" name="id_number" id="id_number">
                </div>
                <div class="col-sm-4">
                    <label for="name" class="text-right">Name: </label>
                    <input type="text" class="form-control w-100 small" name="name" id="name">
                </div>
                <div class="col-sm-4">
                    <label for="gender" class="text-right">Gender: </label>
                    <select class="form-select select2 w-100 small" name="gender" id="gender" required>
                        <option value="" disabled selected>SELECT</option>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </select>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-sm-12 p-0">
                    <label for="college_id" class="text-right">College: </label>
                    <select class="form-select select2 w-100 small" name="college_id" id="college_id" required>
                        <option value="" disabled selected>SELECT</option>
                        @foreach($data['colleges'] as $college)
                            <option value="{{$college->id}}">{{strtoupper('('.$college->college_code.') - '.$college->college_name)}}</option>
                        @endforeach
                    </select>
                </div>
            <div class="row form-container py-2 px-0">

            </div>
            <div class="row my-2 dump-records p-0">
                <div class="col-sm-6">
                    <label for="office_id" class="text-right">Office Visited: </label>
                    <select class="form-select select2 w-100 small" name="office_id" id="office_id" disabled required>
                        <option value="" disabled selected>SELECT</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="course_id" class="text-right">Course: </label>
                    <select class="form-select select2 w-100 small" name="course_id" id="course_id" disabled required>
                        <option value="" disabled selected>SELECT</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="yr" class="text-right">Year: </label>
                    <select class="form-select select2 w-100 small" name="yr" id="yr" disabled required>
                        <option value="" disabled selected>SELECT</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 p-0 text-right">
                    <button type="submit" class="btn btn-success p-3 px-5">
                        <b><i class="fa fa-paper-plane"></i> SUBMIT</b>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function(){
        $('#college_id').on('change', function(){
            var college_id = $(this).val();

            $('.form-container').html('');
            $('.dump-records').removeClass('d-none');

            $.ajax({
                url:'{{route("get-form-data")}}',
                type:'POST',
                data: {
                    college_id:college_id,
                    _token:_token
                },
                dataType:'json',
                beforeSend:function(){
                    loader();
                },
                success:function(response){
                    loaderx();
                    if(response.success) {
                        $('.form-container').html(response.html);
                        $('.dump-records').addClass('d-none');
                    } else {
                        alert('error', response.error);
                    }
                },
                error:function(data){
                    loaderx();
                    console.log(data.responseText);
                    var message = "";
                    var errors = data.responseJSON;
                    $.each( errors.errors, function(key, value) {
                        message += '<li>'+ value +'</li>';
                    });
                    alert('error', message);
                }   
            });
        });

        $('#client-form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url:"{{route('save-client')}}",
                type:'POST',
                data: new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                dataType:'json',
                beforeSend:function(){
                    loader();
                },
                success:function(response){
                    loaderx();
                    if(response.success) {
                        location.href = '/survey-window';
                    } else {
                        alert('error', response.error);
                    }
                },
                error:function(data){
                    loaderx();
                    console.log(data);
                    var message = "";
                    var errors = data.responseJSON;
                    $.each( errors.errors, function(key, value) {
                        message += '<li>'+ value +'</li>';
                    });
                    alert('error', message);
                }   
            });
        });
    });
</script>
@endsection
