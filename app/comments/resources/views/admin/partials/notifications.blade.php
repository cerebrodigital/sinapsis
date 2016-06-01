<form v-on:submit="save">
    <input type="hidden" name="group" value="notifications">

    <alert :success="success"></alert>

    <div class="form-group">
        <label for="admin_email">Admin Email</label>
        <input type="text" name="admin_email" id="admin_email" value="{{ $config['admin_email'] }}" class="form-control">
        <p class="help-block">
            An email address to which notifications will be sent when a new comment is posted. Spam won't be reported.
        </p>
    </div>

    <div class="form-group">
        <label for="reply_email">Reply Email</label>
        <select name="reply_email" id="reply_email" class="form-control">
            <option value="1" {{ $config['reply_email'] ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$config['reply_email'] ? 'selected' : '' }}>No</option>
        </select>
        <p class="help-block">Specify if users should be notified when their comments receive replies.</p>
    </div>

    <div class="form-group">
        <button type="submit" v-loading="{state: loading, text: 'Saving...'}" class="btn btn-primary">Save changes</button>
    </div>
</form>
