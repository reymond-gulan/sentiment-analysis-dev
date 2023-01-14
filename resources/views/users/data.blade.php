@if(count($data) > 0)
    <table class="table small table-sm table-condensed table-hover" id="custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Account Type</th>
                <th>Status</th>
                <th></th>
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
                    <td>{{ $key + 1 }}</td>
                    <td>{{strtoupper($row->employee_id)}}</td>
                    <td>{{strtoupper($row->name)}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->user_type}}</td>
                    <td>
                        @if($row['is_deactivated'])
                            <span class="bg-danger p-1 px-3 border rounded-5 text-white">DEACTIVATED</span>
                        @else
                            <span class="bg-success p-1 px-3 border rounded-5 text-white">ACTIVE</span>
                        @endif
                    </td>
                    <td>
                        @if($row['is_deactivated'])
                            <a href="#" class="deactivate h4 mr-5"
                                data-id="{{$row->id}}">
                                <i class="fa fa-check text-success"></i>
                            </a>
                        @else
                            <a href="#" class="deactivate h4 mr-5"
                                data-id="{{$row->id}}">
                                <i class="fa fa-power-off text-danger"></i>
                            </a>
                        @endif
                    </td>
                    <td class="controls">
                        <center>
                        <a href="#" class="delete ml-5"
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