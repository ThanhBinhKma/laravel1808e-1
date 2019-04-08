@extends('frontend.base-layout')

@section('content')
<div class="row">
  @foreach($listPd as $key => $item)
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
      <a href="{{ route('fr.detailPd',['id' => $item['id']]) }}">
        <img class="card-img-top" src="{{ URL::to('/') }}/upload/images/{{ $item['image_product'][0] }}" alt="">
      </a>
      <div class="card-body">
        <h4 class="card-title">
          <a href="{{ route('fr.detailPd',['id' => $item['id']]) }}">{{ $item['name_product'] }}</a>
        </h4>
        <h5>${{ $item['price'] }}</h5>
        <p class="card-text">{{ $item['description'] }}</p>
      </div>
      <div class="card-footer">
        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div class="row">
  <div class="col-md-12">
    {{ $link->links() }}
  </div>
</div>
@endsection

      