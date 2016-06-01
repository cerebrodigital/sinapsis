<script type="text/x-template" id="comment-template">
    <li class="comment" :id="'comment-' + comment.id" :class="{collapsed: collapsed}" transition="fade">
        <div class="comment-content clearfix" :class="{target: target === comment.id}">
            <div class="indicator"></div>

            <div v-if="comment.author.avatar" class="avatar">
                <a :href="comment.author.url">
                    <img :src="comment.author.avatar" :alt="comment.author.name">
                </a>
            </div>

            <div class="comment-body">
                <header>
                    <span v-if="!comment.author.url" class="author">@{{ comment.author.name }}</span>
                    <a v-if="comment.author.url" href="@{{ comment.author.url }}" target="_blank" class="author">@{{ comment.author.name }}</a>

                    <a v-if="parent"
                        v-on:click="target = parent.id"
                        :href="'#!comment=' + parent.id"
                        :title="'in reply to ' + parent.author.name">
                        <span class="glyphicon glyphicon-share-alt"></span>
                        @{{ parent.author.name }}
                    </a>

                    <a :href="'#!comment=' + comment.id" class="time-ago" v-on:click="target = comment.id">
                        <time :datetime="comment.created_at" :title="comment.created_at"></time>
                    </a>

                    <!-- Dropdown -->
                    <div class="pull-right dropdown">
                        <span class="collapse" title="@lang('comments::all.collapse')" v-on:click="collapsed = true">−</span>
                        <span class="expand" title="@lang('comments::all.expand')" v-on:click="collapsed = false">+</span>

                        <div v-if="editable" class="edit-menu">
                            <span class="sep"></span>
                            <div class="dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </div>
                            <ul class="dropdown-menu">
                                <template v-if="moderate">
                                    <li><a :href="comment.edit_link">@lang('comments::all.edit')</a></li>
                                    <li><a href="#" v-on:click="edit">@lang('comments::all.qedit')</a></li>
                                </template>
                                <li v-if="!moderate">
                                    <a href="#" class="quick-edit" v-on:click="edit">@lang('comments::all.edit')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>

                <div class="comment-body-inner" v-show="!showEdit">
                    <div v-if="comment.status !== 'approved'" class="hold">@lang('comments::all.hold')</div>
                    <div class="comment-message">@{{{ comment.contentHTML | emoji }}}</div>
                </div>

                <!-- Votes -->
                <footer v-if="!showEdit">
                    <div class="comment-voting" v-if="votes()">
                        <span class="upvotes">@{{ comment.upvotes || '' }}</span>
                        <a href="#" title="@lang('comments::all.upvote')" class="upvote" :class="{voted: upvoted}" v-on:click="upvote">
                            <span class="glyphicon glyphicon-chevron-up"></span></a>
                        <span class="sep"></span>
                        <span class="downvotes">@{{ comment.downvotes || '' }}</span>
                        <a href="#" title="@lang('comments::all.downvote')" class="downvote" :class="{voted: downvoted}" v-on:click="downvote">
                            <span class="glyphicon glyphicon-chevron-down"></span></a>
                    </div>

                    <a v-if="replies()" v-on:click="reply" href="#" class="reply">@lang('comments::all.reply')</a>
                </footer>

                <!-- Edit form -->
                <form class="clearfix" v-if="showEdit" v-on:submit="save">
                    <div class="form-group">
                        <textarea
                            v-model="content"
                            wrap="hard"
                            v-disable="loading"
                            class="form-control"
                            :maxlength="maxLength"
                            placeholder="@lang('comments::all.comment')"
                        >@{{{ comment.content }}}</textarea>
                    </div>

                    <div class="pull-left">
                        <button type="submit" class="btn btn-success btn-sm" v-loading="{state: loading, text: '@lang('comments::all.saving')'}">
                            @lang('comments::all.save')
                        </button>

                        <button type="button" class="btn btn-default btn-sm" v-on:click="showEdit = false">
                            @lang('comments::all.cancel')
                        </button>
                    </div>

                    <div class="pull-right" v-if="maxLength">
                        <span class="char-count">@{{ maxLength - content.length }}</span>
                    </div>

                    <alert :errors="errors"></alert>
                </form>
            </div>

            <post-form v-if="showReply"
                :focus="true"
                :show.sync="showReply"
                :parent="comment"
                :total.sync="total">
            </post-form>
        </div>

        <ul class="comment-list children">
            <comment v-for="comm in comment.replies" v-show="comment.replies"
                :comment.sync="comm"
                :total.sync="total"
                :parent.sync="comment"
                :target.sync="target">
            </comment>
        </ul>
    </li>
</script>
