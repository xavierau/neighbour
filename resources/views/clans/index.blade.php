@extends("layouts.app")

@section("content")
    <div class="container">
        <h1>Clans List <span class="pull-right"><a href="{{route('admin.clans.create')}}" class="btn btn-success">Create New</a></span></h1>
        <table class="table">
            <thead>
            <td>Clan Name</td>
            <td>Clan Code</td>
            <td>Actions</td>
            </thead>
            <tbody>
            @foreach($clans as $clan)
                <tr>
                    <td style="color:black">{{$clan->label}}</td>
                    <td style="color:black">{{$clan->code}}</td>
                    <td>
                        <a href="{{route("admin.clans.edit", $clan->id)}}" class="btn btn-info">Edit</a>
                        <form action="{{route("admin.clans.destroy", $clan->id)}}" method="POST">
                            <input type="hidden" value="delete" name="_method">
                            {{csrf_field()}}
                            <input type="submit" value="delete" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection