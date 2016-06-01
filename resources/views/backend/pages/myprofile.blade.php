@extends('backend.master')

@section('breadcrumbs')
<div class="breadcrumbs">
    <h1>Dashboard principal</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <!--
        <li>
            <a href="#">Features</a>
        </li>
        <li class="active">UI Features</li> -->
    </ol>
    <!-- Sidebar Toggle Button -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".page-sidebar">
        <span class="sr-only">Toggle navigation</span>
        <span class="toggle-icon">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </span>
    </button>
    <!-- Sidebar Toggle Button -->
</div>
@endsection

@section('content')
<div class="row">
                                    <div class="col-md-12">
                                        <!-- BEGIN PROFILE SIDEBAR -->
                                        <div class="profile-sidebar">
                                            <!-- PORTLET MAIN -->
                                            <div class="portlet light profile-sidebar-portlet bordered">
                                                <!-- SIDEBAR USERPIC -->
                                                <div class="profile-userpic">
                                                    <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                                                <!-- END SIDEBAR USERPIC -->
                                                <!-- SIDEBAR USER TITLE -->
                                                <div class="profile-usertitle">
                                                    <div class="profile-usertitle-name"> Marcus Doe </div>
                                                    <div class="profile-usertitle-job"> Developer </div>
                                                </div>
                                                <!-- END SIDEBAR USER TITLE -->
                                                <!-- SIDEBAR BUTTONS -->
                                                <div class="profile-userbuttons">
                                                    <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                                    <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                                </div>
                                                <!-- END SIDEBAR BUTTONS -->
                                                <!-- SIDEBAR MENU -->
                                                <div class="profile-usermenu">
                                                    <ul class="nav">
                                                        <li class="active">
                                                            <a href="page_user_profile_1.html">
                                                                <i class="icon-home"></i> Overview </a>
                                                        </li>
                                                        <li>
                                                            <a href="page_user_profile_1_account.html">
                                                                <i class="icon-settings"></i> Account Settings </a>
                                                        </li>
                                                        <li>
                                                            <a href="page_user_profile_1_help.html">
                                                                <i class="icon-info"></i> Help </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- END MENU -->
                                            </div>
                                            <!-- END PORTLET MAIN -->
                                            <!-- PORTLET MAIN -->
                                            <div class="portlet light bordered">
                                                <!-- STAT -->
                                                <div class="row list-separated profile-stat">
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-title"> 37 </div>
                                                        <div class="uppercase profile-stat-text"> Projects </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-title"> 51 </div>
                                                        <div class="uppercase profile-stat-text"> Tasks </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                                        <div class="uppercase profile-stat-title"> 61 </div>
                                                        <div class="uppercase profile-stat-text"> Uploads </div>
                                                    </div>
                                                </div>
                                                <!-- END STAT -->
                                                <div>
                                                    <h4 class="profile-desc-title">About Marcus Doe</h4>
                                                    <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                                    <div class="margin-top-20 profile-desc-link">
                                                        <i class="fa fa-globe"></i>
                                                        <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                                                    </div>
                                                    <div class="margin-top-20 profile-desc-link">
                                                        <i class="fa fa-twitter"></i>
                                                        <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                                    </div>
                                                    <div class="margin-top-20 profile-desc-link">
                                                        <i class="fa fa-facebook"></i>
                                                        <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END PORTLET MAIN -->
                                        </div>
                                        <!-- END BEGIN PROFILE SIDEBAR -->
                                        <!-- BEGIN PROFILE CONTENT -->
                                        <div class="profile-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- BEGIN PORTLET -->
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title">
                                                            <div class="caption caption-md">
                                                                <i class="icon-bar-chart theme-font hide"></i>
                                                                <span class="caption-subject font-blue-madison bold uppercase">Your Activity</span>
                                                                <span class="caption-helper hide">weekly stats...</span>
                                                            </div>
                                                            <div class="actions">
                                                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                                                        <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                                                        <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                                                        <input type="radio" name="options" class="toggle" id="option2">Month</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row number-stats margin-bottom-30">
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <div class="stat-left">
                                                                        <div class="stat-chart">
                                                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                            <div id="sparkline_bar"></div>
                                                                        </div>
                                                                        <div class="stat-number">
                                                                            <div class="title"> Total </div>
                                                                            <div class="number"> 2460 </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <div class="stat-right">
                                                                        <div class="stat-chart">
                                                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                            <div id="sparkline_bar2"></div>
                                                                        </div>
                                                                        <div class="stat-number">
                                                                            <div class="title"> New </div>
                                                                            <div class="number"> 719 </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="table-scrollable table-scrollable-borderless">
                                                                <table class="table table-hover table-light">
                                                                    <thead>
                                                                        <tr class="uppercase">
                                                                            <th colspan="2"> MEMBER </th>
                                                                            <th> Earnings </th>
                                                                            <th> CASES </th>
                                                                            <th> CLOSED </th>
                                                                            <th> RATE </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tr>
                                                                        <td class="fit">
                                                                            <img class="user-pic" src="../assets/pages/media/users/avatar4.jpg"> </td>
                                                                        <td>
                                                                            <a href="javascript:;" class="primary-link">Brain</a>
                                                                        </td>
                                                                        <td> $345 </td>
                                                                        <td> 45 </td>
                                                                        <td> 124 </td>
                                                                        <td>
                                                                            <span class="bold theme-font">80%</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fit">
                                                                            <img class="user-pic" src="../assets/pages/media/users/avatar5.jpg"> </td>
                                                                        <td>
                                                                            <a href="javascript:;" class="primary-link">Nick</a>
                                                                        </td>
                                                                        <td> $560 </td>
                                                                        <td> 12 </td>
                                                                        <td> 24 </td>
                                                                        <td>
                                                                            <span class="bold theme-font">67%</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fit">
                                                                            <img class="user-pic" src="../assets/pages/media/users/avatar6.jpg"> </td>
                                                                        <td>
                                                                            <a href="javascript:;" class="primary-link">Tim</a>
                                                                        </td>
                                                                        <td> $1,345 </td>
                                                                        <td> 450 </td>
                                                                        <td> 46 </td>
                                                                        <td>
                                                                            <span class="bold theme-font">98%</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fit">
                                                                            <img class="user-pic" src="../assets/pages/media/users/avatar7.jpg"> </td>
                                                                        <td>
                                                                            <a href="javascript:;" class="primary-link">Tom</a>
                                                                        </td>
                                                                        <td> $645 </td>
                                                                        <td> 50 </td>
                                                                        <td> 89 </td>
                                                                        <td>
                                                                            <span class="bold theme-font">58%</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET -->
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- BEGIN PORTLET -->
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title tabbable-line">
                                                            <div class="caption caption-md">
                                                                <i class="icon-globe theme-font hide"></i>
                                                                <span class="caption-subject font-blue-madison bold uppercase">Feeds</span>
                                                            </div>
                                                            <ul class="nav nav-tabs">
                                                                <li class="active">
                                                                    <a href="#tab_1_1" data-toggle="tab"> System </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab_1_2" data-toggle="tab"> Activities </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <!--BEGIN TABS-->
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tab_1_1">
                                                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                                        <ul class="feeds">
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-success">
                                                                                                <i class="fa fa-bell-o"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> You have 4 pending tasks.
                                                                                                <span class="label label-sm label-info"> Take action
                                                                                                    <i class="fa fa-share"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> Just now </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New version v1.4 just lunched! </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> 20 mins </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-danger">
                                                                                                <i class="fa fa-bolt"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Database server #12 overloaded. Please fix the issue. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 24 mins </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New order received and pending for process. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 30 mins </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-success">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New payment refund and pending approval. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 40 mins </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-warning">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New member registered. Pending approval. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 1.5 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-success">
                                                                                                <i class="fa fa-bell-o"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                                                                <span class="label label-sm label-default "> Overdue </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 2 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-default">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Prod01 database server is overloaded 90%. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 3 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-warning">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New group created. Pending manager review. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 5 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Order payment failed. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 18 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-default">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New application received. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 21 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Dev90 web server restarted. Pending overall system check. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 22 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-default">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New member registered. Pending approval </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 21 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> L45 Network failure. Schedule maintenance. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 22 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-default">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Order canceled with failed payment. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 21 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Web-A2 clound instance created. Schedule full scan. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 22 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-default">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Member canceled. Schedule account review. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 21 hours </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-info">
                                                                                                <i class="fa fa-bullhorn"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> New order received. Please take care of it. </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 22 hours </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="tab_1_2">
                                                                    <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                                        <ul class="feeds">
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New order received </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> 10 mins </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <div class="col1">
                                                                                    <div class="cont">
                                                                                        <div class="cont-col1">
                                                                                            <div class="label label-sm label-danger">
                                                                                                <i class="fa fa-bolt"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cont-col2">
                                                                                            <div class="desc"> Order #24DOP4 has been rejected.
                                                                                                <span class="label label-sm label-danger "> Take action
                                                                                                    <i class="fa fa-share"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col2">
                                                                                    <div class="date"> 24 mins </div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;">
                                                                                    <div class="col1">
                                                                                        <div class="cont">
                                                                                            <div class="cont-col1">
                                                                                                <div class="label label-sm label-success">
                                                                                                    <i class="fa fa-bell-o"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="cont-col2">
                                                                                                <div class="desc"> New user registered </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col2">
                                                                                        <div class="date"> Just now </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--END TABS-->
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- BEGIN PORTLET -->
                                                    <div class="portlet light bordered">
                                                        <div class="portlet-title">
                                                            <div class="caption caption-md">
                                                                <i class="icon-bar-chart theme-font hide"></i>
                                                                <span class="caption-subject font-blue-madison bold uppercase">Customer Support</span>
                                                                <span class="caption-helper">45 pending</span>
                                                            </div>
                                                            <div class="inputs">
                                                                <div class="portlet-input input-inline input-small ">
                                                                    <div class="input-icon right">
                                                                        <i class="icon-magnifier"></i>
                                                                        <input type="text" class="form-control form-control-solid" placeholder="search..."> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                                <div class="general-item-list">
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar4.jpg">
                                                                                <a href="" class="item-name primary-link">Nick Larson</a>
                                                                                <span class="item-label">3 hrs ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-success"></span> Open</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar3.jpg">
                                                                                <a href="" class="item-name primary-link">Mark</a>
                                                                                <span class="item-label">5 hrs ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-warning"></span> Pending</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat tincidunt ut laoreet. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar6.jpg">
                                                                                <a href="" class="item-name primary-link">Nick Larson</a>
                                                                                <span class="item-label">8 hrs ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-primary"></span> Closed</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar7.jpg">
                                                                                <a href="" class="item-name primary-link">Nick Larson</a>
                                                                                <span class="item-label">12 hrs ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-danger"></span> Pending</span>
                                                                        </div>
                                                                        <div class="item-body"> Consectetuer adipiscing elit Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar9.jpg">
                                                                                <a href="" class="item-name primary-link">Richard Stone</a>
                                                                                <span class="item-label">2 days ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-danger"></span> Open</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, ut laoreet dolore magna aliquam erat volutpat. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar8.jpg">
                                                                                <a href="" class="item-name primary-link">Dan</a>
                                                                                <span class="item-label">3 days ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-warning"></span> Pending</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic" src="../assets/pages/media/users/avatar2.jpg">
                                                                                <a href="" class="item-name primary-link">Larry</a>
                                                                                <span class="item-label">4 hrs ago</span>
                                                                            </div>
                                                                            <span class="item-status">
                                                                                <span class="badge badge-empty badge-success"></span> Open</span>
                                                                        </div>
                                                                        <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET -->
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- BEGIN PORTLET -->
                                                    <div class="portlet light bordered tasks-widget">
                                                        <div class="portlet-title">
                                                            <div class="caption caption-md">
                                                                <i class="icon-bar-chart theme-font hide"></i>
                                                                <span class="caption-subject font-blue-madison bold uppercase">Tasks</span>
                                                                <span class="caption-helper">16 pending</span>
                                                            </div>
                                                            <div class="inputs">
                                                                <div class="portlet-input input-small input-inline">
                                                                    <div class="input-icon right">
                                                                        <i class="icon-magnifier"></i>
                                                                        <input type="text" class="form-control form-control-solid" placeholder="search..."> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="task-content">
                                                                <div class="scroller" style="height: 282px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                                    <!-- START TASK LIST -->
                                                                    <ul class="task-list">
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="hidden" value="1" name="test" />
                                                                                <input type="checkbox" class="liChild" value="2" name="test" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Present 2013 Year IPO Statistics at Board Meeting </span>
                                                                                <span class="label label-sm label-success">Company</span>
                                                                                <span class="task-bell">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Hold An Interview for Marketing Manager Position </span>
                                                                                <span class="label label-sm label-danger">Marketing</span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> AirAsia Intranet System Project Internal Meeting </span>
                                                                                <span class="label label-sm label-success">AirAsia</span>
                                                                                <span class="task-bell">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Technical Management Meeting </span>
                                                                                <span class="label label-sm label-warning">Company</span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Kick-off Company CRM Mobile App Development </span>
                                                                                <span class="label label-sm label-info">Internal Products</span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Prepare Commercial Offer For SmartVision Website Rewamp </span>
                                                                                <span class="label label-sm label-danger">SmartVision</span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Sign-Off The Comercial Agreement With AutoSmart </span>
                                                                                <span class="label label-sm label-default">AutoSmart</span>
                                                                                <span class="task-bell">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> Company Staff Meeting </span>
                                                                                <span class="label label-sm label-success">Cruise</span>
                                                                                <span class="task-bell">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="last-line">
                                                                            <div class="task-checkbox">
                                                                                <input type="checkbox" class="liChild" value="" /> </div>
                                                                            <div class="task-title">
                                                                                <span class="task-title-sp"> KeenThemes Investment Discussion </span>
                                                                                <span class="label label-sm label-warning">KeenThemes </span>
                                                                            </div>
                                                                            <div class="task-config">
                                                                                <div class="task-config-btn btn-group">
                                                                                    <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                                        <i class="fa fa-cog"></i>
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-check"></i> Complete </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-pencil"></i> Edit </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">
                                                                                                <i class="fa fa-trash-o"></i> Cancel </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <!-- END START TASK LIST -->
                                                                </div>
                                                            </div>
                                                            <div class="task-footer">
                                                                <div class="btn-arrow-link pull-right">
                                                                    <a href="javascript:;">See All Tasks</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="portlet light portlet-fit bordered">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="icon-microphone font-green"></i>
                                                                <span class="caption-subject bold font-green uppercase"> Timeline</span>
                                                                <span class="caption-helper">user timeline</span>
                                                            </div>
                                                            <div class="actions">
                                                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                                    <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                                        <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                                                    <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                                        <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="timeline">
                                                                <!-- TIMELINE ITEM -->
                                                                <div class="timeline-item">
                                                                    <div class="timeline-badge">
                                                                        <img class="timeline-badge-userpic" src="../assets/pages/media/users/avatar80_2.jpg"> </div>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline-body-arrow"> </div>
                                                                        <div class="timeline-body-head">
                                                                            <div class="timeline-body-head-caption">
                                                                                <a href="javascript:;" class="timeline-body-title font-blue-madison">Lisa Strong</a>
                                                                                <span class="timeline-body-time font-grey-cascade">Replied at 17:45 PM</span>
                                                                            </div>
                                                                            <div class="timeline-body-head-actions">
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-circle green btn-outline btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                                        <li>
                                                                                            <a href="javascript:;">Action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Another action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Something else here </a>
                                                                                        </li>
                                                                                        <li class="divider"> </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Separated link </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-body-content">
                                                                            <span class="font-grey-cascade"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut consectetuer adipiscing elit laoreet dolore magna aliquam erat volutpat. Ut
                                                                                wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END TIMELINE ITEM -->
                                                                <!-- TIMELINE ITEM WITH GOOGLE MAP -->
                                                                <div class="timeline-item">
                                                                    <div class="timeline-badge">
                                                                        <img class="timeline-badge-userpic" src="../assets/pages/media/users/avatar80_7.jpg"> </div>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline-body-arrow"> </div>
                                                                        <div class="timeline-body-head">
                                                                            <div class="timeline-body-head-caption">
                                                                                <a href="javascript:;" class="timeline-body-title font-blue-madison">Paul Kiton</a>
                                                                                <span class="timeline-body-time font-grey-cascade">Added office location at 2:50 PM</span>
                                                                            </div>
                                                                            <div class="timeline-body-head-actions">
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-circle red btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                                        <li>
                                                                                            <a href="javascript:;">Action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Another action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Something else here </a>
                                                                                        </li>
                                                                                        <li class="divider"> </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Separated link </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-body-content">
                                                                            <div id="gmap_polygons" class="gmaps"> </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END TIMELINE ITEM WITH GOOGLE MAP -->
                                                                <!-- TIMELINE ITEM -->
                                                                <div class="timeline-item">
                                                                    <div class="timeline-badge">
                                                                        <div class="timeline-icon">
                                                                            <i class="icon-user-following font-green-haze"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline-body-arrow"> </div>
                                                                        <div class="timeline-body-head">
                                                                            <div class="timeline-body-head-caption">
                                                                                <span class="timeline-body-alerttitle font-red-intense">You have new follower</span>
                                                                                <span class="timeline-body-time font-grey-cascade">at 11:00 PM</span>
                                                                            </div>
                                                                            <div class="timeline-body-head-actions">
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-circle green btn-outline

                                        btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                                        <li>
                                                                                            <a href="javascript:;">Action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Another action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Something else here </a>
                                                                                        </li>
                                                                                        <li class="divider"> </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Separated link </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-body-content">
                                                                            <span class="font-grey-cascade"> You have new follower
                                                                                <a href="javascript:;">Ivan Rakitic</a>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END TIMELINE ITEM -->
                                                                <!-- TIMELINE ITEM -->
                                                                <div class="timeline-item">
                                                                    <div class="timeline-badge">
                                                                        <div class="timeline-icon">
                                                                            <i class="icon-docs font-red-intense"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline-body-arrow"> </div>
                                                                        <div class="timeline-body-head">
                                                                            <div class="timeline-body-head-caption">
                                                                                <span class="timeline-body-alerttitle font-green-haze">Server Report</span>
                                                                                <span class="timeline-body-time font-grey-cascade">Yesterday at 11:00 PM</span>
                                                                            </div>
                                                                            <div class="timeline-body-head-actions">
                                                                                <div class="btn-group dropup">
                                                                                    <button class="btn btn-circle red btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                                                        <i class="fa fa-angle-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                                        <li>
                                                                                            <a href="javascript:;">Action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Another action </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Something else here </a>
                                                                                        </li>
                                                                                        <li class="divider"> </li>
                                                                                        <li>
                                                                                            <a href="javascript:;">Separated link </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-body-content">
                                                                            <span class="font-grey-cascade"> Lorem ipsum dolore sit amet
                                                                                <a href="javascript:;">Ispect</a>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END TIMELINE ITEM -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END PROFILE CONTENT -->
                                    </div>
                                </div>
                                <!-- END PAGE BASE CONTENT -->
                            </div>

@endsection