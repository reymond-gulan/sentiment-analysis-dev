@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="#" readonly>
<div class="main container">
    <header>
        Settings
    </header>
    
    <br />

    <div class="row justify-content-center">
        <div class="col-sm-8">
        <form action="" method="POST">
            @csrf
            <div class="form-check form-switch border-bottom border-top py-3 mb-3">
                <center>
                <input class="form-check-input" id="require_email_verification" type="checkbox" @if($data->require_email_verification) checked @endif>
                <label class="form-check-label" for="require_email_verification">
                    Require email verification before taking up the survey.
                </label>
                </center>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(document).on('click','#require_email_verification', function(){
            var checkbox = $('#require_email_verification');
            var require_email_verification;
            if(checkbox.is(':checked')) {
                require_email_verification = 1;
            } else {
                require_email_verification = 0;
            }

            $.ajax({
                url:"{{route('require_email_verification')}}",
                method:'POST',
                data: {
                    require_email_verification:require_email_verification,
                    _token:_token
                },
                dataType:'json',
                beforeSend:function(){
                    loader();
                },
                success:function(response){
                    loaderx();
                    if(response.success) {
                        alert('success', response.success);
                    } else {
                        alert('error', response.error);
                    }
                },
                error:function(data){
                    loaderx();
                    $('#modal').removeClass('d-none');
                    $('.modal-backdrop').removeClass('d-none');
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
