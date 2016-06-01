<form v-on:submit="save">
    <input type="hidden" name="group" value="moderation">

    <alert :success="success"></alert>

    <div class="form-group">
        <label for="moderation">Moderation</label>
        <select name="moderation" id="moderation" class="form-control">
            <option value="1" {{ $config['moderation'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['moderation'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if all comments should be approved.</p>
    </div>

    <div class="form-group">
        <label for="akismet">Akismet Spam Detection</label>
        <select name="akismet" id="akismet" class="form-control">
            <option value="1" {{ $config['akismet'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['akismet'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">
            Make sure to set the <code>akismet_key</code> in <em>config/services.php</em>. <br>
            Visit <a href="https://akismet.com/account/" target="_blank">akismet.com</a> to get your key.
        </p>
    </div>

    <div class="form-group">
        <label for="moderation_keys">Moderation Keys</label>
        <textarea name="moderation_keys" id="moderation_keys" class="form-control" rows="4"><?php echo implode('\n', $config['moderation_keys']); ?></textarea>
        <p class="help-block">
            When a comment contains any of these words in its content, name, URL, e-mail, or IP,
            it will be held in the moderation queue. One word or IP per line.
        </p>
    </div>

    <div class="form-group">
        <label for="blacklist_keys">Blacklist Keys</label>
        <textarea name="blacklist_keys" id="blacklist_keys" class="form-control" rows="4"><?php echo implode('\n', $config['blacklist_keys']); ?></textarea>
        <p class="help-block">
            When a comment contains any of these words in its content, name, URL, e-mail, or IP,
            it will be marked as spam. One word or IP per line.
        </p>
    </div>

    <div class="form-group">
        <label for="duplicate">Duplicate Detection</label>
        <select name="duplicate" id="duplicate" class="form-control">
            <option value="1" {{ $config['duplicate'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['duplicate'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">If enabled, duplicate comments on the same page and user are not allowed.</p>
    </div>

    <div class="form-group">
        <label for="max_pending">Maximum Pending</label>
        <input type="text" name="max_pending" id="max_pending" value="{{ $config['max_pending'] }}" class="form-control">
        <p class="help-block">Block comments form users that have to many unapproved comments. To disable leave it empty.</p>
    </div>

    <div class="form-group">
        <label for="max_links">Maximum Links</label>
        <input type="text" name="max_links" id="max_links" value="{{ $config['max_links'] }}" class="form-control">
        <p class="help-block">
            Here you may specify if comments that contains too many links should
            be hold in the moderation queue. To disable leave it empty.
        </p>
    </div>

    <div class="form-group">
        <label for="censor">Censor Words</label>
        <select name="censor" id="censor" class="form-control">
            <option value="1" {{ $config['censor'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['censor'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if words should be censored.</p>
    </div>

    <div class="form-group">
        <label for="censored_words">Censored Words</label>
        <textarea name="censored_words" id="censored_words" class="form-control" rows="4"><?php echo implode(' ', $config['censored_words']); ?></textarea>
        <p class="help-block">Specify what words should be censored (sepearted by a space).</p>
    </div>

    <div class="form-group">
        <button type="submit" v-loading="{state: loading, text: 'Saving...'}" class="btn btn-primary">Save changes</button>
    </div>
</form>
