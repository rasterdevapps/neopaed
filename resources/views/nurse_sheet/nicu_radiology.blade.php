@extends('app')
@section('content')
<style type="text/css">
.packs-window{
	width: 100%;
    height: 100%;
    position: absolute;
}
</style>
<iframe class="packs-window" scrolling="yes" src="http://172.16.9.9:8080/ripacs1/viewer.html?patientID={{$baby_mrno}}&preview=true" frameborder="0" allowfullscreen>
</iframe>
@endsection