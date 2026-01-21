@extends('app')
@section('content')
<style type="text/css">
    iframe {
        width: 100%;
        min-height: 1000px;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current">PACS</li>                                                
    </ul>               
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        @php 
            $pacs_link = \SiteHelpers::pacsViewerLink();
            $pacs_link = str_replace('MRN', $mrn, $pacs_link);
        @endphp
        <!-- <object data="http://172.17.1.38:8080/ripacs1t/viewer.html?patientID=578428&preview=true" width="1000px" height="1000px"></object> -->
        
        <iframe src="http://172.17.1.38:8080/ripacs1t/viewer.html?patientID=578428&preview=true" id="testframe"></iframe>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    var iframeWindow = document.getElementById("testframe");

   iframeWindow.contentWindow.postMessage('hide', 'http://172.17.1.38:8080');

</script>
@endsection
