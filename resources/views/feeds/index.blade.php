@extends("layouts.app")

@section("content")
	<div class="container">
        <h1>Feeds <span class="pull-right"><a href="{{route('admin.feeds.create')}}" class="btn btn-success">Create Feed</a></span></h1>
        <table class="table">
            <thead>
            <td>Summary</td>
            <td>Category</td>
            <td>User</td>
            <td>Building</td>
            </thead>
            <tbody>
            @foreach($feeds as $feed)
	            <tr>
                    <td style="color:black">{!! $feed->summary() !!}</td>
                    <td style="color:black">{{$feed->category->name}}</td>
                    <td style="color:black">{{$feed->sender->fullName}}</td>
                    <td style="color:black">@if($feed->sender->clan) {{$feed->sender->clan->label}} @endif</td>
                    <td>
                        <a href="{{route("admin.feeds.edit", $feed->id)}}" class="btn btn-info">Edit</a>
                        <form action="{{route("admin.feeds.destroy", $feed->id)}}" method="POST">
                            <input type="hidden" value="delete" name="_method">
	                        {{csrf_field()}}
	                        <input type="submit" value="delete" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $feeds->links() }}
    </div>
    
@endsection