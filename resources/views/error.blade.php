@extends('layouts.app')

@section('content')
<style>
    .e-404 h1{
        font-size:50px;
    }
    .e-404 h1,.e-404 h3{
        font-weight:bold;
    }
    .e-404 a{
        width:200px;
        margin:5px 0;
        font-weight:bold !important;
        border-radius:20px !important;
    }
</style>
<div class="row justify-content-center w-100">
    <div class="col-md-6 e-404">
        <div class="container pt-3">
            <center>
                <img src="{{asset('images/error404.png')}}" style="width:40%;" class="mb-3 border rounded-circle" alt="ERROR404">
                <b>
                    <h4>Whoops!</h4>
                    <h6>We can't seem to find the page that you are looking for.</h6>
                </b>
            
            <small>The page might not be available or you are not authorized to access the page.</small>
            </center>
        </div>
    </div>
</div>
@endsection
