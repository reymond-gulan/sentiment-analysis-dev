@if(count($data) > 0)
<style>
    .ui-sortable-helper {
        display: table;
    }
</style>
    <table class="table">
        <thead>
            <tr>
                <th style="width:60px;">#</th>
                <th>Description</th>
                <th style="width:100px;">
                    <center>
                        <i class="fa fa-wrench h5"></i><i class="fa fa-cogs"></i>
                    </center>
                </th>
            </tr>
        </thead>
        <tbody id="sortable">
        @foreach($data as $key => $row)
            <tr data-id="{{$row->id}}"
                data-position="{{$row->question_number}}">
                <td>
                {{$key + 1}}.
                </td>
                <td style="text-align:justify;">
                    <small>
                        {!! $row->question_description !!}
                    </small>
                </td>
                <td class="controls">
                    <center>
                        <a href="#" class="update"
                            data-id="{{$row->id}}"
                            data-question_description="{!!$row->question_description!!}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="delete"
                            data-id="{{$row->id}}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </center>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else

<div class="alert alert-warning small">
    <center> 
        No record found.       
    </center>
</div>

@endif
<script>
    $(function(){
        $( "#sortable" ).sortable({
            update: function(event, ui) {
                $('#sortable tr').each( function(e) {
                    var number = ($(this).index() + 1);
                    $.ajax({
                        url:'{{route("question-update")}}',
                        method:'POST',
                        data:{
                            _token: $('meta[name=csrf-token').attr('content'),
                            id:$(this).data('id'),
                            question_number: number,
                        },
                        dataType:'json',
                        beforeSend:function(){
                            loader();
                        },
                        success:function(){
                            loaderx();
                            
                        }
                    });
                });
                view();
            }
        });

        $('#basic').DataTable();
        $('#custom').DataTable({
            ordering:false,
            paging:false
        });

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                $('#form').trigger('submit');
            }
        });
    });
</script>