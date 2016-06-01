<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ strip_tags($__env->yieldContent('title')) }} · Admin</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/comments/css/admin.css">
</head>
<body>
    @include('comments::admin.partials.navbar')

    <div class="container">
        <div id="admin" class="col-md-10 col-md-offset-1">
            <h3 class="page-header">
                @yield('title')
            </h3>

            @yield('content')
        </div>
    </div>

    @include('comments::templates/alert')

    <script>
        window.adminConfig = {
            csrfToken: "{{ csrf_token() }}",
            routes: {
                index: "{{ route('comments.admin.index') }}",
                show: "{{ route('comments.admin.show', ':id') }}",
                update: "{{ route('comments.admin.update', ':id') }}",
                destroy: "{{ route('comments.admin.destroy', ':id') }}",
                settings: "{{ route('comments.admin.settings') }}"
            }
        };
    </script>
    <script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>
    <!-- <script src="/js/vue.js"></script> -->
    <script src="/vendor/comments/js/utils.js"></script>
    <script src="/vendor/comments/js/admin.js"></script>
</body>
</html>
