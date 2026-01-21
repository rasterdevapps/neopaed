<style>
    #media-container .label-control {
        margin-top: 0px;
    }
    #media-container label[for="attachment_type"] {
        margin: 13px 0px;
    }
    #media-container .media-label {
        margin: 0px 5px;
        display: inline-block;
        width: 45px;
        height: 45px;
        text-align: center;
        border: 1px solid #aaa;
        border-radius: 50%;
        vertical-align: middle;
        padding: 9px 10px;
        box-shadow: 0px 0px 3px #444;
    }
    #media-container .media-label[attr-option="1"] {
        display: inline-block;
        background-color: #434468;
        color: #fff;
    }
    #media-container .media-label[attr-option="1"] > i.fa {
        color: #fff !important;
    }
</style>
<div class="row" id="media-container">
    <div class="col-md-12">
        {!! csrf_field() !!}
        <input type="hidden" name="file_list">
        <input type="hidden" name="file_name">
        <input type="hidden" name="file_size">

        <div class="form-group text-center">
                {!! Form::label('attachment_type', 'Type:') !!}
                <label for="All" title="All" class="media-label"><i class="fa fa-folder-o fa-2x"></i></label>
                <label for="Image" title="Image" class="media-label"><i class="fa fa-file-image-o fa-2x"></i></label>
                <label for="Document" title="Document" class="media-label"><i class="fa fa-file-text-o fa-2x text-primary"></i></label>
                <label for="pdf" title="PDF" class="media-label"><i class="fa fa-file-pdf-o fa-2x text-danger"></i></label>
                <label for="Excel" title="Excel" class="media-label"><i class="fa fa-file-excel-o fa-2x text-success"></i></label>
                <label for="Video" title="Video" class="media-label"><i class="fa fa-file-video-o fa-2x text-warning"></i></label>
                <label for="Audio" title="Audio" class="media-label"><i class="fa fa-file-audio-o fa-2x text-warning"></i></label>
        </div>
        <div class="form-group">
            <div id="empty-loading"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
            <div id="upload-loading">
                <input type="hidden" name="visit_id" value="{{ @$id }}">
                <div class="file-loading">
                    <input id="file-1" type="file" name="file" multiple class="file">
                </div>
            </div>
        </div>
    </div>
</div>