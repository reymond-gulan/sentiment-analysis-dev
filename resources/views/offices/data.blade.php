@if(count($data) > 0)
    <table class="table small table-sm table-condensed table-hover" id="custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Office Name</th>
                <th>College</th>
                <th>
                        <i class="fa fa-wrench h5"></i><i class="fa fa-cogs"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $row)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{strtoupper($row->office_name)}}</td>
                    <td>{{strtoupper($row->colleges->college_code.' - '.$row->colleges->college_name)}}</td>
                    <td class="controls">
                        <center>
                        <a href="#" class="edit float-left"
                            data-id="{{$row->id}}"
                            data-office_name="{{$row->office_name}}"
                            data-college_id="{{$row->college_id}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="delete float-left"
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
        $('#basic').DataTable();
        $('#custom').DataTable({
            ordering:false,
            paging:false
        });
    });
</script>