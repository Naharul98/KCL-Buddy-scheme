@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
	<div class="container pt-0 my-0">
		<div class="row text-center pb-0">
			<div class="col-lg-12">
				<h1><STRONG>Which session would you like to sign up?</STRONG></h1>
			</div>
		</div>
	</div>
</section>

<div class="container-fluid pb-5">
	<table class="table">
		<thead class="thead">
			<tr>
				<!-- Table headers -->
				<th><div class="col text-center">Session ID</div></th>
				<th><div class="col text-center">Session Name</div></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			
			<!-- populate table with sessions data -->
      @foreach ($sessions as $session)
			<tr>
				<td><div class="col text-center">{{$session->session_id}}</div></td>
				<td><div class="col text-center">{{$session->session_name}}</div></td>
				<td><div class="col text-center"><a class="action" href='/user_area/create_profile/{{$session->session_id}}'>Select Session</a></div></td>

			</tr>
			@endforeach
			

		</tbody>
	</table>
</div>


@endsection
