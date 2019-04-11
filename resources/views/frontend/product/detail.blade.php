@extends('frontend.base-layout')

@section('content')
	<div class="card">
	<div class="row">
		<aside class="col-sm-5 border-right">
			<article class="gallery-wrap">

				<div class="img-big-wrap">
				  <div>
				  	<a href="#">
				  		<img class="img-responsive" src="{{ URL::to('/') }}/upload/images/{{ $images[0] }}" style="width:340px;">
				  	</a>
				  </div>
				</div> <!-- slider-product.// -->

				<div class="img-small-wrap">
				@foreach($images as $key => $item)
				  <div class="item-gallery">
				  	<img src="{{ URL::to('/') }}/upload/images/{{ $item }}" style="width:65px; height: 65px;">
				  </div>
				@endforeach
				</div> <!-- slider-nav.// -->
			</article> 
			<!-- gallery-wrap .end// -->
		</aside>
	<aside class="col-sm-7">
<article class="card-body p-5">
	<h3 class="title mb-3">{{ $info['name_product'] }}</h3>

	<p class="price-detail-wrap"> 
		<span class="price h3 text-warning"> 
			<span class="currency"></span><span class="num">{{ number_format($info['price']) }}
			</span>
		</span> 
		<span>vnd</span> 
	</p> <!-- price-detail-wrap .// -->
<dl class="item-property">
  <dt>Description</dt>
  <dd><p>{!! $info['description'] !!}</p></dd>
</dl>

<dl class="param param-feature">
  <dt>Color</dt>
  <dd>
  @foreach($colors as $key => $item)
  	<label class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="inlineRadioOptionsColor" id="color_{{ $item['id'] }}" value="{{ $item['id'] }}">

	  <span class="form-check-label">{{ $item['name_color'] }}</span>
	</label>
  @endforeach
  </dd>
</dl>
<hr>
	<div class="row">
		<div class="col-sm-5">
			<dl class="param param-inline">
			  <dt>Quantity: </dt>
			  <dd>
			  	<select class="form-control form-control-sm" style="width:70px;" id="qtyPd">
			  		<option value="1"> 1 </option>
			  		<option value="2"> 2 </option>
			  		<option value="3"> 3 </option>
			  		<option value="4"> 4 </option>
			  		<option value="5"> 5 </option>
			  		<option value="6"> 6 </option>
			  	</select>
			  </dd>
			</dl>  <!-- item-property .// -->
		</div> <!-- col.// -->
		<div class="col-sm-7">
			<dl class="param param-inline">
				  <dt>Size: </dt>
				  <dd>
				  @foreach($sizes as $key => $item)
				  	<label class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size_{{ $item['id'] }}" value="{{ $item['id'] }}">
					  <span class="form-check-label">{{ $item['letter_size'] }}</span>
					</label>
				  @endforeach
				  </dd>
			</dl>  <!-- item-property .// -->
		</div> <!-- col.// -->
	</div> <!-- row.// -->
	<hr>
	<a href="#" class="btn btn-lg btn-primary text-uppercase"> Buy now </a>

	<button id="addCart" class="btn btn-lg btn-outline-primary text-uppercase">
		<i class="fas fa-shopping-cart"></i> 
		Add to cart 
	</button>

	<br> <br>
	<a href="{{ route('fr.product') }}" class="btn btn-lg btn-primary text-uppercase"> Shoping</a>
</article> <!-- card-body.// -->
		</aside> <!-- col.// -->
	</div> <!-- row.// -->
</div> <!-- card.// -->
@endsection
@push('js')
	<script type="text/javascript">
		$(function(){
			$('#addCart').click(function() {
				let sefl = $(this);
				let idPd = "{{ $info['id'] }}";
				let qty = $.trim($('#qtyPd').val());
				//can lay them mau sac va size khach hang chon
				let textColor = $('input[name="inlineRadioOptionsColor"]:checked').next().text().trim();
				let textSize = $('input[name="inlineRadioOptions"]:checked').next().text().trim();

				if($.isNumeric(idPd)){
					$.ajax({
						url: "{{ route('fr.addCart') }}",
						type: "POST",
						data: {id : idPd, qty: qty, color: textColor, size: textSize},
						beforeSend: function(){
							sefl.text('Loading ...');
						},
						success: function(result){
							sefl.text('ADD TO CART');
							result = $.trim(result);
							if(result === 'OK') {
								alert('add cart successful');
							} else {
								alert('can not add cart');
							}
						}
					});
				}
			});
		});
	</script>
@endpush


