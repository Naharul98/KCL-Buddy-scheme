@extends('layouts.app')
@section('content')
<br>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><h4>Delete Interest</h4></div>
        <div class="container">
          <form action="/staff_area/interests/delete/{{$entry->interest_id}}" method="post">
            @csrf
            <div class="form-group">
              <br>
              <div class="col text-center">
                <label><b>Are you sure you want to delete the interest choice -  {{$entry->interest_name}}? </b></label>
                <br>
                <button type="submit" class="btn btn-dark">Yes</button>
                <a href="/staff_area/interests/index" class="btn" id="btn" role="button">No</a>
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
