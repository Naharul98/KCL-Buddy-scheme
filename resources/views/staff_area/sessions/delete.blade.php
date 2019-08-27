@extends('layouts.sessionLayout')

@section('title')
Delete Session
@endsection

@section('containerContent')
<form action="/staff_area/sessions/delete/{{$entry->session_id}}" method="post">
    @csrf
    <div class="form-group">
        <br>
        <div class="col text-center">
            <label><b>Are you sure you want to delete the session - {{$entry->session_name}}? </b></label>
            <label><b>All data associated with the session will be removed/reset</b></label>
            <br>
            <button type="submit" class="btn" name="yes" id="btn">Yes</button>
            <a href="/staff_area/sessions/index" class="btn" name="no" id="btn" role="button">No</a>
        </div>
    </div>
</form>
<br>
@endsection
