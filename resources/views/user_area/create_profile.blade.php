@extends('layouts.app')

@section('content')
<br>
<script src="profile.js"></script>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Profile</div>
        <div class="container">
          <form action="/user_area/create_profile" method="post">
            @csrf
            <br>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Signing up as</legend>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" id="juniorInput" type="radio" name="student_type" required value="junior" onchange="checkIfSeniorChecked();">
                    <label class="form-check-label" for="juniorChoice">Junior student to be a budddy</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" id="seniorInput" type="radio" name="student_type" required value="senior" onchange="checkIfSeniorChecked();">
                    <label class="form-check-label" for="seniorChoice">
                      Senior student to be a mentor
                    </label>
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-form-label">Session</label>
              <div class="col-sm-9">
                <div class="dropdown">
                  <select id="cmb_profile" class="form-control pr-3 pl-3" name="session">
                    <option value="{{$session->session_id}}" selected="selected">{{$session->session_name}}</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- If the session has interests assigned to it -->
            @if(count($interests)>0)
            <div class="form-group row">
              <div class="col-sm-3">Interests</div>
              <div class="col-sm-9">
                <!-- populate checkboxes with interest data-->
                  <select class="selectpicker" data-live-search="true" multiple data-selected-text-format="count > 5" data-width="60%"  multiple data-actions-box="true" name="interest_choices[]">
                    @foreach ($interests as $interest)
                    <option value="{{$interest->interest_id}}">{{$interest->interest_name}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            @endif
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" required value="male" >
                    <label class="form-check-label" for="male">Male</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" required value="female">
                    <label class="form-check-label" for="female">Female</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" required value="NA" checked="checked">
                    <label class="form-check-label" for="female">Prefer Not To Say</label>
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group" id="sameGenderAlloc">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Same Gender Allocation Preference (Juniors only)</legend>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="same_gender_preference" required value="1" >
                    <label class="form-check-label" for="yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="same_gender_preference" required value="0" checked="checked">
                    <label class="form-check-label" for="no">
                      No
                    </label>
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="form-group row" id="seniorChoice">
              <label for="max_buddy" class="col-sm-3 pt-0 col-form-label">Maximum number of buddies (Seniors Only)</label>
              <div class="col-sm-9">
                <select id="cmb_profile" class="form-control pr-3 pl-3" name="max_number_of_buddies">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="Description">
              <label for="profile_description" class="col-sm-3 pt-0 col-form-label">Short description about yourself</label>
              <div class="col-sm-9">
                <textarea class="form-control" type="textarea" id="profile_textboxes" placeholder="Profile description" name="profile_description" rows="2" required></textarea>
              </div>
            </div>

            <div class="form-group row" id="contact">
              <label for="contact" class="col-sm-3 pt-0 col-form-label">Additional contact informations for your buddy</label>
              <div class="col-sm-9">
                <textarea class="form-control" type="textarea" id="profile_textboxes" placeholder="Additional contact methods" name="contact" rows="2" maxlength="200"></textarea>
                <small id="info" class="form-text text-muted">Optional</small>
              </div>
            </div>

            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Check this box if you have any special needs</legend>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input type='hidden' value='0' name='need_priority'>
                    <input class="form-check-input" id="spcialNeedsInput" onchange="checkIfSpecialNeedsChecked();" type="checkbox" name="need_priority" value="1">
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="form-group row" id="special_needs_textbox">
              <label for="special_needs_textbox" class="col-sm-3 pt-0 col-form-label">Details about your special needs</label>
              <div class="col-sm-9">
                <textarea class="form-control" name="priority_information" type="textarea" id="profile_textboxes" placeholder="Special needs details" rows="2" maxlength="200"></textarea>
              </div>
            </div>

            <div class="form-group row" id="info_page_link">
              <div class="col-sm-3"></div>
              <div class="col-sm-9">
                <a href="/user_area/data_processing_info" target="_blank">How will my information be used?</a>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-3"></div>
              <div class="col-sm-9">
                <button type="submit" class="btn btn-primary">Create Profile</button>
              </div>
            </div>
          </form>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
@endsection
