@extends("layouts.app")

@section("content")
	
	<div class="container">
        <h1>Media</h1>
		@foreach($media->chunk(4) as $chunk)
        <div class="row" style="margin-bottom: 15px">
	        @foreach($chunk as $item)
	        <div class="col-xs-6 col-sm-4 col-md-3">
		        <img class="img-responsive" src="{{$item->link}}">
		        <form action="{{url("/admin/media/$item->id/delete")}}" method="POST">
			        <input type="hidden" value="delete" name="_method">
			        {{csrf_field()}}
			        <button class="btn btn-danger btn-block">delete</button>
		        </form>
	        </div>
	        @endforeach
        </div>
		@endforeach
    </div>
    
@endsection