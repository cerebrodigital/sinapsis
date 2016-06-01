@extends('app')
@section('title') Display Test :: @parent @stop


@section('content')

   <h2>Display Test Achievement App</h2>
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
<script src="/backend/gamify/ng/shared/core.js"></script>
<script src="/backend/gamify/ng/shared/plupload.js"></script>
<script src="/backend/gamify/ng/gamify/js/display.js') }}}"></script>

<!-- Uploader -->
<script src="/backend/gamify/plupload/js/plupload.full.js"></script>
<!-- Code Pretifier -->
<script type="text/javascript" src="/backend/gamify/plugins/prettify/prettify.js"></script>
<script type="text/javascript">
  $(function () {
    $(window).load(prettyPrint());
  });
</script>
@endsection