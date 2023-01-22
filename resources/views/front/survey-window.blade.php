@extends('layouts.app')

@section('content')
<style>
    #survey-btn-container{
        position:fixed;
        width:100%;
        background:green;
        bottom:0;
        padding:20px;
        text-align:right;
    }
</style>
<input type="hidden" class="form-control" id="view-route" value="#" readonly>
<div class="container-fluid alert alert-success p-0">
    <center>
        <h4 class="border-bottom">
            <b>ISU CITIZEN / CLIENT SATISFACTION SURVEY QUESTIONNAIRE</b>
        </h4>
    </center>
</div>
<div class="main container">
    <div class="container container-theme">
        <div class="row border p-3">
            <h5>
                <b>
                    CLIENT INFORMATION
                </b>
            </h5>
            <div class="col-sm-6">
                <table class="small">
                    <tr>
                        <td>ID #</td>
                        <td>: <b>{{strtoupper($data['client']->id_number ?? 'N/A')}}</b></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: <b>{{strtoupper($data['client']->name)}}</b></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: <b>{{$data['client']->email_address ?? 'N/A'}}</b></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>: <b>{{strtoupper($data['client']->gender)}}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="small">
                    <tr>
                        <td>Course &amp; Yr</td>
                        <td>
                            <b>
                                : {{strtoupper($data['client']->courses->course_code ?? '')}} - {{strtoupper($data['client']->courses->course_name ?? '')}} {{strtoupper($data['client']->yr ?? '')}}
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>College</td>
                        <td>: <b>{{strtoupper($data['client']->colleges->college_name ?? 'N/A')}}</b></td>
                    </tr>
                    <tr>
                        <td>Office Visited</td>
                        <td>: <b>{{strtoupper($data['client']->offices->office_name)}}</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <br />
        <div class="alert alert-success">
            You will answer <b>{{count($data['questions'])}}</b> survey questions which you can rate with the following;
        </div>
        <center>
            @foreach($data['answers'] as $answer)
                <b class="small" style="margin-right:20px;">
                    <b class="border rounded-circle px-2 p-1 bg-success text-white">{{$answer->points}}</b> - {{strtoupper($answer->description)}}
                </b>
            @endforeach
        </center>
        <br />
        <form action="" method="POST" id="survey-form" class="border rounded rounded-3">
            @csrf

            @if(count($data['questions']) > 0)
                @foreach($data['questions'] as $row)
                    <div class="col-sm-12 border-bottom border-2 p-0">
                        <div class="row px-4 p-2">
                            <div class="col-sm-1 p-0 m-0">
                                {{$row->question_number}}
                            </div>
                            <div class="col-sm-11 p-0 m-0" style="text-align:justify;">
                                {!! $row->question_description !!}
                                @foreach($data['answers'] as $answer)
                                    <p class="small">
                                        <b>
                                        <input type="radio" 
                                            name="question_{{$row->id}}" 
                                            value="{{$answer->points}}" 
                                            data-id="{{$row->id}}"
                                            class="answers" required>
                                        {{$answer->points}} - {{strtoupper($answer->description)}}
                                        </b>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="container">
                            <center>
                            <b>Comments / Suggestions for improvement</b><br />
                            <p class="alert alert-info my-4">
                                <i class="fa fa-info-circle"></i> Please use <b>ENGLISH</b> in writing your comments/suggestions. Thank you!
                            </p>
                            </center>
                            <textarea name="comment" id="comment" class="w-100 rounded p-4" placeholder="Please add your comments / suggestions here." rows="10" required
                             style="resize:none;"></textarea>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-2 p-5">
                    <center>
                        <b><i class="fa fa-warning"></i> No questions ready for this campus.</b>
                    </center>
                </div>
            @endif

    </div>
</div>

<div class="container-fluid theme" id="survey-btn-container">
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success">
                SUBMIT ANSWERS
            </button>
        </div>
    </div>
</div>
</form>

<script>
function save(answer, question_id){
    $.ajax({
        url:"{{route('save-answers')}}",
        type:'POST',
        data: {
            answer:answer,
            question_id:question_id,
            _token:_token
        },
        dataType:'json',
        success:function(response){
            loaderx(); 
            if(response.success) {
                console.log(response.success);
            } else {
                console.log(response.error);
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
}

function save_comment(comment){
    $.ajax({
        url:"{{route('save-comment')}}",
        type:'POST',
        data: {
            comment:comment,
            _token:_token
        },
        dataType:'json',
        beforeSend:function(){
            loader();
        },
        success:function(response){
            if(response.success) {
                location.href = '/thank-you';
            } else {
                location.href = '/thank-you';
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
}
    $(function(){
        $('#survey-form').on('submit', function(e){
            e.preventDefault();
            var answers = [];
            $('input[class="answers"]:checked').each(function() {
                var answer = $(this).val();
                var id = $(this).data('id');
                save(answer, id);
            });

            var comment = $('#comment').val();
            save_comment(comment);
        });
    });
</script>
@endsection
