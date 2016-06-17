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

            <div class="form-group">
                <a href="{{route("admin.roles.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="create">
            </div>


        </form>
    </div>


@endsection
