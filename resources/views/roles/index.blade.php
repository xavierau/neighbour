@extends("layouts.app")

@section("content")
    <div class="container">
        <h1>Roles List <span class="pull-right"><a href="{{route('admin.roles.create')}}" class="btn btn-success">Create New</a></span></h1>
        <table class="table">
            <thead>
            <td>Roles Name</td>
            <td>Roles Code</td>
            <td>Actions</td>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td style="color:black">{{$role->label}}</td>
                    <td style="color:black">{{$role->code}}</td>
                    <td>
                        <a href="{{route('admin.roles.edit', $role->id)}}" class="btn btn-info">Edit</a>
                        <form action="{{route('admin.roles.destroy', $role->id)}}" method="POST">
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