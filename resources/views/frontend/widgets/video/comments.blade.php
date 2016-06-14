<section class="comments endless-pagination" data-next-page="{{ $comments->nextPageUrl() }}">
  <ol id="comments">
  @foreach($comments as $com)
    <li>
      <div class="commment-content">
        <div class="comment-block">
          <a href="http://facebook.com/{{$com->fb_id}}">
        @if($com->type == 'facebook')
            <img src="http://graph.facebook.com/{{$com->fb_id}}/picture?type=square">
        @endif
          </a>
          <div class="comment-text">
            <div>
              <strong class="user-nick"><a href="#">{{$com->name}}</a></strong>
              <span class="time-stamp">{{$com->created_at}}</span>
            </div>
            <p>{{$com->message}}</p>
            <!-- <a href="#" class="reply-button"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply this comment</a> -->
          </div>
          <br>
        </div>
      </div>
    </li>
  @endforeach
  <a href="{{$comments->nextPageUrl()}}" class="cargarMas">Cargar más comentarios</a>
</ol>
</section>
<style>
  .cargarMas {
  -moz-box-shadow:inset 0px 1px 0px 0px #7a8eb9;
  -webkit-box-shadow:inset 0px 1px 0px 0px #7a8eb9;
  box-shadow:inset 0px 1px 0px 0px #7a8eb9;
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #637aad), color-stop(1, #5972a7));
  background:-moz-linear-gradient(top, #637aad 5%, #5972a7 100%);
  background:-webkit-linear-gradient(top, #637aad 5%, #5972a7 100%);
  background:-o-linear-gradient(top, #637aad 5%, #5972a7 100%);
  background:-ms-linear-gradient(top, #637aad 5%, #5972a7 100%);
  background:linear-gradient(to bottom, #637aad 5%, #5972a7 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#637aad', endColorstr='#5972a7',GradientType=0);
  background-color:#637aad;
  border:1px solid #314179;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Arial;
  font-size:13px;
  font-weight:bold;
  padding:6px 12px;
  text-decoration:none;
}
.cargarMas:hover {
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #5972a7), color-stop(1, #637aad));
  background:-moz-linear-gradient(top, #5972a7 5%, #637aad 100%);
  background:-webkit-linear-gradient(top, #5972a7 5%, #637aad 100%);
  background:-o-linear-gradient(top, #5972a7 5%, #637aad 100%);
  background:-ms-linear-gradient(top, #5972a7 5%, #637aad 100%);
  background:linear-gradient(to bottom, #5972a7 5%, #637aad 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5972a7', endColorstr='#637aad',GradientType=0);
  background-color:#5972a7;
}
.cargarMas:active {
  position:relative;
  top:1px;
}
</style>
