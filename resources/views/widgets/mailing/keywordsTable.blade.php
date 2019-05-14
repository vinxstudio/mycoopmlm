<table class="table table-bordered table-hover table-striped">
    @foreach ($keywords as $keyword=>$description)
        <tr>
            <td><b>{{ sprintf('%s%s%s', MAILING_PREFIX, $keyword, MAILING_SUFFIX) }}</b></td>
            <td>{{ $description }}</td>
        </tr>
    @endforeach
</table>