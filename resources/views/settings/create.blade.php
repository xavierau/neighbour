@extends("layouts.app")

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-header">New Setting</h1>
            </div>
            <div class="panel-body">
                <form action="/admin/settings" method="POST" class="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="label">Label: </label>
                        <input type="text" name="label" id="label" class="form-control" autofocus>
                        @if ($errors->has('label'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="code">Code: </label>
                        <input type="text" name="code" id="code" class="form-control">
                        @if ($errors->has('code'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Type: </label>
                        <select name="type" id="type" class="form-control">
                            <option value="text">Text</option>
                            <option value="file">File</option>
                        </select>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="value">Value: </label>
                        <input type="text" name="value" id="value" class="form-control">
                        @if ($errors->has('value'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <a href="/admin/settings" class="btn btn-default">Back</a>
                        <button class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection