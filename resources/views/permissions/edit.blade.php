@extends("layouts.app")

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="permission-header">Edit Permission</h1>
            </div>
            <div class="panel-body">
                <form action="/admin/permissions/{{$permission->id}}" method="POST" class="form">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="label">Label: </label>
                        <input type="text" name="label" id="label" class="form-control" value="{{$permission->label}}" autofocus>
                        @if ($errors->has('label'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <a href="{{route("admin.permissions.index")}}" class="btn btn-default">Back</a>
                        <button class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection