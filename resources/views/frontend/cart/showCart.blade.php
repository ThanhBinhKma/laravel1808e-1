@extends('frontend.base-layout')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h2 class="text-center">This is cart</h2>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th width="3%">#</th>
						<th>Name</th>
						<th>Image</th>
						<th>QTY</th>
						<th>Price</th>
						<th>Color</th>
						<th>Size</th>
						<th>Money</th>
						<th colspan="2" width="5%">Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($cart as $key => $item)
					<tr>
						<td>{{ $key }}</td>
						<td>{{ $item->name }}</td>
						<td>
							<img src="{{ URL::to('/') }}/upload/images/{{ $item->options['images'][0] }}" width="120" height="180">
						</td>
						<td>
							<input id="qty_{{ $key }}" type="number" value="{{ $item->qty }}">
						</td>
						<td>{{ $item->price }}</td>
						<td>{{ $item->options->color }}</td>
						<td>{{ $item->options->size }}</td>
						<td>{{ $item->price * $item->qty }}</td>
						<td>
							<button id="{{ $key }}" class="btn btn-danger deleteCart">Delete</button>
						</td>
						<td>
							<button id="{{ $key }}" class="btn btn-info updateCart">Update</button>
						</td>
					</tr>
				@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8"></td>
						<td>
							<a href="{{ route('fr.product') }}" class="btn btn-primary">Shopping</a>
						</td>
						<td>
							<a href="{{ route('fr.payment') }}" class="btn btn-success">Payment</a>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
	$(function(){
		$('.deleteCart').click(function() {
			let self = $(this);
			let rowId = self.attr('id').trim();
			if(rowId){
				$.ajax({
					url: "{{ route('fr.deleteCart') }}",
					type: "POST",
					data: {id: rowId},
					beforeSend: function(){
						self.text('Loading ... ');
					},
					success:function(result){
						self.text('Delete');

						result = $.trim(result);
						if(result === 'OK'){
							alert('delete successfull');
							window.location.reload(true);
						} else {
							alert('delete fail');
						}
					}
				});
			}
		});

		$('.updateCart').click(function() {
			let self = $(this);
			let rowId = self.attr('id').trim();
			let qty = $('#qty_'+rowId).val().trim();
			if(rowId && qty){
				$.ajax({
					url: "{{ route('fr.updateCart') }}",
					type: "POST",
					data: {id: rowId, qty: qty},
					beforeSend: function(){
						self.text('Loading ...');
					},
					success: function(result){
						self.text('Upate');
						result = $.trim(result);
						if(result === 'OK'){
							alert('upate successfull');
							window.location.reload(true);
						} else {
							alert('upate fail');
						}
					}
				});
			}
		});
	});
</script>
@endpush



