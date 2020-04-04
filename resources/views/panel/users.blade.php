@extends('layouts.panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Management</div>

                <div class="card-body">
                    <p>{{ $users }}</p>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
