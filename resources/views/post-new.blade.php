@extends('layouts/base')

@section('title', '续写')

@section('head')
    @parent
    <link href="{{ asset('/css/post-new.css') }}" rel="stylesheet" />
    @stop

@section('body')
    @parent
    <form method="POST" action="#">
        <div class="left">
            <div class="left-title">过往情节</div>
            @if (isset($post))
            <ul class="node-selector">
                @foreach ($post->ancestors as $ancestor)
                    <li>
                        <span class="mode1">{{ $ancestor->title }}</span>
                        <span class="mode2">{{ $ancestor->description }}</span>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class="right">
            <div class="input-title-wrapper">
                <input class="input-title" name="title" placeholder="请输入标题" maxlength="48">
            </div>
            <div class="input-content-wrapper">
                <textarea class="input-content" name="content" placeholder="请输入内容" maxlength="9990"></textarea>
            </div>
            <div class="input-content-wrapper">
                <textarea class="input-description" name="description" placeholder="请输入描述（可选）" maxlength="54"></textarea>
            </div>
        </div>


        <div class="controls">
            <div class="content-wrapper">
                <button class="button primary" type="submit">保存</button>
                <a class="button" onclick="history.back()">返回</a>
            </div>
        </div>
    </form>
    @stop