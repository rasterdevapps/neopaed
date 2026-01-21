@if ($type == 'Image')
    <i class="fa fa-file-image-o p-5 preview-block" data-type="{{$type}}" title="Image" id="image-block"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@elseif ($type == 'Document')
    <i class="fa fa-file-text-o text-primary p-5 preview-block" data-type="{{$type}}" title="Document" id="document-block"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@elseif ($type == 'pdf')
    <i class="fa fa-file-pdf-o text-danger p-5 preview-block" data-type="{{$type}}" title="PDF" id="pdf-block"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@elseif ($type == 'Excel')
    <i class="fa fa-file-excel-o text-success p-5 preview-block" data-type="{{$type}}" title="Excel" id="excel-block"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@elseif ($type == 'Video')
    <i class="fa fa-file-video-o text-warning p-5 preview-block" data-type="{{$type}}" title="Video"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@elseif ($type == 'Audio')
    <i class="fa fa-file-audio-o text-warning p-5 preview-block" data-type="{{$type}}" title="Audio"></i>
    <!-- <span class="badge label-danger">{{ $count }}</span> -->
@endif