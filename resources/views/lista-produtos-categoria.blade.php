@extends('templates.master')
@inject('request', 'Illuminate\Http\Request')

@section('title')
    {{ ucfirst($request->segment(1)) }}
@endsection


