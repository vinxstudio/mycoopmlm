<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    .mce-notification-inner, .mce-close, .mce-notification-warning, .mce-branding{
      display: none !important;
    }
</style>
<table class="table table-bordered table-hover table-striped">
    <col width="12%;">
    <col width="20%;">
    <col width="6%;">
    <col width="10%;">
    <col width="5%;">
    <col width="10%;">
    <col width="10%;">
    <col width="5%;">
    <thead>
        <th>{{ Lang::get('announcement.title') }}</th>
        <th>{{ Lang::get('announcement.details') }}</th>
        <th>{{ Lang::get('announcement.date_display') }}</th>
        <th>{{ Lang::get('announcement.from') }}</th>
        <th>{{ Lang::get('announcement.status') }}</th>
        <th>{{ Lang::get('announcement.created_date') }}</th>
        <th>{{ Lang::get('announcement.updated_date') }}</th>
        <th>{{ Lang::get('announcement.action') }}</th>
    </thead>

        <tbody>
            @if(!$announcement)
                <tr>
                    <td colspan="8" style="text-align: center">{{ Lang::get('announcement.no_announcement')}}</td>
                </tr>
            @else
                @foreach($announcement as $announce)
                    <tr>
                        <td>{{ $announce->announcement_title }}</td>
                        <td>{{ $announce->announcement_details }}</td>
                        <td>{{ $announce->display_date }}</td>
                        <td>{{ $announce->announcement_from }}</td>
                        <td>
                            <label class="switch">
                              <input data="{{ $announce->id }}" class="a_status" type="checkbox" {{ $announce->status == 1 ? "checked" : "" }}>
                              <span class="slider round"></span>
                            </label>
                        </td>
                        <td>{{ $announce->created_at }}</td>
                        <td>{{ $announce->updated_at }}</td>
                        <td>
                            <a data="{{ $announce->id }}" class="btn btn-warning btn-xs a_edit" data-toggle="modal" data-target="#announcement_edit" href="javascript:void(0);">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a data="{{ $announce->id }}" class="btn btn-danger btn-xs a_delete" data-toggle="modal" data-target="#announcement_warning" href="javascript:void(0);">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
</table>