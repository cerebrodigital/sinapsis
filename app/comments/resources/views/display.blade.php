<?php $config = app('comments'); ?>

<div class="comments">
    <div id="{{$id or 'comments'}}">
        <comments></comments>
    </div>
</div>

@include('comments::templates/alert')
@include('comments::templates/comment')
@include('comments::templates/comments')
@include('comments::templates/post-form')

<script>
    window.commentsConfig = {
        pageId: '{{ $pageId or URL::full() }}',
        authorized: {{ $config['guest'] || Auth::check() ? 'true' : 'false' }},
        authenticated: {{ Auth::check() ? 'true' : 'false' }},
        captchaRequired: {{ $config['captcha_required'] ? 'true' : 'false' }},
        votes: {{ $config['votes'] ? 'true' : 'false' }},
        replies: {{ $config['replies'] ? 'true' : 'false' }},
        maxLength: {{ $config['max_length'] ?: 'null' }},
        sortBy: {{ $config['default_sort'] }},
        sortOptions: {
            1: '@lang('comments::all.newest')',
            // 2: '@lang('comments::all.oldest')',
            3: '@lang('comments::all.best')',
        },
        user: {!! ! app('comments.author')->guest() ? app('comments.author')->toJson() : 'null' !!},
        uid: '{{ session('comments_uid') }}',
        storageKey: 'comment_author',
        permalink: '{{ URL::full() }}',
        referrer: '{{ Request::server('HTTP_REFERER') }}',
        csrfToken: '{{ csrf_token() }}',
        recaptcha: '{{ Config::get('recaptcha.siteKey') }}',
        routes: {
            index: '{{ route('comments.index') }}',
            store: '{{ route('comments.store') }}',
            update: '{{ route('comments.update', ':id') }}',
            vote: '{{ route('comments.vote', ':id') }}',
        },
        @if ($config['real_time'])
        broadcasting: {
            driver: '{{ config('broadcasting.default') }}',
            socket: '{{ config('broadcasting.connections.redis.socket') }}',
            pusherKey: '{{ config('broadcasting.connections.pusher.key') }}',
        },
        @endif
    };
</script>

@if ($config['captcha_required'])
    <script src="//www.google.com/recaptcha/api.js"></script>
@endif

@if ($config['real_time'])
    @if (config('broadcasting.default') === 'pusher')
        <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    @else
        <script src="//cdn.socket.io/socket.io-1.4.5.js"></script>
    @endif
@endif

@if ($config['emoticons'])
    <script src="//twemoji.maxcdn.com/twemoji.min.js"></script>
@endif
