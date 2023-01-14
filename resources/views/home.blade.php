@extends('layouts.app')

@section('content')
<style>
    .canvasjs-chart-credit{
        display:none !important;
    }
    /* width */
    ::-webkit-scrollbar {
    width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius:10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<input type="hidden" class="form-control" id="view-route" value="{{route('questions-load')}}" readonly>
<div class="col-sm-12 px-3 dashboard">
    <div class="row justify-content-center">
        @if(Auth::user()->user_type == 'SUPER ADMIN')
            <div class="col-md-8">
                <center>
                    <img src="{{asset('images/logo.png')}}" alt="LOGO">
                </center>
            </div>
        @elseif(Auth::user()->user_type == 'ADMIN')
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Filter</label>
                    <div class="row">
                        <div class="col-sm-8 px-0">
                            <input type="text" class="form-control rounded-0"  id="daterangepicker" value="" />
                        </div>
                        <div class="col-sm-4 px-0">
                            <button type="button" class="btn btn-success rounded-0 search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="container">
                    <div id="data-container">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@if(Auth::user()->user_type == 'SUPER ADMIN')
@elseif(Auth::user()->user_type == 'ADMIN')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
function load(from, to){
    $.ajax({
        url:"{{route('load-data')}}",
        type:'POST',
        data: {
            from:from,
            to:to,
            _token:_token
        },
        dataType:'json',
        beforeSend:function(){
            loader();
        },
        success:function(response){
            loaderx();
            console.log(response);
            $('#data-container').html(response.html);
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
}
  $(function () {
    $('#daterangepicker').daterangepicker();

    load('', '');

    $('.search').on('click', function(){
        var date = $('#daterangepicker');
        var dates = date.val().split(" - ");

        var from = dates[0];
        var to = dates[1];

        load(from, to);
    });
 });
</script>
@endif
@endsection
