<div class="col-sm-6 mt-2">
    <label for="office_id" class="text-right">Office Visited: </label>
    <select class="form-select select2 w-100 small" name="office_id" id="office_id" required>
        <option value="" disabled selected>SELECT</option>
        @foreach($data['offices'] as $office)
            <option value="{{$office->id}}">
                {{strtoupper($office->office_name)}}
            </option>
        @endforeach
    </select>
</div>
<div class="col-sm-4 mt-2">
    <label for="course_id" class="text-right">Course: </label>
    <select class="form-select select2 w-100 small" name="course_id" id="course_id" required>
        <option value="" disabled selected>SELECT</option>
        @foreach($data['courses'] as $course)
            <option value="{{$course->id}}">
                {{strtoupper($course->course_code)}} - {{strtoupper($course->course_name)}} 
            </option>
        @endforeach
    </select>
</div>
<div class="col-sm-2 mt-2">
    <label for="yr" class="text-right">Year: </label>
    <select class="form-select select2 w-100 small" name="yr" id="yr" required>
        <option value="" disabled selected>SELECT</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2({
            dropdownParent: $("#modal"),
            width: 'resolve',
            theme: "classic",
        });
    });
</script> -->