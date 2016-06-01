<script type="text/x-template" id="alert-template">
    <div v-show="errors || success">
        <div class="clearfix"></div>
        <div class="alert" :class="{'alert-success': success, 'alert-danger': !success}">
            <span class="close" v-on:click="close">&times;</span>
            <ul v-if="!text">
                <li v-for="error in errors">@{{ error }}</li>
            </ul>
            <template v-if="text">@{{ errors }}</template>
            <template v-if="success">@{{ success }}</template>
        </div>
    </div>
</script>
