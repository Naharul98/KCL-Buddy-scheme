
<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sessions</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<!-- If user is a super-admin allow creating new sessions -->
    @if(Auth::user()->role == "super_admin")
    <a class="dropdown-item" href="/staff_area/sessions/create">Add New Session</a>
    @endif
		<a class="dropdown-item" href="/staff_area/sessions/index">Modify Sessions</a>
	</div>
</li>

<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Interest Choices</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="/staff_area/interests/create">Add New Choice</a>
		<a class="dropdown-item" href="/staff_area/interests/index">Modify Choices</a>
	</div>
</li>

<li class="nav-item"><a class="nav-link" href="/staff_area/feedback">Feedback</a></li>
