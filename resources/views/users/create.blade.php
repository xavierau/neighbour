@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="{{route("admin.clans.store")}}" class="form" method="POST">
            {{csrf_field()}}
            <fieldset>
                <legend>Basic Info</legend>
                <div class="form-group">
                    <label for="name">Clan Label</label>
                    <input type="text" class="form-control" name="label" id="label" value="">
                    {!! $errors->first('label', '<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    <label for="code">Clan Code </label>
                    <input type="text" class="form-control" name="code" id="code" value="">
                    {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
                    <p class="helper-text">Must be unique</p>
                </div>
            </fieldset>



            <fieldset>
                <legend>User Clan</legend>
                <table class="table">
                    <thead>
                    <th>Select</th>
                    <th>Clan</th>
                    </thead>
                    @foreach($clans as $clan)
                        <tr>
                            <td>
                                <input
                                        name="permissions[]"
                                        type="checkbox"
                                        value="{{$clan->id}}"
                                >
                            </td>
                            <td>
                                {{$clan->label}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </fieldset>
            <fieldset>
                <legend>User Roles</legend>
                <table class="table">
                    <thead>
                    <th>Select</th>
                    <th>Role</th>
                    </thead>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input
                                        name="permissions[]"
                                        type="checkbox"
                                        value="{{$role->id}}"
                                >
                            </td>
                            <td>
                                {{$role->label}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </fieldset>



            <div class="form-group">
                <a href="{{route("admin.clans.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="create">
            </div>


        </form>
    </div>


@endsection
