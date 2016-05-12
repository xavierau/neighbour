<html>
    <h1>New Post</h1>
    <h4>From: {{$feed->sender->name}}</h4>
    <p>{{$feed->content}}</p>
    @if(count($feed->media)>0)
        @foreach($feed->media as $image)
            <img src="{{$image->link}}" alt="" style="margin:15px; max-height:200px; max-width:200px">
            <p>{{asset($image->link)}}</p>
            <p>{{url($image->link)}}</p>
            <p>{{$host->full()}}</p>
        @endforeach
    @endif
</html>