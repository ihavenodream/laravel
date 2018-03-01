@extends('layouts.app')

@section('content')
@include('vendor.ueditor.assets')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $question->title }}
                    @foreach($question->topics as $topic)
                        <a class="topic" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                    @endforeach
                </div>
                <div class="card-body">
                    {!! $question->body !!}
                </div>
                <div class="actions">
                    @if(Auth::check() && Auth::user()->owns($question))
                        <span class="card-link"><a href="/questions/{{ $question->id }}/edit">Edit</a></span>
                        <form action="/questions/{{ $question->id }}" method="post" class="delete-form card-text">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="button is-naked delete-button card-link">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $question->answers_count }} answers
                </div>
                <div class="card-body content">
                    @foreach($question->answers as $answer)
                        <div class="media">
                            <a href="#" class="media-left" style="width: 10%">
                                <img width="36" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="/questions/{{ $answer->user->name }}">
                                        {{ $answer->user->name }}
                                    </a>
                                </h4>
                                {!! $answer->body !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/questions/{{ $question->id }}/answer" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <script id="ueditor" name="body" type="text/plain"  class="form-control{{ $errors->has('body') ? '  is-invalid' : '' }}" style="width: 100%;height: 200px;" required>
                                {!! old('body') !!}
                            </script>
                            @if ($errors->has('body'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                    @endif
                        </div>
                        <button type="submit" class="btn btn-success" style="margin: 10px; float:right">Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('ueditor');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
@endsection
