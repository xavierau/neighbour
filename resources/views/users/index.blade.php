@extends("layouts.app")

@section("content")
    <div class="container">
        <h1>Users List <span class="pull-right"><a href="{{route('admin.users.create')}}" class="btn btn-success">Create New</a></span></h1>
        <table class="table">
            <thead>
            <td>User First Name</td>
            <td>User Last Name</td>
            <td>Building</td>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td style="color:black">{{$user->first_name}}</td>
                    <td style="color:black">{{$user->last_name}}</td>
                    <td style="color:black">{{$user->clan?$user->clan->label:""}}</td>
                    <td>
                        <a href="{{route("admin.users.edit", $user->id)}}" class="btn btn-info">Edit</a>
                        <form action="{{route("admin.users.destroy", $user->id)}}" method="POST">
                            <input type="hidden" value="delete" name="_method">
                            {{csrf_field()}}
                            <input type="submit" value="delete" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
@endsection