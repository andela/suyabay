@extends('api.master')

@section('title', 'Suyabay: MyApp info')

@endsection

@section('content')

	<h1>Your App Info<h1>

	@foreach ($app_infos as $app_info)
		{{ $app_info->name }}
		{{ $app_info->homepage_url }}
		{{ $app_info->description }}

	@endforeach

@endsection