@extends('layouts/base')

@section('title', '阅读')

@section('head')
    @parent
    <link href="{{ asset('/css/read.css') }}" rel="stylesheet" />
@stop

@section('body')
    @parent
    <div class="read-trail">
        <header>
            <span>阅读轨迹</span>
        </header>
        @foreach ($post->ancestors as $ancestor)
            @if ($ancestor->id == $post->id)
            <a class="active" href="{{ route('post.view', $ancestor->id) }}">
            @else
            <a href="{{ route('post.view', $ancestor->id) }}">
            @endif
                <span class="title">{{ $ancestor->title }}</span>
                <p class="description">{{ $ancestor->description }}</p>
            </a>
        @endforeach
    </div>
    <div class="main-read-area">
        <div class="post-title">
            <header>{{ $post->title }}</header>
            <div class="meta-info">
                <label>作者：</label>
                <span>{{ $post->user->username }}</span>
                <label>发布时间：</label>
                <span>{{ $post->created_at }}</span>
            </div>
        </div>
        <div class="post-content">{{ $post->content }}</div>
        <ul class="choices">
            @foreach ($post->childPosts as $child)
            <li><a href="{{ route('post.view', $child->id) }}">{{ $child->title }}</a></li>
            @endforeach
        </ul>
    </div>
@stop