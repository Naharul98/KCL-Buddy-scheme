@extends('layouts.app')

@section('content')
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
      <div class="card">
        <div class="card-header pb-2 pt-2">Buddy allocations -  {{$session->session_name}}</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="row">
            <legend class="col-form-label col-sm-12 pt-0">
              <!-- If student has allocations, display them in a list -->
              @if($allocations !== null && $allocations->isNotEmpty())
              <div class="list-group">
                <!-- Populate table with allocated buddies and their information -->
                @foreach($allocations as $buddy)
                <div class="d-flex w-100 justify-content-between mb-2">
                  <h4 class="mb-1">{{$buddy->name}}</h4>
                  <small>{{$buddy->email}}</small>
                </div>
                <p class="mb-1">{{$buddy->profile_description}}</p>
                <small>{{$buddy->contact}}</small>
                <hr>
                @endforeach
              </div>
              <!-- If the student has no allocations yet display message -->
              @else
              <h3>You have not yet been allocated a buddy for this session yet</h3>
              <div class="text-center">
              </div>
              @endif
            </legend>
            <br>
          </div>
        </div>
      </div>
    </div>
    <!-- If the user has no allocations display button to update profile -->
    @if($allocations === null || $allocations->isNotEmpty() == false)
    <div class="col-sm-2">
      <a href="/user_area/update_profile/{{$session->session_id}}" class="btn btn-dark mb-2" role="button">Update Profile</a>
    </div>
    @endif
  </div>
</div>
<br>
@endsection
