@extends('layouts.main_blog')

@section("title", $news->title . " | Блог")
@section("description", $news->title . ". Блог на https://agtender.com/")

@section('content')
    

<main class="v-main" style="padding: 50px 0px 350px;" data-booted="true">
    <div class="v-main__wrap">
        <div class="container container--fluid grid-list-lg">
            <div class="layout row wrap">
                <div class="flex md12 xs12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-title card">
                                    <h1>{{ $news->title }}</h1>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div>
                                        {!! $news->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection

