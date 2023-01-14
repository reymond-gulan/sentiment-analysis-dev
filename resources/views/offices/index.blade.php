@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="{{route('offices-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="{{route('office-save')}}" readonly>
<input type="hidden" class="form-control" id="delete-route" value="{{route('office-delete')}}" readonly>

<div class="main col-sm-12 px-3">
    <header>
        Offices
    </header>
    <div class="col-sm-12 container-theme">
        <section class="mb-3 col-sm-6">
            <label for=""><b>Filter:</b></label>
            <select name="groups" id="groups" class="w-100">
                <option value="" selected>All</option>
                @foreach($data['groups'] as $office)
                    <option value="{{strtoupper($office->colleges->college_code)}} - {{strtoupper($office->colleges->college_name)}}">
                        {{strtoupper($office->colleges->college_code)}} - {{strtoupper($office->colleges->college_name)}}
                    </option>
                @endforeach
            </select>
        </section>
        <div id="records-container"></div>
    </div>
</div>

<!--- MODAL -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="z-index:1 !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            ADD NEW RECORD
        </h5>
        <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
          <span class="h4" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="form">
        <div class="modal-body">
            <p class="alert alert-info small">
                <strong><i class="fa fa-info-circle"></i> NOTE:</strong> Fields marked with <span class="required">*</span> are required.
            </p>
            @csrf
            <input type="hidden" name="id" id="id" readonly>
            <div class="form-floating mb-2">
                <input type="text" id="office_name" name="office_name" class="form-control uppercase" 
                    placeholder="Office Name" autocomplete="off">
                    <label for="name">Office Name <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="college_id" id="college_id">
                    <option value="" disabled selected>SELECT</option>
                    @foreach($data['colleges'] as $college)
                        <option value="{{$college->id}}">{{strtoupper('('.$college->college_code.') - '.$college->college_name)}}</option>
                    @endforeach
                </select>
                <label for="name">College <span class="required">*</span></label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn close btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-save">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<button class="btn add-new fixed-button theme" data-toggle="modal" data-target="#modal"
    data-backdrop="static" data-keyboard="false">
    <i class="fa fa-plus"></i>
</button>

<script>
    $(function(){
        $('#groups').on('change', function(){
            var value = $(this).val();
            $('.dataTables_filter input').val(value);
            $('.dataTables_filter input').trigger('keyup');
        });
    });
</script>
@endsection
