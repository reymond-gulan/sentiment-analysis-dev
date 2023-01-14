@extends('layouts.app')

@section('content')
<input type="hidden" class="form-control" id="view-route" value="{{route('campuses-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="{{route('campus-save')}}" readonly>
<input type="hidden" class="form-control" id="delete-route" value="{{route('campus-delete')}}" readonly>

<div class="main container">
    <header>
        Campus Settings
    </header>
    <div class="container container-theme">
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
                <input type="text" id="campus_name" name="campus_name" class="form-control" placeholder="Name" autocomplete="off">
                <label for="floatingInput">Name <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="campus_address" name="campus_address" class="form-control" placeholder="Campus Address" autocomplete="off">
                <label for="floatingInput">Campus Address <span class="required">*</span></label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" id="email_address" name="email_address" class="form-control" placeholder="Email Address" autocomplete="off">
                <label for="floatingInput">Email Address <i>(optional)</i></label>
            </div>
            <div class="form-floating mb-2">
                <textarea type="text" id="contact_information" 
                    name="contact_information" class="form-control" 
                    placeholder="Contact Information"></textarea>
                <label for="floatingInput">Contact Information <i>(optional)</i></label>
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
