@section('title', '首页')

@section('body')
    @parent
    <div>欢迎{{$user->username}}</div>
@show