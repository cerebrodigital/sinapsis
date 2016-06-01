
<div class="shout_box">
<div class="header">Shoutbox Sinapsis General: online#(123)<div class="close_btn">&nbsp;</div></div>
  <div class="toggle_chat">
  <div class="message_box">
  <?php $messages = \App\models\Shout::with('user')->orderBy('created_at', 'DESC')->get(); ?>
  @foreach($messages as $msg)
      <div class="shout_msg"><time>{{$msg->created_at}}</time><span class="username">{{$msg->user->name}} - {{$msg->user->username}}</span> <span class="message">{{$msg->message}}</span></div>
  @endforeach  
    </div>
    <div class="user_info">
    @if(\Auth::check())
      <input type="hidden" name="user_id" id="user_id" type="text" value="{{\Auth::user()->id}}" />
      <input name="message" id="message" type="text" placeholder="Tu mensaje" maxlength="15" />
    @else
      <h4 style="color:white;" align="center">No puedes publicar hasta que te <a href="#" style="color:orange;">registres</a></h4>
    @endif
   
    </div>
  </div>
</div>


