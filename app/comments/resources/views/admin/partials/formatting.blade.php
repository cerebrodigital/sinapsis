<form v-on:submit="save">
    <input type="hidden" name="group" value="formatting">

    <alert :success="success"></alert>

    <div class="form-group">
        <label for="emoticons">Emoticons</label>
        <select name="emoticons" id="emoticons" class="form-control">
            <option value="1" {{ $config['emoticons'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['emoticons'] ? 'selected':'' }}>No</option>
        </select>
        <p class="help-block">Specify if you want to enable emoticons.</p>
    </div>

    <div class="form-group">
        <label for="bbcodes">BBCodes</label>
        <select name="bbcodes" id="bbcodes" class="form-control">
            <option value="1" {{ $config['bbcodes'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['bbcodes'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">
            Specify if comments should be parsed as <a href="https://en.wikipedia.org/wiki/BBCode" target="_blank">BBCode</a> tags.
        </p>
    </div>

    <div class="form-group">
        <label for="markdown">Markdown</label>
        <select name="markdown" id="markdown" class="form-control">
            <option value="1" {{ $config['markdown'] ? 'selected'  : '' }}>Yes</option>
            <option value="0" {{ !$config['markdown'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if comments should be parsed as Markdown (Litedown).</p>
    </div>

    <div class="form-group">
        <label for="auto_link">Auto Link</label>
        <select name="auto_link" id="auto_link" class="form-control">
            <option value="1" {{ $config['auto_link'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['auto_link'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if plain-text URLs should be converted into clickable links.</p>
    </div>

    <div class="form-group">
        <label for="auto_email">Auto Email</label>
        <select name="auto_email" id="auto_email" class="form-control">
            <option value="1" {{ $config['auto_email'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['auto_email'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if plain-text emails should be converted into clickable links.</p>
    </div>

    <div class="form-group">
        <label for="auto_image">Auto Image</label>
        <select name="auto_image" id="auto_image" class="form-control">
            <option value="1" {{ $config['auto_image'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['auto_image'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if plain-text image URLs should be converted into actual images.</p>
    </div>

    <div class="form-group">
        <label for="media_embed">Media Embed</label>
        <select name="media_embed" id="media_embed" class="form-control">
            <option value="1" {{ $config['media_embed'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['media_embed'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">
            Specify if content from <a href="http://s9etextformatter.readthedocs.org/Plugins/MediaEmbed/Sites/" target="_blank">media sites</a> should be embedded.
        </p>
    </div>

    <div class="form-group">
        <button type="submit" v-loading="{state: loading, text: 'Saving...'}" class="btn btn-primary">Save changes</button>
    </div>
</form>
