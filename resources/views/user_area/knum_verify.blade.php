@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Enter K number</div>

                <div class="card-body">
                    
                    <!-- Display success message after knum verification -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="/user_area/verify_knum">
                        @csrf
                        <div class="form-group row">
                            <label for="knumber" class="col-md-4 col-form-label text-md-right">K-Number</label>

                            <div class="col-md-6">
                                <input id="knumber" type="knumber" class="form-control" pattern="[A-Za-z0-9]*" name="knumber" value="" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Verification Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
