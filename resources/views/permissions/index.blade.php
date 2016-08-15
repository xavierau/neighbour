@extends("layouts.app")
@section('style')
    <style>
        button.pull-right.delete {
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="permission-header">Permissions
                    <a href="{{route("admin.permissions.create")}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i>
                        Create New</a></h1>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <th>Label</th>
                    <th>Code</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->label}}</td>
                            <td>{{$permission->code}}</td>
                            <td>
                                <form action="{{route("admin.permissions.destroy", $permission->id)}}" method="POST"
                                      onsubmit="confirmDelete(event)">
                                    <input type="hidden" name="_method" value="delete">
                                    {{csrf_field()}}
                                    <button class="btn btn-danger pull-right delete">Delete</button>
                                </form>
                                <a href="{{route("admin.permissions.edit", $permission->id)}}" class="btn btn-info pull-right">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        confirmDelete = function (event) {
            event.preventDefault();

            swal({
                text: "Are you sure to delete this item.",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonClass: "btn-danger btn btn-lg",
                cancelButtonClass: "btn-default btn btn-lg",
                buttonsStyling: false
            }).then(function (isConfirm) {
                if (isConfirm)
                    event.target.submit();
            });
            return false;
        }
    </script>
@endsection