@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-3">	
		<br>
		<div class="col text-center">
			<div class="row justify-content-center">
				<div class="col-md-9">
					<a href="/staff_area/allocations/{{$session_id}}" class="btn mb-2" id="btn" role="button">Go Back</a>
					<div class="card pb-1">
						<div class="card-header">
							<h4>{{$junior->name}}</h4>
						</div>
						<div class="container">
							<b>Gender:</b>
							<br>
							{{$junior->gender}}
							<br>
							<b>Same Gender Allocation Request:</b> 
							<br>
							{{($junior->same_gender_preference == '0') ? 'false':'true'}}
							<br>
							<b>K-Number:</b>
							<br>
							{{$junior->knumber}}
							<br>
							<b>Interests:</b>
							<br>
							<!-- If junior has interests, populate list -->
              @if($interestList !== null)
							@foreach ($interestList as $interest)
							{{$interest->interest_name}}
							<br>
							@endforeach
							@endif
							<b>Additional Details:</b> 
							{{($junior->priority_information == '') ? 'N/A':$junior->priority_information}}
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-9">
		<section class="search-banner bg-light text-black py-5" id="search-banner">
			<div class="container pt-0 my-0">
				<div class="row text-center pb-0">
					<div class="col-md-12">
						<h3>Eligible Seniors</h3>
					</div>
				</div>                      
				<form action="/staff_area/manual_allocation/{{$junior->junior_id}}/{{$session_id}}" method="POST" class="form-inline" >
					@csrf
					<div class="container-fluid">
						<div class="row">
							<div class="span6" id="browse_page_filter_div">
								<span class = "label label-default pr-3 pl-3">Name: </span>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value= "{{ $formFilterSelections['name'] }}">

								<span class = "label label-default pr-3 pl-3">Gender: </span>
								<select id="cmb" class="form-control pr-3 pl-3" name="gender">
									<option value=""></option>
									<option value="male" {{ ($formFilterSelections['gender'] == 'male') ? 'selected' : ''}}>Male</option>
									<option value="female" {{ ($formFilterSelections['gender'] == 'female') ? 'selected' : ''}}>Female</option>
									<option value="NA" {{ ($formFilterSelections['gender'] == 'NA') ? 'selected' : ''}}>Not Specified</option>
								</select> 

								<input type="submit" name="search" id="btn_browse_page_search" class="btn btn-md active" role="button" aria-pressed="true" value="Search"/>
							</div>
						</div>
					</div>
				</form>
			</div>
		</section>
		
		<div id="table_container" class="container-fluid pb-5">
			<table class="table">
				<thead class="thead">
					<tr>
						<th><div class="col text-center">Name</div></th>
						<th><div class="col text-center">Gender</div></th>
						<th><div class="col text-center">Common Interests</div></th>
						<th><div class="col text-center">&nbsp;</div></th>
					</tr>
				</thead>
				<tbody>
					
					@foreach ($eligibleSeniors as $senior)
					<tr>
						<td><div class="col text-center">{{$senior->name}}</div></td>
						<td><div class="col text-center">{{$senior->gender}}</div></td>
						<td><div class="col text-center">{{($senior->common_interests === null) ? '0' :$senior->common_interests }}</div></td>
						<td><div class="col text-center"><a class="action" href='/staff_area/manual_allocation/allocate/{{$junior->junior_id}}/{{$senior->senior_id}}/{{$session_id}}'>Allocate</a></div></td>
					</tr>
					@endforeach
					
				</tbody>
			</table>
		</div>
		{{ $eligibleSeniors->links() }}
	</div>
</div>

@endsection