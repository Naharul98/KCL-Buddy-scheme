@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit</div>

                <div class="card-body">
                    <!-- Populate form with admin data -->
                    <form action="/staff_area/admin/update/{{$entry->id}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$entry->name) }}" required autofocus>

                                <!-- If error in name, alert user -->
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$entry->email) }}" required>

                                <!-- If error in emial, alert user -->
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Privilege</label>
                            <div class="col-md-6">
                                <select id="cmb_profile" class="form-control pr-3 pl-3" name="role" onchange="removeMultipeSelectorIfSuperAdmin();">
                                    <option value="admin" {{($entry->role === 'admin') ? ' selected': ' ' }}>Admin</option>
                                    <option value="super_admin" {{($entry->role === 'super_admin') ? ' selected' : ' ' }}>Super Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="multiple_selector">

                        <label for="role" class="col-md-4 col-form-label text-md-right">In charge of</label>
                          <div class="col-md-6">
                          <select class="selectpicker" data-live-search="true" multiple data-selected-text-format="count > 3" data-width="100%"  multiple data-actions-box="true" name="session_choices[]">
                            <!-- Populate list of sessions -->
                            @foreach ($sessions as $session)
                            <option value="{{$session->session_id}}" @if(is_array(old('session_choices',$sessionsInCharge)) && in_array($session->session_id, old('session_choices',$sessionsInCharge))) selected="selected" @endif>
                                {{$session->session_name}}
                            </option>
                            @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<script src="{{ asset('js/admin.js') }}" defer></script>
@endsection
