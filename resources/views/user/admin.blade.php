@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
                <img width="1050" height="240" src="{{ asset('/images/profile/default.jpg') }}" alt="{{ $public->name }}的背景">
            </div>
        <div class="row">
                <div class="media" style="background-color: white;width: 1050px;">
                    <img class="mr-3 rounded-circle" width="168" src="{{ $public->avatar  }}" alt="{{ $public->name }}" style="margin-top: -75px;margin-left: 1rem">
                    <div class="media-body" style="margin-top: 20px;margin-bottom: 20px;">
                        <h2>{{ $public->name }}</h2>
                        <h5 style="color: #007bff">{{ $public->profiles->sign or "这个人很懒....." }}</h5>
                    </div>
                    <div style="display: block;" class="pull-right">
                        <a
                                class="btn btn-default pull-right"
                                style="display: inline-block;margin-top: 3rem;margin-right: 1rem;border: 1px solid green"
                                href="/profile/edit/{{ Auth::id() }}"
                        >编辑个人资料</a>
                    </div>
                </div>
            </div>
        <div class="row" style="margin-top: 1.5rem;">
            <div class="col-md-8" style="background-color: white;margin-right: 0.5rem">
                <ul class="nav nav-pills" style="margin-top: 1rem;padding-left: 1rem" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="question-tab" href="#question" data-toggle="tab" aria-selected="true">问题</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="answer-tab" href="#answer" data-toggle="tab" aria-selected="false">回答</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="following-tab" href="#following" data-toggle="tab" aria-selected="false">我关注的人</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="follower-tab" href="#follower" data-toggle="tab" aria-selected="false">关注我的人</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="favorite-tab" href="#favorite" data-toggle="tab" aria-selected="false">我的收藏</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="topic-tab" href="#topic" data-toggle="tab" aria-selected="false">关注的话题</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notice-tab" href="#notice" data-toggle="tab" aria-selected="false">系统通知</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                        <span style="font-weight: 600">我的问题</span>
                        <hr>
                        @foreach($public->getQuestions($public->id) as $question)
                            <div class="card" style="margin-bottom: 1rem">
                                <div class="card-header">
                                    {{ $question->title }}
                                </div>
                                <div class="card-body">
                                    <p>{!! $question->body !!}</p>
                                </div>
                                <div class="actions">
                                    @if(Auth::check() && Auth::user()->owns($question))
                                        <button class="card-link btn"><a href="/questions/{{ $question->id }}/edit">编辑</a></button>
                                        <form action="/questions/{{ $question->id }}" method="post" class="delete-form card-text">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn card-link btn-danger">删除</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
                        <span style="font-weight: 600">我的回答</span>
                        <hr>
                        @foreach($public->getQuestion($public->id) as $questions)
                            @foreach($questions as $question)
                                <div class="card" style="margin-bottom: 1rem">
                                    <div class="card-header">
                                        <a href="/questions/{{ $question->id }}">{{ $question->title }}</a>
                                    </div>
                                    <div class="card-body">
                                        <p>{!! $question->body !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
                        <span style="font-weight: 600">我关注的人</span>
                        <hr>
                        @foreach($public->getFollowings($public->id) as $following)
                            @foreach($following as $follow)
                                <div>
                                    <img width="48" src="{{ $follow->avatar }}" alt="{{ $follow->name }}">
                                    <a href="/user/{{ $follow->id }}" style="font-size: 18px;font-weight: bold;">{{ $follow->name }}</a>
                                    <hr>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="follower" role="tabpanel" aria-labelledby="follower-tab">
                        <span style="font-weight: 600">关注我的人</span>
                        <hr>
                        @foreach($public->getFollowers($public->id) as $following)
                            @foreach($following as $follow)
                                <div>
                                    <img width="48" src="{{ $follow->avatar }}" alt="{{ $follow->name }}">
                                    <a href="/user/{{ $follow->id }}" style="font-size: 18px;font-weight: bold;">{{ $follow->name }}</a>
                                    <hr>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="favorite" role="tabpanel" aria-labelledby="favorite-tab">
                        <span style="font-weight: 600">我的收藏</span>
                        <hr>
                        @foreach($public->getFavorites() as $favorites)
                            @foreach($favorites as $favorite)
                                <div class="card" style="margin-bottom: 1rem">
                                    <div class="card-header">
                                        <a href="/questions/{{ $favorite->id }}" style="font-weight: bold;font-size: 20px;">{{ $favorite->title }}</a>
                                        <favorite-question question="{{ $favorite->id }}" class="pull-right"></favorite-question>
                                    </div>
                                    <div class="card-body">
                                        <p>{!! $favorite->body !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="topic" role="tabpanel" aria-labelledby="topic-tab">
                        <span style="font-weight: 600">关注的话题</span>
                        <hr>
                    </div>
                    <div class="tab-pane fade" id="notice" role="tabpanel" aria-labelledby="notice-tab">
                        <span style="font-weight: 600">消息通知</span>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach($public->notifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row text-center" style="background-color: white;padding-top: 10px">
                    <div class="col-md-6" style="border-right: #3b97d7 solid 1px">
                        <span>关注了</span>
                        <p style="font-weight: bold;font-size: 20px;margin-top: 0.2rem">{{ $public->followings_count }}</p>
                    </div>
                    <div class="col-md-6">
                        <span>关注者</span>
                        <p style="font-weight: bold;font-size: 20px;margin-top: 0.2rem">{{ $public->followers_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
