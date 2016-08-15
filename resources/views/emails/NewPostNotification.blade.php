<!doctype html>
<html>
<head>
    <style>
        body{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        div.feed-container{
            position: relative;
            border: 1px solid rgb(198, 198, 198);
            padding: 10px;
        }
        div.image-container, div.name{
            display: inline-block;
        }
        div.credentials p{
            margin:0;
        }
        div.image-container img{
            width: 60px;
        }
        div.name{
            padding-left: 10px;
            position: absolute;
            top: 10px;
        }
        div.name p:first-child{
            font-weight: 600;
        }
        div.name p:nth-child(2){
            font-size: 0.8em;
            color: #585858;
        }
        div.footer{
            background-color: rgb(194, 194, 194);
        }
        div.footer a{
            display: inline-block;
            margin:10px 0;
            padding:0 10px;
            padding-right:13px;
            border-right: 1px solid grey;
        }
        div.footer a:last-child{
            border-right: none;
        }
    </style>
</head>
<body>
    <h1>{{getSettingValue($settings, "appName")}}</h1>
    <hr />

    <p>{{$feed->sender->first_name}} posted in {{$feed->sender->clan->label}}.</p>
    <div class="feed-container">
        <div class="credentials">
            <div class="image-container">
                <img src="{{$feed->sender->avatar}}">
            </div>
            <div class="name">
                <p>{{$feed->sender->first_name}} {{$feed->sender->last_name}}</p>
                <p>{{$feed->created_at->format("M j")}} at {{$feed->created_at->format("g:ia")}}</p>
            </div>
        </div>

        <p>{{$feed->content}}</p>
        @if(count($feed->media)>0)
            @foreach($feed->media as $image)
                <img src="{{asset($image->link)}}" alt="" style="margin:15px; max-height:200px; max-width:200px">
            @endforeach
        @endif
    </div>

    <div class="footer">
        <a href="#">Like</a>
        <a href="#">Comment</a>
    </div>
</body>

</html>