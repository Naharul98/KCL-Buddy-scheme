@extends('layouts.app')
@section('content')

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Interest choice</div>
                <div class="card-body">
                    <form action="/staff_area/interests/create" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Choice Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="interest_name" value="{{ old('interest_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Create</button>
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
