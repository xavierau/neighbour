@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="{{route("admin.users.store")}}" class="form" method="POST">
            {{csrf_field()}}
            <fieldset>
                <legend>Basic Info</legend>
                <div class="form-group">
                    <label for="name">User First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="">
                    {!! $errors->first('first_name', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    <label for="name">User Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="">
                    {!! $errors->first('last_name', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    <label for="name">User Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="">
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                </div>
                
                <div class="form-group">
                    <label for="name">User Password</label>
                    <input type="text" class="form-control" name="password" id="password" value="">
                    {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                </div>

               
            </fieldset>



            <fieldset>
                <legend>User Clan</legend>
                {!! $errors->first('clan_id', '<p class="text-danger">:message</p>') !!}
                <table class="table">
                    <thead>
                    <th>Select</th>
                    <th>Clan</th>
                    </thead>
                    @foreach($clans as $clan)
                        <tr>
                            <td>
                                <input
                                        name="clan_id"
                                        type="radio"
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
                {!! $errors->first('role_id', '<p class="text-danger">:message</p>') !!}
                <table class="table">
                    <thead>
                    <th>Select</th>
                    <th>Role</th>
                    </thead>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input
                                        name="role_id"
                                        type="radio"
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
