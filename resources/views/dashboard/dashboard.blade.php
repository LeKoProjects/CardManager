@extends('layouts.app')

@section('content')

@if (auth()->user()->tipo == 1)
    @include('dashboard.admin_dashboard')
@elseif (auth()->user()->tipo == 2)
    @include('dashboard.user_dashboard')
@endif

@endsection
