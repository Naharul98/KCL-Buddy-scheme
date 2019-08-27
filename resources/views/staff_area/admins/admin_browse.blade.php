@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
    <div class="container pt-0 my-0">
        <div class="row text-center pb-0">
            <div class="col-lg-12 pb-3">
                <h3>Admins</h3>
            </div>
        </div>
        <form action="/staff_area/admin" method="POST" class="form-inline" >
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="span6" id="browse_page_filter_div">
                        <span class = "label label-default pr-3 pl-3">Name: </span>
                        <input type="text" class="form-control" name="admin_name" placeholder="Enter Name" value= "{{$filterFormData['admin_name']}}">
                        <span class = "label label-default pr-3 pl-3">Privilege: </span>
                        <select id="cmb" class="form-control pr-3 pl-3" name="admin_privilege">
                            <option value="" {{($filterFormData['admin_privilege'] == "") ? 'selected' : ''}}></option>
                            <option value="admin" {{($filterFormData['admin_privilege'] == "admin") ? 'selected' : ''}}>Admin</option>
                            <option value="super_admin" {{($filterFormData['admin_privilege'] == "super_admin") ? 'selected' : ''}}>Super Admin</option>
                        </select> 

                        <input type="submit" name="search" class="btn btn-md btn-primary active" role="button" aria-pressed="true" value="Search"/>
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
                <th>Admin ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Privilege</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <!-- Populate table with admins -->
            @foreach ($tableData as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->role}}</td>
                <td><a class="action" href="/staff_area/admin/update/{{$admin->id}}">Edit</a></td>
                <td><a class="action" href="/staff_area/admin/delete/{{$admin->id}}">Delete</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
