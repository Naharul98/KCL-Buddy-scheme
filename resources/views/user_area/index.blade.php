@extends('layouts.app')
@section('content')
<!-- If the user's email has not been verified yet but email is sent -->
@if (($user->is_verified != '1') && ($user->knumber != null))
<div class="alert alert-danger alert-dismissible fade show pt-1 pb-0 mb-0" id="alert" role="alert">
  <h5 class="mb-0 mt-0"><strong>Warning!</strong></h5>
  <p>An email with a verifiacation link has been sent to your kcl email. Your account is currently unverified. You will not recieve an allocaton unless your account is verified. If you havent received a email from us, try again <a href="/user_area/verify_knum" class="alert-link">here</a>
  . </p>
</div>
<!-- If the user's email has not been verified yet -->
@elseif (($user->is_verified != '1'))
<div class="alert alert-danger alert-dismissible fade show pt-1 pb-0 mb-0" id="alert" role="alert">
  <h5 class="mb-0 mt-0"><strong>Warning!</strong></h5>
  <p>Your account is currently unverified. You will not recieve an allocaton unless your account is verified. Click <a href="/user_area/verify_knum" class="alert-link">here</a> to
  verify your account now. </p>
</div>
<!-- If the user has 0 active sessions on thier dashboard -->
@elseif (count($sessions_not_signed_up_yet)<1 && count($sessions_already_signed_up) <1)
<div class="alert alert-warning alert-dismissible fade show pt-1 pb-0 mb-0" id="alert" role="alert">
   <h5 class="mb-0 mt-0"><strong>Alert!</strong></h5>
  <p>You currently have not signed up to any sessions. This means that you cannot be allocated a buddy. A session is usually your course title, which can be found in you module handbook. Click <a href="/user_area/select_session_for_signup/" class="alert-link">here</a> to
  sign up to a new session which corresponds to the course you are currently studying. </p>
</div>
<!-- If the user has any incomplete sessions on thier dashboard -->
@elseif (count($sessions_not_signed_up_yet)>0)
<div class="alert alert-warning alert-dismissible fade show pt-1 pb-0 mb-0" id="alert" role="alert">
   <h5 class="mb-0 mt-0"><strong>Alert!</strong></h5>
  <p>You currently have not completed your profile for the some of the sessions you have signed up. You will not recieve allocations for sessions where you have not completed your profile. Click <a href="/learn_more" class="alert-link">here</a> if you are experiencing any difficulties in completing a profile. </p>
</div>
@endif
<br>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <!-- Display sucess message if redirected -->
      @if (session('status'))
      <div class="alert alert-success" role="alert">{{ session('status') }}</div>
      @endif
      <div class="row">
        <div class="col-sm-12 pt-0 pb-0 mt-0 mb-0">
          <!-- If can sign up to a session or has done so already -->
          <h4 class="text-center mt-0 pt-0">Sessions <img src="https://upload.wikimedia.org/wikipedia/en/3/35/Information_icon.svg" data-toggle="tooltip" title="A session is usually your course title, which can be found in you module handbook" width="3.5%"></h4>
          <ul class="list-group">
            <!-- Populate table with sessions user has already signed up to -->
            @foreach ($sessions_already_signed_up as $session)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="/user_area/view_allocation/{{$session->session_id}}"><strong>{{$session->session_name}}
              </strong></a>
              <!-- display badge according to status -->
              @if($session->is_allocated == '1')
              <h5><span class="badge badge-pill badge-success">Allocation recieved</span></h5>
              @else
              <h5><span class="badge badge-pill badge-warning">Allocation Pending</span></h5>
              @endif
            </li>
            @endforeach

            <!-- Populate table with sessions user has not signed up to yet -->
            @foreach ($sessions_not_signed_up_yet as $session)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="/user_area/create_profile/{{$session->session_id}}"><strong>Complete Profile For {{$session->session_name}}</strong></a>
              <h5><span class="badge badge-pill badge-danger">Profile Incomplete</span> <a href="/rId={{$session->session_id}}" class="badge badge-pill badge-secondary">&#10006</a></h5>
            </li>
            @endforeach
            <br>
            <a class="btn btn-primary" href="/user_area/select_session_for_signup/" role="button">Sign up for a new session</a>

          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
@endsection
