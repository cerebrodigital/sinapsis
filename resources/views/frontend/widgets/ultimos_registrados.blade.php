            <?php
              $users = \App\User::orderBy('created_at', 'DESC')->take(25)->get();
            ?>
            <div class="panel">
              <h2>Últimos usuarios registrados
              </h2>
              <div class="panel-content">
                
                <div class="panel-duel">
                <p>
                @foreach($users as $user)
                   <a href="{{route('dashboard.profile', $user->id)}}">{{$user->username}}</a>, 
                @endforeach
                </p>
                </div>
                
                <div class="panel-duel-voting">
                  <div class="clear-float"></div>
                </div>
                
              </div>
            <!-- END .panel -->
            </div>