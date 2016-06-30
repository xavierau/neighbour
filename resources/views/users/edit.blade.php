@extends("layouts.app")

@section("content")

    <div class="container">
        <form action="{{route("admin.clans.update", $clan->id)}}" class="form" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
                <label for="name">Clan Label</label>
                <input type="text" class="form-control" name="label" id="label" value="{{$clan->label}}">
                {!! $errors->first('label', '<p class="text-danger">:message</p>') !!}
            </div>

            <div class="form-group">
                <label for="code">Clan Code </label>
                <input type="text" class="form-control" name="code" id="code" value="{{$clan->code}}">
                {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
                <p class="helper-text">Must be unique</p>
            </div>

            <div class="form-group">
                <a href="{{route("admin.clans.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="Update">
            </div>

        </form>
    </div>

@endsection