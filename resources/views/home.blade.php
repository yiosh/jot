@extends('layouts.app')

@section('content')
    <app :user="{{ auth()->user() }}"></app>
@endsection
