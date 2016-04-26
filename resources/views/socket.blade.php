@extends("layouts.app")

@section("content")

    <div class="container">
        <ul id="listContainer">

        </ul>
    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
    <script>
        var socket = io.connect('http://neighbour.dev:3000');
        socket.on("neighbourApp:notification", function (data) {
            console.log(data);
        })
    </script>
@endsection