@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="{{route('index-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="#" readonly>
<input type="hidden" class="form-control" id="delete-route" value="#" readonly>

<div class="container-fluid alert alert-success py-5">
    <center>
        <b>Welcome to ISU CITIZEN / CLIENT SATISFACTION SURVEY!</b>
        <br />
        <p>
            Select a campus to proceed.
        </p>
    </center>
</div>
<div class="main container">
    <div class="container container-theme">
        <div id="records-container"></div>
    </div>
</div>
@endsection
