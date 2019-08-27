@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
  <div class="container pt-0 my-0">
    <div class="row text-center pb-0">
      <div class="col-lg-12 pb-3">
        <h3>Sessions</h3>
      </div>
    </div>
    <form action="/staff_area/sessions/index" method="POST" class="form-inline">
      @csrf
      <div class="container-fluid">
        <div class="row">
          <div class="span6" id="browse_page_filter_div">
            <span class = "label label-default pr-3 pl-3">Name: </span>
            <input type="text" class="form-control" name="session_name" id="session_name" placeholder="Enter Session Name" value="{{$session_name_prepopulate}}">
            <input type="submit" name="search" value= "Search" id="btn" class="btn btn-md active" role="button" aria-pressed="true" />
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<div class="container-fluid pb-5">
  <table class="table">
    <thead class="thead">
      <tr>
        <!-- Table headers -->
        <th><div class="col text-center">Session ID</div></th>
        <th><div class="col text-center">Name</div></th>
        <th><div class="col text-center">&nbsp;</div></th>
      </tr>
    </thead>
    <tbody>
      <!-- Populate table with sessions -->
      @foreach ($sessions as $session)
      <tr>
        <td><div class="col text-center">{{$session->session_id}}</div></td>
        <td><div class="col text-center">{{$session->session_name}}</div></td>
        <td>
          <div class="col text-center">
            <div class="btn-group">
              <button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="/staff_area/sessions/update/{{$session->session_id}}">Edit</a>
                <a class="dropdown-item" href="/staff_area/sessions/delete/{{$session->session_id}}">Delete</a>
                <a class="dropdown-item" href="/staff_area/sessions/generateLink/{{$session->session_id}}">View Custom Registration Link</a>
                <a class="dropdown-item" href="/staff_area/allocations/{{$session->session_id}}">View Allocations</a>
              </div>
            </div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
