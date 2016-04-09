@extends('layouts/base')

@section('title', '书签')

@section('head')
    @parent
    <link href="{{ asset('/css/bookmark.css') }}" rel="stylesheet" />
@stop

@section('body')
    @parent
    <div class="bookmarks-container">
        @foreach ($bookmarks as $bookmark)
        <a href="{{ route('post.view', $bookmark->post_id) }}">
            <button class="remove" onclick="return Bookmark(this, {{ $bookmark->post_id }})">&times;</button>
            <div class="centered">
                <header>{{ $bookmark->post->title }}</header>
                <p class="description">{{ $bookmark->post->description }}</p>
            </div>
            <small class="author">{{ $bookmark->post->user->username }}</small>
            <small class="date">{{ $bookmark->created_at->toDateString() }}</small>
            <div class="article-info">{{ $bookmark->article->rootPost->title }}</div>
        </a>
        @endforeach
    </div>
    <script>
        function Bookmark(ctrl, id) {
            $.post('/post/' + id + '/unbookmark', function (data) {
                if (data.success)
                    $(ctrl).closest("a").remove();
            });
            return false;
        }
    </script>
@stop