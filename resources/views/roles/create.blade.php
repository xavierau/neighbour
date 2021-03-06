@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="{{route("admin.roles.store")}}" class="form" method="POST">
            {{csrf_field()}}

            <div class="form-group">
                <label for="name">Role Label</label>
                <input type="text" class="form-control" name="label" id="label" value="">
            </div>

            <div class="form-group">
                <label for="code">Role Code </label>
                <input type="text" class="form-control" name="code" id="code" value="">
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
                <input type="submit" class="btn btn-success" value="create">
            </div>


        </form>
    </div>


@endsection
