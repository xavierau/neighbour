@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="{{route("admin.roles.update", $role->id)}}" class="form" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Role Label</label>
                <input type="text" class="form-control" name="label" id="label" value="{{$role->label}}" required>
            </div>

            <div class="form-group">
                <label for="code">Role Code </label>
                <input type="text" class="form-control" value="{{$role->code}}" disabled>
                <p class="helper-text">Must be unique</p>
            </div>

            <table class="table">
                <thead>
                    <th>Select</th>
                    <th>Permission</th>
                </thead>
                @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <input
                                    name="permissions[]"
                                    type="checkbox"
                                    value="{{$permission->id}}"
                                    @if(in_array($permission->id, $role->permissions()->lists("id")->toArray()))
                                        checked
                                    @endif
                            >
                        </td>
                        <td>
                            {{$permission->label}}
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="form-group">
                <a href="{{route("admin.roles.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="Update">
            </div>
        </form>
    </div>


@endsection
