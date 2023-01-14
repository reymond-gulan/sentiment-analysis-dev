@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="#" readonly>
<input type="hidden" class="form-control" id="save-route" value="#" readonly>
<input type="hidden" class="form-control" id="delete-route" value="#" readonly>

<div class="container-fluid alert alert-success py-5">
    <center>
        Verify your email to proceed to <b>{{strtoupper($data->campus_name)}}'s</b> survey.@if($hasEmail) - @endif
    </center>
</div>
<div class="main container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <center>
                <p class="alert alert-info">
                    <small>
                    <i class="fa fa-info-circle"></i> You will receive a verification code to this email that you will submit.
                    </small>
                </p>
                </center>
                <form action="" method="POST" id="form">
                @csrf
                <div class="row px-3">
                    <div class="col-sm-8 p-0">
                        <div class="form-floating">
                            <input type="text" id="email_address" name="email_address" class="form-control rounded-0" 
                                placeholder="Your email address" autocomplete="off" required @if($hasEmail) value="{{request()->session()->get('email_address')}}" readonly @endif>
                                <label for="name">Your email address</label>
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <button type="button" class="btn btn-secondary p-3 w-100 rounded-0 send-code" @if($hasEmail) disabled @endif>
                            <b><i class="fa fa-paper-plane"></i> SEND CODE</b>
                        </button>
                    </div>
                    <center>
                    <p class="p-0 m-0 @if(!$hasEmail) d-none @endif resend">
                        <small>
                            No code received? <a href="#" class="text-primary text-hover"><i>Resend verification code</i></a>
                        </small>
                    </p>
                    </center>
                    <div class="col-sm-12 px-0">
                        <div class="form-floating my-3">
                            <input type="text" id="verification_code" name="verification_code" class="form-control rounded-0" 
                                placeholder="Enter verification code" autocomplete="off" required @if(!$hasEmail) disabled @endif>
                                <label for="name">Enter 6-digit verification code</label>
                        </div>
                        <button type="submit" class="btn btn-success mt-2 w-100 rounded-0 py-3 verify" @if(!$hasEmail) disabled @endif>
                            <b><i class="fa fa-check"></i> VERIFY</b>
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function verify(prompt){
    var email_address = $('#email_address').val();
    var data = {
        email_address:email_address,
        _token:_token
    };
    $.ajax({
        url:'{{route("send-code")}}',
        type:'POST',
        data: data,
        dataType:'json',
        beforeSend:function(){
            loader();
        },
        success:function(response){
            loaderx(); 
            if(response.success) {
                $('#email_address').attr('readonly', true);
                $('.send-code').attr('disabled', true);
                $('#verification_code').attr('disabled', false);
                $('.verify').attr('disabled', false);
                alert('success', prompt);
            } else {
                $('#email_address').attr('readonly', false);
                $('.send-code').attr('disabled', false);
                $('#verification_code').attr('disabled', true);
                $('.verify').attr('disabled', true);
                alert('error', response.error);
            }
        }
        ,
        error:function(data){
            loaderx();
            console.log(data.statusText);
            if(data.statusText == "OK"){
                $('#email_address').attr('readonly', true);
                $('.send-code').attr('disabled', true);
                $('#verification_code').attr('disabled', false);
                $('.verify').attr('disabled', false);
                alert('success', prompt);
                $('.resend').removeClass('d-none');
            } else {
                $('#verification_code').attr('disabled', true);
                $('.verify').attr('disabled', true);
                $('#email_address').attr('readonly', false);
                $('.send-code').attr('disabled', false);
                $('.resend').addClass('d-none');
                var message = "";
                var errors = data.responseJSON;
                $.each( errors.errors, function(key, value) {
                    message += '<li>'+ value +'</li>';
                });
                alert('error', message);
            }
        }   
    });
}
    $(function(){
        $('.send-code').on('click', function(){
            var message = 'Verification code has been sent to your email.';
            verify(message);
        });

        $('.resend').on('click', function(){
            var message = 'New verification code has been sent.';
            verify(message);
        });

        $('#form').on('submit', function(){
            $.ajax({
                url:'{{route("verify-email")}}',
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
                        location.href = '/answer-survey';
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
    });
</script>
@endsection
