@extends('frontend.base-layout')

@section('content')
<div class="row">
	<div class="col-lg-12 col-md-12">
		<h2 class="text-center">This is payment</h2>
	</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Image</th>
					<th>qty</th>
					<th>Price</th>
					<th>Color</th>
					<th>Size</th>
					<th>Money</th>
				</tr>
			</thead>
			<tbody>
				@php
					$i = 1;
					$total = 0;
				@endphp

				@foreach($cart as $key => $item)
				<tr>
					<td>{{ $i }}</td>
					<td>{{ $item->name }}</td>
					<td>
						<img src="{{ URL::to('/') }}/upload/images/{{ $item->options['images'][0] }}" width="120" height="180">
					</td>
					<td>
						{{ $item->qty }}
					</td>
					<td>
						{{ number_format($item->price) }}
					</td>
					<td>
						{{ $item->options->color }}
					</td>
					<td>
						{{ $item->options->size }}
					</td>
					<td>
						{{ number_format($item->qty * $item->price) }}
					</td>
				</tr>

				@php
					$i++;
					$total += $item->qty * $item->price;
				@endphp

				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">Total</td>
					<td>{{ number_format($total) }}</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<hr>
	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
	<div class="col-md-12 col-lg-12">

		<h2 class="text-centerxt">Infomation customer</h2>

		<form action="{{ route('fr.paymentOrder') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="username">(*) Fullname</label>
				<input type="text" class="form-control" name="username" id="username">
			</div>
			<div class="form-group">
				<label for="email">(*) Email</label>
				<input type="email" class="form-control" name="email" id="email">
			</div>
			<div class="form-group">
				<label for="phone">(*) Phone</label>
				<input type="text" class="form-control" name="phone" id="phone">
			</div>
			<div class="form-group">
				<label for="address">(*) Address</label>
				<textarea class="form-control" name="address" id="address"></textarea>
			</div>
			<div class="form-group">
				<label for="note">Note</label>
				<textarea class="form-control" name="note" id="note"></textarea>
			</div>
			<button class="btn btn-primary btn-block" type="submit">Pay</button>
		</form>
	</div>
</div>
@endsection