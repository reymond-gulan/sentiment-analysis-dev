@if(count($data) > 0)
    <table class="table small table-sm table-condensed table-hover" id="custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Points</th>
                <th>Campus</th>
                <th>
                    <center>
                        <i class="fa fa-wrench h5"></i><i class="fa fa-cogs"></i>
                    </center>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $row)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{strtoupper($row->description)}}</td>
                    <td>{{strtoupper($row->points)}}</td>
                    <td>{{strtoupper($row->campuses->campus_name)}}</td>
                    <td class="controls">
                        <a href="#" class="edit"
                            data-id="{{$row->id}}"
                            data-description="{{$row->description}}"
                            data-points="{{$row->points}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="delete"
                            data-id="{{$row->id}}">
                            <i class="fa fa-trash"></i>
                        </a>
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
        $('#basic').DataTable();
        $('#custom').DataTable({
            ordering:false,
            paging:false
        });
    });
</script>