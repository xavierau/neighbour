@extends("layouts.app")

@section("content")
    <div class="container">
        <form action="/categories/{{$category->id}}" class="form" method="POST">
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{$category->name}}">
            </div>

            <div class="form-group">
                <label for="code">Category Code </label>
                <input type="text" class="form-control" name="code" id="code" value="{{$category->code}}">
                <p class="helper-text">Must be unique</p>
            </div>

            <div class="form-group">
                <label for="showInPublic">Will this Category Show In public?</label>
                <select name="showInPublic" id="showInPublic" class="form-control">
                    <option value="0" @if($category->showInPublic)selected @endif>No</option>
                    <option value="1" @if($category->showInPublic)selected @endif>Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="showInList">Will this Category Show In Navigation List?</label>
                <select name="showInList" id="showInList" class="form-control">
                    <option value="0" @if($category->showInList)selected @endif>No</option>
                    <option value="1" @if($category->showInList)selected @endif>Yes</option>
                </select>
            </div>

            <div class="form-group">
                <a href="/categories" class="btn btn-default">Back</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>
    
    
@endsection