@extends('layouts.app')

@section('content')
<br>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><h4>Delete Account</h4></div>
        <div class="container">
          <form action="/user_area/delete_account/{{$user->id}}" method="post">
            @csrf
            <div class="form-group">
              <br>
              <div class="col text-center">
                <label><b>Are you sure you want to delete your account -  {{$user->name}} &#63;</b></label>
                <label><b>All data associated with your account will be removed.</b></label>
                <br>
                <button type="submit" class="btn btn-dark">Yes</button>
                <a href="/user_area/index" class="btn btn-dark" role="button">No</a>
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