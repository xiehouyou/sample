@extends('layouts.default')
@section('title', $user->name)
@section('content')
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div class="col-md-12">
      <div class="col-md-offset-2 col-md-8">
        <section class="user_info">
          @include('shared._user_info', ['user' => $user])
        </section>
      </div>
    </div>
    <!-- 在用户的个人页面使用该局部视图和渲染微博的分页链接了。 -->
    	  <div class="col-md-12">
      @if (count($statuses) > 0)
        <ol class="statuses">
          @foreach ($statuses as $status)
            @include('statuses._status')
          @endforeach
        </ol>
        {!! $statuses->render() !!}
      @endif
    </div>
  </div>
</div>
@stop