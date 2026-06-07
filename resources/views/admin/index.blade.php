@extends('admin.layouts.master')

@section('title')
    <title>{{ $title }}</title>
@endsection

@section('custom-css')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@endsection
