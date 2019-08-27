@extends('layouts.app')
@section('content')

<div class="container-fluid">
  <section class="search-banner bg-light text-black py-4" id="banner">

   <div class="row" >
    <div class="col-lg-7">
      <div class="row ml-2" >
        <a href="/staff_area/sessions/index" class="btn btn-md mb-0" id="btn" role="button">Go Back</a>
        <h3 class="pl-3"><strong>Matches for {{$session->session_name}}</strong></h3>
      </div>
    </div>

    <div class="col-lg-4 text-right">
      <div class="btn-group">
        <button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Actions
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="/staff_area/allocations/reset/{{$session->session_id}}">Reset Unfinalized Matches</a>
          <a class="dropdown-item" href="/staff_area/allocations/finalize/{{$session->session_id}}">Finalize Matches & Email</a>
          <a class="dropdown-item" href="/staff_area/matches/allocate/{{$session->session_id}}">Run Automated Matchmaking</a>
          <a class="dropdown-item" href="/staff_area/allocations/email/unallocated/{{$session->session_id}}">Email Unallocated Sudents</a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


<div class="row">
  <div class="col-lg-4">	
    <br>
    <div class="col text-center">
      <h4><STRONG>Unallocated Juniors</STRONG></h4>
    </div>
    <br>
    <div id="table_container" class="container-fluid pb-5">
      <table class="table">
        <thead class="thead">
          <tr>
            <th><div class="col text-center">Junior Name</div></th>
            <th><div class="col text-center">&nbsp;</div></th>
          </tr>
        </thead>
        <tbody>
          <!-- Populate list of juniors -->
          @foreach ($unallocatedJuniors as $junior)
          <tr>
            <td><div class="col text-center">{{$junior->name}}</div></td>
            <td><a class="action" href='/staff_area/manual_allocation/{{$junior->junior_id}}/{{$session->session_id}}'>Allocate Manually</a></td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    {{$unallocatedJuniors->appends(['matches' => $matches->currentPage()])->links()}} 
  </div>
  <div class="col-lg-8">
    <br>
    <div class="col text-center">
      <h4><STRONG>Allocated Matches</STRONG></h4>
    </div>
    <br>
    <div id="table_container" class="container-fluid pb-5">
      <table class="table">
        <thead class="thead">
          <tr>
            <!-- Table headers -->
            <th><div class="col text-center">Junior Name</div></th>
            <th><div class="col text-center">Senior Name</div></th>
            <th><div class="col text-center">Finalized & sent out</div></th>
            <th><div class="col text-center">&nbsp;</div></th>
          </tr>
        </thead>
        <tbody>
          <!-- Populate list of matches -->
          @foreach ($matches as $match)
          <tr>
            <td><div class="col text-center">{{$match->juniorName}}</div></td>
            <td><div class="col text-center">{{$match->seniorName}}</div></td>
            <td><div class="col text-center">{{ ($match->is_finalized == '0') ? 'false' : 'true'}}</div></td>
            <!-- If match is not finalized allow deallocation -->
            @if(($match->is_finalized == '0'))
            <td><a class="action" href='/staff_area/allocations/deallocate/{{$match->senior_id}}/{{$match->junior_id}}/{{$session->session_id}}'>Deallocate</a></td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$matches->appends(['unallocatedJuniors' => $unallocatedJuniors->currentPage()])->links()}} 

  </div>
</div>

@endsection