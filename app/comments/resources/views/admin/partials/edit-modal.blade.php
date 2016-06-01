<script type="text/x-template" id="edit-modal-template">
    <div class="modal fade" id="edit-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form v-on:submit="save">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        <h4 class="modal-title">Edit comment</h4>
                    </div>

                    <div class="modal-body">
                        <alert :success="success"></alert>

                        <div class="form-group">
                            <label for="author_name">Author Name</label>
                            <input type="text" v-model="authorName" :readonly"user" v-disable="loading" id="author_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="author_email">Author Email</label>
                            <input type="text" v-model="authorEmail" :readonly"user" v-disable="loading" id="author_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="author_url">Author Url</label>
                            <input type="text" v-model="authorUrl" :readonly"user" v-disable="loading" id="author_url" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select v-model="status" v-disable="loading" id="status" class="form-control">
                                <template v-for="stat in statuses">
                                    <option v-if="stat !== 'all'" :value="stat">@{{ stat | capitalize }}</option>
                                </template>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="content">Comment</label>
                            <textarea v-model="content" v-disable="loading" id="content" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" v-loading="{state: loading, text: 'Saving...'}">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>
