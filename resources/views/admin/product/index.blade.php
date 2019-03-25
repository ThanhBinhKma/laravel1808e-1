@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Product !</h3>
		<h3 class="text-center">{{ $mess  }}</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('admin.addProduct') }}" class="btn btn-primary"> Add product + </a>
	</div>
</div>
@endsection