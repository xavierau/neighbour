@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="{{route("admin.clans.store")}}" class="form" method="POST">
            {{csrf_field()}}

            <div class="form-group">
                <label for="name">Building Label</label>
                <input type="text" class="form-control" name="label" id="label" value="">
                {!! $errors->first('label', '<p class="text-danger">:message</p>') !!}
            </div>

            <div class="form-group">
                <label for="code">Building Code </label>
                <input type="text" class="form-control" name="code" id="code" value="">
                {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
                <p class="helper-text">Must be unique</p>
            </div>

            <div class="form-group">
                <a href="{{route("admin.clans.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="create">
            </div>


        </form>
    </div>


@endsection
