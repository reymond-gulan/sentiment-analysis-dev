@extends('layouts.app')

@section('content')
{{----}}
<input type="hidden" class="form-control" id="view-route" value="{{route('colleges-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="{{route('college-save')}}" readonly>
<input type="hidden" class="form-control" id="delete-route" value="{{route('college-delete')}}" readonly>

<div class="main col-sm-12 px-3">
    <header>
        Colleges
    </header>
    <div class="col-sm-12 container-theme">
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
                <input type="text" id="college_code" name="college_code" class="form-control uppercase" 
                    placeholder="College Name" autocomplete="off">
                    <label for="name">College Name <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="college_name" name="college_name" class="form-control uppercase" 
                    placeholder="College Code" autocomplete="off">
                    <label for="name">College Code <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="college_dean" name="college_dean" class="form-control uppercase" 
                    placeholder="College Dean" autocomplete="off">
                    <label for="email">College Dean <i>(optional)</i></label>
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
        
    });
</script>
@endsection
