@extends('layouts.loginLayout')
@section('content')
<style>
.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

.gallery:hover {
    border: 1px solid #777;
}

.gallery img {
    width: 100%;
    height: 120px;
}
</style>

@for($i = 1; $i < 50; $i++)
	<div class="gallery">
		<a class="grid-item" href="{{ url('public/img/Awarding_Presentations/CebuCoopAwarding_Presentations-'.$i.'.jpg') }}" target="_blank">
			<img src="{{ url('public/img/Awarding_Presentations/CebuCoopAwarding_Presentations-'.$i.'.jpg') }}" alt="">
		</a>
	</div>
@endfor
@stop