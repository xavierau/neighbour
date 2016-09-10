@extends("layouts.app")

@section("content")
    
    
    <div class="container">
        <form action="{{route("admin.users.update", $user->id)}}" class="form" method="POST">
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}
            <fieldset>
                <legend>Basic Info</legend>
                <div class="form-group">
                    <label for="name">User First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{$user->first_name}}">
                    {!! $errors->first('first_name', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    <label for="name">User Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{$user->last_name}}">
                    {!! $errors->first('last_name', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    <label for="name">User Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}">
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
                                        @if($user->clan_id == $clan->id) checked @endif
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
                                        @if($user->roles()->first()->id == $role->id) checked @endif
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
                <a href="{{route("admin.users.index")}}" class="btn btn-info">Back</a>
                <input type="submit" class="btn btn-success" value="update">
            </div>


        </form>
    </div>


@endsection