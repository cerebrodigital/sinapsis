@extends('app')
@section('title') Manage :: @parent @stop


@section('content')

   <h2>Manage Gamify Application</h2>
   <hr />
    <div class="row">
        <div class="col-md-12">
            <!-- Gamify Angular Js Application -->
            <div ng-app="mediasoftApp">
              <div ng-view>loading...</div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
   <script>
  var UID = '{{ Auth::id() }}';
  var CSRF_TOKEN = '{{ csrf_token() }}';

</script>
<!-- Angular JS Application For Gamify Management -->
<script src="{{{ asset('ng/shared/core.js') }}}"></script>
<script src="{{{ asset('ng/shared/plupload.js') }}}"></script>
<script src="{{{ asset('ng/gamify/js/manage.js') }}}"></script>

<!-- Uploader -->
<script src="{{{ asset('plupload/js/plupload.full.js') }}}"></script>
<!-- Code Pretifier -->
<script type="text/javascript" src="plugins/prettify/prettify.js"></script>
<script type="text/javascript">
  $(function () {
    $(window).load(prettyPrint());
  });
</script>
@endsection