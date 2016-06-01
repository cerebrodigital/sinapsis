<form v-on:submit="save">
    <input type="hidden" name="group" value="general">

    <alert :success="success"></alert>

    <div class="form-group">
        <label for="guest">Guest Users</label>
        <select name="guest" v-disable="loading" id="guest" class="form-control">
            <option value="1" {{ $config['guest'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['guest'] ? 'selected': '' }}>No</option>
        </select>
        <p class="help-block">Specify if guest users can leave comments.</p>
    </div>

    <div class="form-group">
        <label for="votes">Votes</label>
        <select name="votes" v-disable="loading" id="votes" class="form-control">
            <option value="1" {{ $config['votes'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['votes'] ? 'selected':'' }}>No</option>
        </select>
        <p class="help-block">Specify if authenticated users can vote.</p>
    </div>

    <div class="form-group">
        <label for="replies">Replies</label>
        <select name="replies" id="replies" class="form-control">
            <option value="1" {{ $config['replies'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['replies'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if comment replies are allowed.</p>
    </div>

    <div class="form-group">
        <label for="real_time">Real Time</label>
        <select name="real_time" id="real_time" class="form-control">
            <option value="1" {{ $config['real_time'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['real_time'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">
            Specify for which users captcha is enabled. Make sure have
            <a href="http://docs.hazzardweb.com/ajax-comment-system-laravel/master/configuration#real-time">configured</a> a broadcast driver.
        </p>
    </div>

    <div class="form-group">
        <label for="edit">Editing</label>
        <select name="edit" id="edit" class="form-control">
            <option value="true" {{ $config['edit'] === true ? 'selected' : '' }}>Always</option>
            <option value="false" {{ $config['edit'] === false ? 'selected' : '' }}>No</option>

            <option value="60"  {{ $config['edit'] === 60  ? 'selected' : '' }}>1 minute after posting</option>
            <option value="120" {{ $config['edit'] === 120 ? 'selected' : '' }}>2 minutes after posting</option>
            <option value="240" {{ $config['edit'] === 240 ? 'selected' : '' }}>4 minutes after posting</option>
            <option value="480" {{ $config['edit'] === 480 ? 'selected' : '' }}>8 minutes after posting</option>
        </select>
        <p class="help-block">Specify if authenticated users can edit their comments.</p>
    </div>

    <div class="form-group">
        <label for="max_length">Maximum Length</label>
        <input type="text" name="max_length" id="max_length" value="{{ $config['max_length'] }}" class="form-control">
        <p class="help-block">The maximum comment length. To disable leave it empty.</p>
    </div>

    <div class="form-group">
        <label for="per_page">Per Page</label>
        <input type="text" name="per_page" id="per_page" value="{{ $config['per_page'] }}" class="form-control">
        <p class="help-block">Specify the number of comments to bde displayed per page. To disable leave it empty.</p>
    </div>

    <div class="form-group">
        <label for="default_sort">Default Sort</label>
        <select name="default_sort" id="default_sort" class="form-control">
            @foreach (['1' => 'Newest first', '2' => 'Oldest first', '3' => 'Best first'] as $val => $text)
                <option value="{{ $val }}" {{ $config['default_sort'] === $val ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>
        <p class="help-block">Specify the default sorting.</p>
    </div>

    <div class="form-group">
        <label for="default_gravatar">Default Avatar Imageset</label>
        <select name="default_gravatar" v-disable="loading" id="default_gravatar" class="form-control">
            @foreach (['mm', 'identicon', 'monsterid', 'wavatar'] as $set)
                <option value="{{ $set }}" {{ $config['default_gravatar'] === $set ? 'selected' : '' }}>
                    {{ $set }}
                </option>
            @endforeach
        </select>
        <p class="help-block">
            Specify the default <a href="http://en.gravatar.com/site/implement/images/#default-image">Gravatar</a> imageset.
        </p>
    </div>

    <div class="form-group">
        <button type="submit" v-loading="{state: loading, text: 'Saving...'}" class="btn btn-primary">Save changes</button>
    </div>
</form>
