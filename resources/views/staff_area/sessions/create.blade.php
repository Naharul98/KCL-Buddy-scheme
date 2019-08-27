@extends('layouts.sessionLayout')

@section('title')
Create new session
@endsection

@section('containerContent')
<form action="/staff_area/sessions/create" method="post">
    @csrf
    <br>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Session name:</label>
        <div class="col-md-6">
            <input type="session" name="session_name" class="form-control" placeholder="Enter session name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Visible interests</label>
        <div class="col-md-6">
          <select class="selectpicker" name="select_picker" data-live-search="true" multiple data-selected-text-format="count > 5" data-width="100%"  multiple data-actions-box="true" name="interest_choices[]">
            <!-- Populate list with interests -->
            @foreach ($interests as $interest)
            <option value="{{$interest->interest_id}}">{{$interest->interest_name}}</option>
            @endforeach
          </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Is locked (students cannot sign up to locked sessions)</label>
        <div class="col-sm-6">
            <div class="form-check">
                <input type='hidden' value='0' name='is_locked'>
                <input class="form-check-input" type="checkbox" name="is_locked" value="1">
                <label class="form-check-label" for="locked">Yes</label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">
            <button type="submit" name="submit_session" class="btn btn-dark">Submit</button>
        </div>
    </div>
</form>
<br>
@endsection
