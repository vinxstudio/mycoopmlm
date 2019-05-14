@extends($template)
@section('content')
    @if (count($data) > 0)
    <?php $index = 1; ?>
    @foreach ($data as $user_id => $income)
        @if (isset($users[$user_id]->details->id))
            @if ($index <= 1)
                <div class="col-md-12 col-xs-12 row">
                    <center>
            @endif
                <div class="col-md-3 col-sm-6 col-xs-6" style="{{ ($index <= 1) ? 'float:none' : null }}">
                    <div class="blog-item rounded shadow">
                        <a href="#" class="blog-img"><img data-no-retina="" src="{{ url($users[$user_id]->details->thePhoto) }}" class="img-responsive" alt="..."></a>
                        <div class="blog-details">
                            <div class="ribbon-wrapper">
                                <div class="ribbon ribbon-danger">Top {{ $index }}</div>
                            </div>
                            <h4 class="blog-title"><a href="#">{{ ucwords($users[$user_id]->details->fullName) }}</a></h4><!-- /.blog-title -->
                            <div class="blog-summary">
                                <p>
                                    <h4>Earned <span class="counter">{{ number_format($data[$user_id], 2) }}</span></h4>
                                </p>
                            </div><!-- /.blog-summary -->
                        </div><!-- /.blog-details -->
                    </div><!-- /.blog-item -->
                </div>
            @if ($index <= 1)
                    </center>
                </div>
            @endif
            <?php $index++; ?>
        @endif
    @endforeach
    @else
        <center>
            <p>{{ Lang::get('messages.no_members') }}</p>
        </center>
    @endif
@stop