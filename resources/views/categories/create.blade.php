@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="/categories" class="form" method="POST">
            {{csrf_field()}}

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" name="name" id="name" value="">
            </div>

            <div class="form-group">
                <label for="code">Category Code </label>
                <input type="text" class="form-control" name="code" id="code" value="">
                <p class="helper-text">Must be unique</p>
            </div>

            <div class="form-group">
                <label for="showInPublic">Will this Category Show In public?</label>
                <select name="showInPublic" id="showInPublic" class="form-control">
                    <option value="0" >No</option>
                    <option value="1" >Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="showInList">Will this Category Show In Navigation List?</label>
                <select name="showInList" id="showInList" class="form-control">
                    <option value="0" >No</option>
                    <option value="1" >Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="canSelect">Can User select this category?</label>
                <select name="canSelect" id="canSelect" class="form-control">
                    <option value="0" >No</option>
                    <option value="1" >Yes</option>
                </select>
            </div>

            <div class="form-group">
                <a href="/categories" class="btn btn-default">Back</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>


@endsection