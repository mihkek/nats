@section('title', 'Новости и события')
@extends('admin.template')
@section('main')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>


    <div class="page-content-wrapper">
        <div class="page-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ошибка!</strong> при заполнение.<br><br>
                    <ul>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="/admin/new-news/{{isset($news->id)?$news->id:0}}" enctype="multipart/form-data">
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <img src="{{isset($news->image)?$news->image:'/img/no-image.jpg'}}" style="width: 100px;">
                        <input type="file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="usr">Название:</label>
                        <input type="text" class="form-control" name="title"
                               value="{{isset($news->title)?$news->title:''}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">Url:</label>
                        <input type="text" class="form-control" name="slug"
                               value="{{isset($news->slug)?$news->slug:''}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">Краткое описание:</label>
                        <textarea type="text" class="form-control" name="description">
                            {{isset($news->description)?$news->description:''}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <strong>Контент:</strong>
                        <textarea id="texteditor" name="content">{{isset($news->content)?$news->content:''}}</textarea>

                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>

        </div>
        <style>
            .page-content-wrapper .page-content {
                overflow-y: scroll;
            }
        </style>
        <script>
            CKEDITOR.replace( 'texteditor' );
        </script>
       
    </div>
@endsection('main')
