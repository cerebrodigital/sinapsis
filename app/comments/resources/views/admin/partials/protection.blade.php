<form v-on:submit="save">
    <input type="hidden" name="group" value="protection">

    <alert :success="success"></alert>

    <div class="form-group">
        <label for="captcha">Captcha</label>
        <select name="captcha" id="captcha" class="form-control">
            @foreach (['None', 'Guests', 'Logged users', 'All'] as $val => $text)
                <option value="{{ $val }}" {{ $config['captcha'] === $val ? 'selected' : '' }}>{{ $text }}</option>
            @endforeach
        </select>
        <p class="help-block">
            Specify for which users captcha is enabled. Make sure reCAPTCHA is
            <a href="http://docs.hazzardweb.com/ajax-comment-system-laravel/master/configuration#recaptcha" target="_blank">configured</a>!
        </p>
    </div>

    <div class="form-group">
        <label for="throttle">Throttle Comment Posts</label>
        <select name="throttle" v-disable="loading" id="throttle" class="form-control">
            <option value="1" {{ $config['throttle'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['throttle'] ? 'selected': '' }}>No</option>
        </select>
        <p class="help-block">Specify if you want to enable the throttle for comment posts.</p>
    </div>

    <div class="form-group">
        <label for="throttle_max_attempts">Throttle Max Attempts</label>
        <input type="text" name="throttle_max_attempts" id="throttle_max_attempts" value="{{ $config['throttle_max_attempts'] }}" class="form-control">
        <p class="help-block">The maximum number of comment post attempts for delaying further attempts.</p>
    </div>

    <div class="form-group">
        <label for="throttle_lockout_time">Throttle Lockout Time</label>
        <input type="text" name="throttle_lockout_time" id="throttle_lockout_time" value="{{ $config['throttle_lockout_time'] }}" class="form-control">
        <p class="help-block">The number of seconds to delay further comment post attempts.</p>
    </div>

    <div class="form-group">
        <button type="submit" v-loading="{state: loading, text: 'Saving...'}" class="btn btn-primary">Save changes</button>
    </div>
</form>
