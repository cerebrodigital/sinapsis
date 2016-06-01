<script type="text/x-template" id="comments-template">
    <div v-if="initialized" transition="expand">
        <div class="comment-sort pull-right dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                @{{ sortText }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li v-for="(key, val) in sortOptions" :class="{active: sort == key}">
                    <a href="#" v-on:click="sortBy(key, $event)">@{{ val }}</a>
                </li>
            </ul>
        </div>

        <h3 class="total">
            @{{ total }} @{{ total > 1 ? 'comments' : (total === 1 ? 'comment' : 'no comments') }}
        </h3>
    </div>

    <div v-if="!initialized" class="spinner">@lang('comments::all.loading')</div>

    <div v-if="initialized">
        <div class="alert alert-warning" v-if="!authorized()">@lang('comments::all.auth')</div>

        <!-- Post form -->
        <post-form :comment-list.sync="commentList" :total.sync="total"></post-form>

        <div class="clearfix"></div>
        <div v-show="loading" class="spinner">@lang('comments::all.loading')</div>

        <!-- Coment list -->
        <ul class="comment-list" v-if="!loading" transition="fade">
            <comment v-for="comment in commentList"
                :comment.sync="comment"
                :total.sync="total"
                :target.sync="target">
            </comment>
        </ul>

        <!-- Pagination -->
        <div class="text-center" v-if="!loading && pagination.total > pagination.per_page">
            <ul class="pagination pagination-sm">
                <li :class="{disabled: pagination.current_page == 1}">
                    <a :href="'#!page=' + pagination.prev_page" v-on:click="changePage(pagination.prev_page, $event)">&laquo;</a>
                </li>

                <li v-if="pagination.first_adjacent_page > 1">
                    <a href="#!page=1" v-on:click="changePage(1, $event)">1</a>
                </li>

                <li v-if="pagination.first_adjacent_page > 2" class="disabled"><a>...</a></li>

                <template v-for="index in pagination.last_adjacent_page">
                    <li v-if="index + 1 >= pagination.first_adjacent_page" :class="{active: pagination.current_page == index + 1}">
                        <a :href="'#!page=' + (index + 1)" v-on:click="changePage(index + 1, $event)">@{{ index + 1 }}</a>
                    </li>
                </template>

                <li v-if="pagination.last_adjacent_page < pagination.last_page - 1" class="disabled"><a>...</a></li>

                <li v-if="pagination.last_adjacent_page < pagination.last_page">
                    <a :href="'#!page=' + pagination.last_page" v-on:click="changePage(pagination.last_page, $event)">@{{ pagination.last_page }}</a>
                </li>

                <li :class="{disabled: pagination.current_page === pagination.last_page}">
                    <a :href="'#!page=' + pagination.next_page" v-on:click="changePage(pagination.next_page, $event)">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
</script>
