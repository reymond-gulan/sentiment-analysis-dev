@if(count($data) > 0)
    <table class="table table-borderless small table-sm table-condensed" id="custom">
        <thead>
            <tr>
                <th class="border-0"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $row)
                <tr>
                    <td class="border-0 index-container">
                        <a href="/campus/{{$row->id}}">
                        <div class="container index-body"
                            data-id="{{$row->id}}">
                            <h1 class="name">{{strtoupper($row->campus_name)}}</h1>
                            <p class="address">{{strtoupper($row->campus_address)}}</p>
                            <p class="email">
                                {{(!empty($row->email_address)) ? $row->email_address : ''}}
                            </p>
                            <p class="contact">
                                {{(!empty($row->contact_information)) ? "Contact information : ".$row->contact_information : ''}}
                            </p>
                            @if($row->settings->require_email_verification)
                                <span class="alert alert-info p-1 px-3">
                                    <small>
                                    You must have a valid email for verification to take this survey.
                                    </small>
                                </span>
                            @endif
                        </div>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="border-0"></td>
            </tr>
        </tfoot>
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
            paging:false,
            info:false,
        });
    });
</script>