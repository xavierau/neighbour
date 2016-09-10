@extends("layouts.app")

@section("content")
	<div class="container">
        <form action="{{route("admin.feeds.update", $feed->id)}}" class="form" method="POST" >
	        <input type="hidden" value="PUT" name="_method">
            {{csrf_field()}}
	        <fieldset>
                <legend>Basic Info</legend>
		        
                <div class="form-group">
                    <label for="name">Content</label>
                    <textarea class="form-control" placeholder="Feed Content" name="content">{{ str_replace("<br />", "", $feed->content) }}</textarea>
	                {!! $errors->first('content', '<p class="text-danger">:message</p>') !!}
                </div>
               
            </fieldset>



            <fieldset>
                <legend>Category</legend>
	            {!! $errors->first('category_id', '<p class="text-danger">:message</p>') !!}
	            <table class="table">
                    <thead>
                    <th>Select</th>
                    <th>Category Name</th>
                    </thead>
		            @foreach($categories as $category)
			            <tr>
                            <td>
                                <input
		                                name="category_id"
		                                type="radio"
		                                value="{{$category->id}}"
                                        @if($feed->category_id == $category->id) checked @endif
                                >
                            </td>
                            <td>
                                {{$category->name}}
                            </td>
                        </tr>
		            @endforeach
                </table>
            </fieldset>



            <div class="form-group">
                <a href="{{route("admin.feeds.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="update">
            </div>


        </form>
    </div>


@endsection

