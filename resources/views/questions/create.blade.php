@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">发表问题</div>

                <div class="card-body">
                    <form action="/questions" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="title">标题</label>
                            <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" placeholder="标题" id="title" required />
                            @if ($errors->has('title'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <select name="topics[]" class="form-control js-example-placeholder-multiple js-data-example-ajax" multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group">
                            <lable for="ueditor">问题内容</lable>
                            <script id="ueditor" name="body" type="text/plain"  class="{{ $errors->has('body') ? '  is-invalid' : '' }}" required>
                                {!! old('body') !!}
                            </script>
                            @if ($errors->has('body'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success" style="margin: 10px; float:right">发表</button>
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

    $(document).ready(function() {
        function formatTopic (topic) {
            return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            topic.name ? topic.name : "Laravel"   +
                "</div></div></div>";
        }
        function formatTopicSelection (topic) {
            return topic.name || topic.text;
        }
        $(".js-example-placeholder-multiple").select2({
            tags: true,
            placeholder: '选择相关话题',
            minimumInputLength: 2,
            ajax: {
                url: '/api/topics',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            templateResult: formatTopic,
            templateSelection: formatTopicSelection,
            escapeMarkup: function (markup) { return markup; }
        });
    });
    </script>
@endsection
@endsection
