<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <p>Hey,</p>
    <p>{{Auth::user()->first_name}} saw the post below on her LocalHood network and thought you would be interested.</p>
    <hr>
    <p>{{$feed->content}}</p>
</body>
</html>