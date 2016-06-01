<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Site Visits</span>
            <span class="caption-helper">weekly stats...</span>
        </div>
        <div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <label class="btn red btn-outline btn-circle btn-sm active">
                    <input type="radio" name="options" class="toggle" id="option1">New</label>
                <label class="btn red btn-outline btn-circle btn-sm">
                    <input type="radio" name="options" class="toggle" id="option2">Returning</label>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div id="site_statistics_loading">
            <img src="/backend/global/img/loading.gif" alt="loading" /> </div>
        <div id="site_statistics_content" class="display-none">
            <div id="site_statistics" class="chart"> </div>
        </div>
    </div>
</div>