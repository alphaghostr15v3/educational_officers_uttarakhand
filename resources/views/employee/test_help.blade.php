@extends('layouts.employee')

@section('content')
<div class="container py-5">
    <div class="alert alert-info">
        <h3>TEST PAGE - IF YOU SEE THIS, HELP SYSTEM IS WORKING</h3>
        <p>Routing and Layout are correct.</p>
        <a href="{{ route('employee.help.create') }}" class="btn btn-primary btn-lg">CLICK HERE TO GO TO HELP FORM</a>
    </div>
</div>
@endsection
