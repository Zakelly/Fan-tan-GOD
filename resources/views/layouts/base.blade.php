<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	@section('head')
	<link href="{{ asset('/libs/iconfont.css') }}" rel="stylesheet" />
	<link href="{{ asset('/css/global.css') }}" rel="stylesheet" />
	<script src="{{ asset('/libs/jquery-2.2.3.min.js') }}"></script>
	<script src="{{ asset('/js/global.js') }}"></script>
	@show
</head>
<body>
	<div class="nav">
		<div class="content-wrapper">
			<a class="logo"><img src="/images/logo_formal4.png"></a>
			<div class="left">
				<a href="/">首页</a>
				<a href="{{ route('article.create') }}">开篇</a>
				<a href="{{ route('post.bookmarks') }}">书签</a>
			</div>
			@if (isset($user))
			<div class="right">
				<a class="avatar"><img src="{{ $user->avatar }}"></a>
				<a>{{ $user->username }}</a>
				<a href="/auth/logout">注销</a>
			</div>
			@else
			<div class="right">
				<a href="/auth/login">登录</a>
				<a href="/auth/register">注册</a>
			</div>
			@endif
		</div>
	</div>
	<div class="page-content">
	@section('body')

	@show
	</div>
</body>
</html>
