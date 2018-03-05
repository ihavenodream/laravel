@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            @foreach($questions as $question)
                <div class="media">
                        <a href="#" class="media-left">
                            <img class="media-object" width="96" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                        </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/questions/{{ $question->id }}">
                                {{ $question->title }}
                            </a>
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection