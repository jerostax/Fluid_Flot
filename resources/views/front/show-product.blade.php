@extends('layouts.master')

@section('content')
<h1>TEST PAGE PRODUCT</h1>

<a href='{{route('shop')}}'>retour</a>

<h1>{{$products->titre}}</h1>
<p>{{$products->description}}</p>
<img src="{{asset('images/'.$products->pictureProduct->url_img_products)}}">


@endsection