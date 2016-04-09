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
            <a class="{{ $ancestor->id == $post->id ? 'active' : '' }}"
               href="{{ route('post.view', $ancestor->id) }}">
                <span class="title">{{ $ancestor->title }}</span>
                <p class="description">{{ $ancestor->description }}</p>
            </a>
        @endforeach
    </div>
    <div class="buttons">
        <a href="#"><i class="icon iconfont">&#xe624;</i></a>
        @if ($bookmarked)
            <a class="active" onclick="Bookmark(this)">
                <i class="icon iconfont">&#xe647;</i>
            </a>
        @else
            <a onclick="Bookmark(this)">
                <i class="icon iconfont">&#xe647;</i>
            </a>
        @endif
        <a href="{{ route('post.create', $post->id) }}"><i class="icon iconfont">&#xe655;</i></a>
        @if ($post->isLiked(Auth::id()))
        <a class="active" onclick="Like(this)">
            <i class="icon iconfont">&#xe982;</i>
        </a>
        @else
        <a onclick="Like(this)">
            <i class="icon iconfont">&#xe982;</i>
        </a>
        @endif
    </div>
    <div class="main-read-area">
        <div class="post-title">
            <header>{{ $post->title }}</header>
            <div class="meta-info">
                <label>作者：</label>
                <a class="global-avatar"><img src="{{ $post->user->avatar }}"></a>
                <span>{{ $post->user->username }}</span>
                <label>发布时间：</label>
                <span>{{ $post->created_at }}</span>
                <label>点赞量：</label>
                <span>{{ $post->like_count }}</span>
            </div>
        </div>
        <div class="post-content">{{ $post->content }}</div>
    </div>
    <header class="choices-header">
        <span>选择路线</span>
    </header>
    <div class="choices">
        @foreach ($post->childPosts as $child)
            <a href="{{ route('post.view', $child->id) }}">
                <span class="title">{{ $child->title }}</span>
                <p class="description">{{ $child->description }}</p>
            </a>
        @endforeach
        <a class="new-choice" href="{{ route('post.create', $post->id) }}">
            <span class="title"><i class="icon iconfont">&#xe655;</i>续写新故事</span>
        </a>
    </div>
    <script>
        function Like(ctrl) {
            var to = !$(ctrl).hasClass("active");
            var url = ['{{ route('post.unlike', $post->id) }}', '{{ route('post.like', $post->id) }}'][to ? 1 : 0];
            $.post(url, function (data) {
                if (data.success)
                    if (to)
                        $(ctrl).addClass("active");
                    else
                        $(ctrl).removeClass("active");
            });
        }
        function Bookmark(ctrl) {
            var to = !$(ctrl).hasClass("active");
            var url = ['{{ route('post.unbookmark', $post->id) }}', '{{ route('post.bookmark', $post->id) }}'][to ? 1 : 0];
            $.post(url, function (data) {
                if (data.success)
                    if (to)
                        $(ctrl).addClass("active");
                    else
                        $(ctrl).removeClass("active");
            });
        }
    </script>
    @stop