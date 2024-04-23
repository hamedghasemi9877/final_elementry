<!-- report/action.blade.php -->

@extends('layouts.app') <!-- Assuming you have a layout file -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Action Taken</div>

                <div class="card-body">
                    <p>The post has been automatically deleted after receiving five reports from users.</p>
                    <p>You can <a href="{{ route('index') }}">return to the homepage</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
