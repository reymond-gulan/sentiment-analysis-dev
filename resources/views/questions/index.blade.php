@extends('layouts.app')

@section('content')
<style>
    .cke_toolbox #cke_12, 
    .cke_toolbox #cke_20,
    .cke_toolbox #cke_22,
    .cke_toolbox #cke_26,
    .cke_toolbox #cke_31,
    .cke_toolbox #cke_33,
    .cke_toolbox #cke_47
    {
        display:none !important;
    }
</style>
<input type="hidden" class="form-control" id="view-route" value="{{route('questions-load')}}" readonly>
<input type="hidden" class="form-control" id="save-route" value="{{route('question-save')}}" readonly>
<input type="hidden" class="form-control" id="delete-route" value="{{route('question-delete')}}" readonly>

<div class="main col-sm-12 px-3">
    <header>
        Manage Survey Questionnaires
    </header>
    <div class="col-sm-12 container-theme">
        <div class="alert alert-info">
            <strong> <i class="fa fa-info-sign"></i> NOTE: </strong>
            You can <b>DRAG &amp; DROP</b> records to update the question sequence.
        </div>
        <div id="records-container"></div>
    </div>
</div>

<!--- MODAL -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="z-index:1 !important;">
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
            <textarea type="text" id="question_description" name="question_description" 
                class="form-control d-none"></textarea>
            <div class="form-group mb-2">
                <textarea type="text" id="description" class="form-control" 
                    placeholder="Description" autocomplete="off"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn close btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-save">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<button class="btn add-new fixed-button theme" data-toggle="modal" data-target="#modal"
    data-backdrop="static" data-keyboard="false">
    <i class="fa fa-plus"></i>
</button>

<script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function(){
        
        CKEDITOR.replace( 'description' );

        //CKEDITOR.instances.TEXTAREA_ID.getData();

        $('.btn-save').on('click', function(){
            var data = CKEDITOR.instances.description.getData();

            $('#question_description').val(data);

            $('#form').trigger('submit');
            CKEDITOR.instances['description'].setData('');
        });

        $(document).on('click','.update', function(){
            var id = $(this).data('id');
            var question_description = $(this).data('question_description');
            $('#id').val(id);
            $('#question_description').val('');
            CKEDITOR.instances['description'].setData(question_description);
            $('.add-new').trigger('click');
            $('.modal-title').html('UPDATE RECORD');
        });
    });
</script>
@endsection
