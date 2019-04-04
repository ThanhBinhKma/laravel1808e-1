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
		<a href="{{ route('admin.products') }}" class="btn btn-primary">View all</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Ma SP</th>
					<th>Ten SP</th>
					<th>Anh</th>
					<th>Danh muc</th>
					<th>Mau sac</th>
					<th>Kich co</th>
					<th>Thuong hieu</th>
					<th>Gia SP</th>
					<th>So luong</th>
					<th colspan="2" width="3%" class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($lstPd as $key => $item)
					<tr id="row_{{ $item['id'] }}">
						<td>{{ $item['id'] }}</td>
						<td>{{ $item['name_product'] }}</td>
						<td>
							<img src="{{ URL::to('/') }}/upload/images/{{ $item['image_product'][0] }}" alt="{{ $item['name_product'] }}" width="120" height="120">
						</td>
						<td>
							@foreach($item['categories_id']['name_cat'] as $name)
								<p> - {{ $name }}</p>
							@endforeach
						</td>
						<td>
							@foreach($item['colors_id']['name_color'] as $name)
								<p> + {{ $name }}</p>
							@endforeach
						</td>
						<td>
							@foreach($item['sizes_id']['name_size'] as $name)
								<p> * {{ $name }}</p>
							@endforeach
						</td>
						<td>{{ $item['brand_name'] }}</td>
						<td>{{ number_format($item['price']) }}</td>
						<td>{{ $item['qty'] }}</td>
						<td>
							<a href="{{ route('admin.editProduct',['id'=> $item['id']]) }}" class="btn btn-info">Edit</a>
						</td>
						<td>
							<button class="btn btn-danger btnDelete" id="{{ $item['id'] }}">Delete</button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{{-- {{ $link->links() }} --}}
		{{-- phan trang va tim kiem --}}
		{{ $link->appends(request()->query())->links() }}
	</div>
</div>
@endsection

@push('js')
	<script type="text/javascript">
		$(function(){
			$('.btnDelete').click(function() {
				let self = $(this);
				let idPd = self.attr('id');
				if($.isNumeric(idPd)){
					$.ajax({
						url: "{{ route('admin.deleteProduct') }}",
						type: "POST",
						data: {id: idPd},
						beforeSend: function(){
							self.text('Loading ...');
						},
						success: function(result){
							self.text('Delete');
							result = $.trim(result);
							if(result === 'OK'){
								alert('Delete successful');
								//window.location.reload(true);
								$('#row_'+idPd).hide();
							} else {
								alert('Delete fail');
							}
							return false; 
						}
					});
				}
			});
		})
	</script>
@endpush



