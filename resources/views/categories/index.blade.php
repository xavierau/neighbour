@extends("layouts.app")

@section("content")
    <div class="container">
        <h1>Categories List <span class="pull-right"><a href="/categories/new" class="btn btn-success">Create New</a></span></h1>
        <table class="table">
            <thead>
            <td>Category Name</td>
            <td>Actions</td>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td style="color:black">{{$category->name}}</td>
                    <td>
                        <a href="/categories/{{$category->id}}/edit" class="btn btn-info">Edit</a>
                        <form action="/categories/{{$category->id}}/delete" method="POST">
                            <input type="hidden" value="delete" name="_method">
                            {{csrf_field()}}
                            <input type="submit" value="delete" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection