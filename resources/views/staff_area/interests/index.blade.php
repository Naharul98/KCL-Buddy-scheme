@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
    <div class="container pt-0 my-0">
        <div class="row text-center pb-0">
            <div class="col-lg-12 pb-3">
                <h3>Interest/Hobby Choices</h3>
            </div>
        </div>
        <form action="/staff_area/interests/index" method="POST" class="form-inline">
          @csrf
          <div class="container-fluid">
            <div class="row">
              <div class="span6" id="browse_page_filter_div">
                <span class = "label label-default pr-3 pl-3">Name: </span>
                <input type="text" class="form-control" name="interest_name" id="interest_name" placeholder="Enter Interest/Hobby" value="{{$filterFormData['interest_name']}}">
                <input type="submit" name="search" id="btn" value="Search" class="btn btn-md active" role="button" aria-pressed="true"/>
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
                <th><div class="col text-center">Interest/Hobby Name</div></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <!-- Populate list of interests -->
            @foreach ($interests as $interest)
            <tr>
                <td><div class="col text-center">{{$interest->interest_name}}</div></td>
                <td><div class="col text-center"><a class="action" href='/staff_area/interests/update/{{$interest->interest_id}}'>Edit</a></div></td>
                <!-- If user is a super-admin allow deleting interests -->
                @if(Auth::user()->role == "super_admin")
                <td><div class="col text-center"><a class="action" href='/staff_area/interests/delete/{{$interest->interest_id}}'>Delete</a></div></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
