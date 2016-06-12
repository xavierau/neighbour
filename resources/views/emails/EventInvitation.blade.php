<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <p><strong>Hi, {{$invitation->receiver->name}},</strong></p>
    <p>I invite you to join the following event,</p>
    <p>Name: {{$invitation->event->name}}</p>
    <p>Date and Time: {{$invitation->event->startDateTime->toDayDateTimeString()}}</p>
    <p>Location: {{$invitation->event->location}}</p>
    <p>Description: {{$invitation->event->description}}</p>
    <button><a href="{{route("replyInvitation", [$invitation->id,  "yes"
    ])}}">I will Join</a></button>
    <button><a href="{{route("replyInvitation", [$invitation->id, "maybe"
    ])}}">Maybe</a></button>
    <button><a href="{{route("replyInvitation", [$invitation->id, "no"
    ])}}">Sorry, next time!</a></button>
</body>
</html>