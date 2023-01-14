@extends('layouts.app')

@section('content')
<style>
    #confetti-canvas{
        position:fixed;
        top:0;
        width:100%;
        height:100%;
    }
</style>
<input type="hidden" class="form-control" id="view-route" value="#" readonly>
<div class="main col-sm-12">
    <div class="col-sm-12 container-theme">
        <div class="alert alert-success py-5">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <center>
                        <h1 style="font-size:100px;">
                            &#128522;
                        </h1>
                        <h1><b>Your answers has been submitted.</b></h1>
                        <h3>Thank you for taking up this survey.</h3> 
                        You feedbacks are highly appreciated!
                        <p class="mt-5">
                            <a href="/campuses" class="btn btn-success rounded rounded-5 py-2 px-5 px-5">
                                <i class="fa fa-arrow-left"></i> Go Back to Homepage
                            </a>
                        </p>
                    </h1>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/confetti.js')}}"></script>
<script>
    startConfetti();

    setInterval(function(){
        stopConfetti();
    }, 10000);
</script>

@endsection
