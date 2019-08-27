@extends('layouts.sessionLayout')

@section('title')
Custom Link
@endsection

@section('containerContent')
<div class="col text-center">
  <br>
  <label><b>Your custom link is:</b></label>
  <br/>
  <label><b>{{ url('/') }}{{$session_id}}</b></label>
</div>
<br>
@endsection