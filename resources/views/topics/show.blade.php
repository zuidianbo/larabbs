{{--@extends('layouts.app')--}}

{{--@section('content')--}}

{{--<div class="container">--}}
  {{--<div class="col-md-10 offset-md-1">--}}
    {{--<div class="card ">--}}
      {{--<div class="card-header">--}}
        {{--<h1>Topic / Show #{{ $topic->id }}</h1>--}}
      {{--</div>--}}

      {{--<div class="card-body">--}}
        {{--<div class="card-block bg-light">--}}
          {{--<div class="row">--}}
            {{--<div class="col-md-6">--}}
              {{--<a class="btn btn-link" href="{{ route('topics.index') }}"><- Back</a>--}}
            {{--</div>--}}
            {{--<div class="col-md-6">--}}
              {{--<a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('topics.edit', $topic->id) }}">--}}
                {{--Edit--}}
              {{--</a>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<br>--}}

        {{--<label>Title</label>--}}
{{--<p>--}}
	{{--{{ $topic->title }}--}}
{{--</p> <label>Body</label>--}}
{{--<p>--}}
	{{--{{ $topic->body }}--}}
{{--</p> <label>User_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->user_id }}--}}
{{--</p> <label>Category_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->category_id }}--}}
{{--</p> <label>Reply_count</label>--}}
{{--<p>--}}
	{{--{{ $topic->reply_count }}--}}
{{--</p> <label>View_count</label>--}}
{{--<p>--}}
	{{--{{ $topic->view_count }}--}}
{{--</p> <label>Last_reply_user_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->last_reply_user_id }}--}}
{{--</p> <label>Order</label>--}}
{{--<p>--}}
	{{--{{ $topic->order }}--}}
{{--</p> <label>Excerpt</label>--}}
{{--<p>--}}
	{{--{{ $topic->excerpt }}--}}
{{--</p> <label>Slug</label>--}}
{{--<p>--}}
	{{--{{ $topic->slug }}--}}
{{--</p>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
{{--</div>--}}

{{--@endsection--}}
@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
      <div class="card ">
        <div class="card-body">
          <div class="text-center">
            作者：{{ $topic->user->name }}
          </div>
          <hr>
          <div class="media">
            <div align="center">
              <a href="{{ route('users.show', $topic->user->id) }}">
                <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px" height="300px">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
      <div class="card ">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $topic->title }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $topic->created_at->diffForHumans() }}
            ⋅
            <i class="far fa-comment"></i>
            {{ $topic->reply_count }}
          </div>

          <div class="topic-body mt-4 mb-4">
            {!! $topic->body !!}
          </div>


          @can('update', $topic)
            <div class="operate">
              <hr>
              <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                <i class="far fa-edit"></i> 编辑
              </a>
              <form action="{{ route('topics.destroy', $topic->id) }}" method="post"
                    style="display: inline-block;"
                    onsubmit="return confirm('您确定要删除吗？');">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                  <i class="far fa-trash-alt"></i> 删除
                </button>
              </form>
            </div>
          @endcan

        </div>
      </div>
    </div>
  </div>
@stop