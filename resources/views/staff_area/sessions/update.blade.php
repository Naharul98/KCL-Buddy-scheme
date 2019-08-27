@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Session</div>

                <div class="card-body">

                    <!-- Populate fields with session data -->
                    <form action="/staff_area/sessions/update/{{$entry->session_id}}" method="post">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Session name:</label>
                            <div class="col-md-6">
                                <input type="session" name="session_name" class="form-control" value="{{ old('session_name', $entry->session_name) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Visible interests</label>
                            <div class="col-md-6">

                                <select class="selectpicker" data-live-search="true" multiple data-selected-text-format="count > 5" data-width="100%"  multiple data-actions-box="true" name="interest_choices[]">
                                    <!-- Populate interest list -->
                                    @foreach ($interests as $interest)
                                    <option value="{{$interest->interest_id}}" @if(is_array(old('interest_choices',$interestsChosen)) && in_array($interest->interest_id, old('interest_choices',$interestsChosen))) selected="selected" @endif>
                                        {{$interest->interest_name}}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Is locked (students cannot sign up to locked sessions)</label>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input type='hidden' value='0' name='is_locked'>
                                    <input class="form-check-input" type="checkbox" name="is_locked" value="1" {{(old('is_locked', $entry->is_locked) == '1') ? 'checked' : ''}}>
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
                </div>
            </div>
        </div>
    </div>
</div>
<br>

@endsection
