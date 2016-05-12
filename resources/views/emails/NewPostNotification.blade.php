<html>
    <h1>New Post</h1>
    <h4>From: {{$feed->sender->name}}</h4>
    <p>{{$feed->content}}</p>
    @if(count($feed->media)>0)
        @foreach($feed->media as $image)
            <img src="{{asset($image->link)}}" alt="" style="margin:15px; max-height:200px; max-width:200px">
        @endforeach
    @endif
</html>