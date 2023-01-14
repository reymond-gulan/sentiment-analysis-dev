@if(count($data) > 0)
    <table class="table small table-sm table-condensed table-hover" id="custom">
        <thead>
            <tr>
                <th>#</th>
                <th>Campus Name</th>
                <th>Address</th>
                <th>Email Address</th>
                <th>Contact Information</th>
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
                    <td>{{strtoupper($row->campus_name)}}</td>
                    <td>{{strtoupper($row->campus_address)}}</td>
                    <td>{{$row->email_address}}</td>
                    <td>{{$row->contact_information}}</td>
                    <td class="controls">
                        <a href="#" class="edit"
                            data-id="{{$row->id}}"
                            data-campus_name="{{$row->campus_name}}"
                            data-campus_address="{{$row->campus_address}}"
                            data-email_address="{{$row->email_address}}"
                            data-contact_information="{{$row->contact_information}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if(!\App\Classes\DataHelper::campuses($row->id))
                            <a href="#" class="delete"
                                data-id="{{$row->id}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
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