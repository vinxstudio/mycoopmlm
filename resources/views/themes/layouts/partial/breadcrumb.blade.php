<div id="tour-11" class="header-content">
    <h2><i class="fa fa-home"></i>{{ $pagename or ToLabel(Request::segment(2)) }}</h2>
    <div class="breadcrumb-wrapper hidden-xs">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li class="active">{{ $pagename or ToLabel(Request::segment(2)) }}</li>
        </ol>
    </div>
</div>