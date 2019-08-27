@extends('layouts.app')

@section('content')

<div class="container">
    <br>
    <h1>Feedback</h1>
    <br>
    <h3>Edit feedback questionnaire/View results</h3>
    <p>Login to Survey Monkey <a href="https://www.surveymonkey.com/user/sign-in/?ut_source=megamenu" target="_blank">here</a>.</p>
    <br>
    <h3>Email survey link to students</h3>
    <p>Send an invite link to the survey to participants by email.</p>
    <br>
    <a href="/staff_area/feedback/email" class="btn" id="btn" role="button">Email Participants</a>
</div>
<br><br>
@endsection
