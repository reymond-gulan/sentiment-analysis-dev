@if(count($data) > 0)
    <table class="table small table-sm table-condensed table-hover" id="custom">
        <thead>
            <tr>
                <th>#</th>
                <th>College Code</th>
                <th>College Name</th>
                <th>Dean</th>
                <!-- <th>Campus</th> -->
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
                    <td>{{strtoupper($row->college_code)}}</td>
                    <td>{{strtoupper($row->college_name)}}</td>
                    <td>{{strtoupper($row->college_dean)}}</td>
                    <!-- <td>{{strtoupper($row->campuses->campus_name)}}</td> -->
                    <td class="controls">
                        <p>
                        <a href="#" class="edit float-left"
                            data-id="{{$row->id}}"
                            data-college_code="{{$row->college_code}}"
                            data-college_name="{{$row->college_name}}"
                            data-college_dean="{{$row->college_dean}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if( ! \App\Classes\DataHelper::colleges($row->id))
                            <a href="#" class="delete float-left"
                                data-id="{{$row->id}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
                        </p>
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