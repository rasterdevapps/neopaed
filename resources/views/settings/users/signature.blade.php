<style type="text/css">
    .signature-pad canvas, .signature-pad img {
        border: 1px solid black;
    }
    .signature-pad {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .signature-pad--footer {
        display: flex;
    }
    .signature-pad--actions {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    #short-signature-pad .signature-pad--actions {
        flex-direction: row;
        align-items: center;
    }
</style>
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::label('full_signature','Signature:') !!}
    </div>
    <div class="col-md-12">
        {!! Form::hidden('full_signature', null) !!}
        <div id="full-signature-pad" class="signature-pad">
            <div class="signature-pad--body">
                <img src="{{ url('/') }}/public/img/users/{{$signature}}" class="full-img-block {{!empty($signature) ? '' : 'hide'}}" width="300px" height="150px">
                <canvas class="full-canvas-block {{!empty($signature) ? 'hide' : ''}}"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="full-img-block {{!empty($signature) ? '' : 'hide'}}">
                    <button type="button" class="btn btn-default button edit" data-action="full-signature-edit"><i class="fa fa-edit"></i> Edit</button>
                </div>
                <div class="signature-pad--actions full-canvas-block {{!empty($signature) ? 'hide' : ''}}">
                    <button type="button" class="btn btn-default button clear" data-action="full-signature-clear"><i class="fa fa-remove"></i> Clear</button>
                    <button type="button" class="btn btn-default button" data-action="full-signature-undo"><i class="fa fa-undo"></i> Undo</button>
                    <button type="button" class="btn btn-primary button save" data-action="full-signature-save-base64"><i class="fa fa-check"></i> Done</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        {!! Form::label('short_signature','Initial Signature:') !!}
    </div>
    <div class="col-md-12">
        {!! Form::hidden('short_signature', null) !!}
        <div id="short-signature-pad" class="signature-pad">
            <div class="signature-pad--body">
                <img src="{{ url('/') }}/public/img/users/{{$initial}}" class="short-img-block {{!empty($initial) ? '' : 'hide'}}" width="96px" height="96px">
                <canvas width="96px" height="96px" class="short-canvas-block {{!empty($initial) ? 'hide' : ''}}"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="short-img-block {{!empty($initial) ? '' : 'hide'}}">
                    <button type="button" class="btn btn-default button edit" data-action="short-signature-edit"><i class="fa fa-edit"></i> Edit</button>
                </div>
                <div class="signature-pad--actions short-canvas-block {{!empty($initial) ? 'hide' : ''}}">
                    <button type="button" class="btn btn-default button clear mlr-15" data-action="short-signature-clear"><i class="fa fa-remove"></i> Clear</button>
                    <button type="button" class="btn btn-default button mlr-15" data-action="short-signature-undo"><i class="fa fa-undo"></i> Undo</button>
                    <button type="button" class="btn btn-primary button save mlr-15" data-action="short-signature-save-base64"><i class="fa fa-check"></i> Done</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const fullSignWrapper = document.getElementById("full-signature-pad");
    const fullSignClearButton = fullSignWrapper.querySelector("[data-action=full-signature-clear]");
    const fullSignUndoButton = fullSignWrapper.querySelector("[data-action=full-signature-undo]");
    const fullSignSaveBase64Button = fullSignWrapper.querySelector("[data-action=full-signature-save-base64]");
    const fullSignCanvas = fullSignWrapper.querySelector("canvas");
    const fullSignHiddenInput = document.querySelector('input[name="full_signature"]');

    // Initialize SignaturePad
    let fullSignSignaturePad = new SignaturePad(fullSignCanvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        minWidth: 0.5,
        maxWidth: 2.5,
        penColor: 'black'
    });

    // Resize the canvas correctly based on devicePixelRatio
    function fullSignResizeCanvas() {
        // const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const ratio = 1;
        const rect = fullSignCanvas.getBoundingClientRect(); // gives accurate CSS size

        if (rect.width === 0 || rect.height === 0) return;

        // Save signature before resizing
        const data = fullSignSignaturePad.toData();

        // Set canvas internal size
        fullSignCanvas.width = rect.width * ratio;
        fullSignCanvas.height = rect.height * ratio;

        // Reset CSS size
        fullSignCanvas.style.width = rect.width + 'px';
        fullSignCanvas.style.height = rect.height + 'px';

        // Normalize coordinate system
        fullSignCanvas.getContext('2d').scale(ratio, ratio);

        fullSignSignaturePad.clear();
        if (data.length > 0) {
            fullSignSignaturePad.fromData(data);
        } else {
            setFullSignOldImage();
        }
    }

    window.addEventListener("resize", fullSignResizeCanvas);

    function setFullSignOldImage() {
        const fullImage = new Image();
        fullImage.onload = function () {
            const ctx = fullSignCanvas.getContext("2d");

            // Clear canvas before drawing
            ctx.clearRect(0, 0, fullSignCanvas.width, fullSignCanvas.height);

            // Calculate scaling to center the image
            const scale = Math.min(
                fullSignCanvas.width / fullImage.width,
                fullSignCanvas.height / fullImage.height
                );

            const x = (fullSignCanvas.width - fullImage.width * scale) / 2;
            const y = (fullSignCanvas.height - fullImage.height * scale) / 2;

            ctx.drawImage(
                fullImage,
                0,
                0,
                fullImage.width,
                fullImage.height,
                x,
                y,
                fullImage.width * scale,
                fullImage.height * scale
                );
        };
        fullImage.src = fullSignHiddenInput.value;
    }

    // Load existing image (if any) into canvas
    if (fullSignHiddenInput.value) {
        setFullSignOldImage();
    }

    // Clear the signature
    fullSignClearButton.addEventListener("click", () => {
        fullSignSignaturePad.clear();
        fullSignHiddenInput.value = '';
    });

    // Undo last stroke
    fullSignUndoButton.addEventListener("click", () => {
        const data = fullSignSignaturePad.toData();
        if (data.length > 0) {
            data.pop(); // remove last stroke
            fullSignSignaturePad.fromData(data);
        }
    });

    // Save the signature as base64
    fullSignSaveBase64Button.addEventListener("click", () => {
        if (fullSignSignaturePad.isEmpty()) {
            alert("Please provide a signature first.");
        } else {
            const dataURL = fullSignSignaturePad.toDataURL("image/png");
            fullSignHiddenInput.value = dataURL;
        }
    });

    $('.full-img-block .edit').on('click', function() {
        $('.full-canvas-block').removeClass('hide');
        $('.full-img-block').addClass('hide');
    });



    const shortSignWrapper = document.getElementById("short-signature-pad");
    const shortSignClearButton = shortSignWrapper.querySelector("[data-action=short-signature-clear]");
    const shortSignUndoButton = shortSignWrapper.querySelector("[data-action=short-signature-undo]");
    const shortSignSaveBase64Button = shortSignWrapper.querySelector("[data-action=short-signature-save-base64]");
    const shortSignCanvas = shortSignWrapper.querySelector("canvas");
    const shortSignHiddenInput = document.querySelector('input[name="short_signature"]');

    // Initialize SignaturePad
    let shortSignSignaturePad = new SignaturePad(shortSignCanvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        minWidth: 0.5,
        maxWidth: 2.5,
        penColor: 'black'
    });

    // Resize the canvas correctly based on devicePixelRatio
    function shortSignResizeCanvas() {
        // const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const ratio = 1;
        const rect = shortSignCanvas.getBoundingClientRect(); // gives accurate CSS size

        if (rect.width === 0 || rect.height === 0) return;

        // Save signature before resizing
        const data = shortSignSignaturePad.toData();

        // Set canvas internal size
        shortSignCanvas.width = rect.width * ratio;
        shortSignCanvas.height = rect.height * ratio;

        // Reset CSS size
        shortSignCanvas.style.width = rect.width + 'px';
        shortSignCanvas.style.height = rect.height + 'px';

        // Normalize coordinate system
        shortSignCanvas.getContext('2d').scale(ratio, ratio);

        shortSignSignaturePad.clear();
        if (data.length > 0) {
            shortSignSignaturePad.fromData(data);
        } else {
            setShortSignOldImage();
        }
    }

    window.addEventListener("resize", shortSignResizeCanvas);

    function setShortSignOldImage() {
        const shortImage = new Image();
        shortImage.onload = function () {
            const ctx = shortSignCanvas.getContext("2d");

            // Clear canvas before drawing
            ctx.clearRect(0, 0, shortSignCanvas.width, shortSignCanvas.height);

            // Calculate scaling to center the image
            const scale = Math.min(
                shortSignCanvas.width / shortImage.width,
                shortSignCanvas.height / shortImage.height
                );

            const x = (shortSignCanvas.width - shortImage.width * scale) / 2;
            const y = (shortSignCanvas.height - shortImage.height * scale) / 2;

            ctx.drawImage(
                shortImage,
                0,
                0,
                shortImage.width,
                shortImage.height,
                x,
                y,
                shortImage.width * scale,
                shortImage.height * scale
                );
        };
        shortImage.src = shortSignHiddenInput.value;
    }

    // Load existing image (if any) into canvas
    if (shortSignHiddenInput.value) {
        setOldImage();
    }

    // Clear the signature
    shortSignClearButton.addEventListener("click", () => {
        shortSignSignaturePad.clear();
        shortSignHiddenInput.value = '';
    });

    // Undo last stroke
    shortSignUndoButton.addEventListener("click", () => {
        const data = shortSignSignaturePad.toData();
        if (data.length > 0) {
            data.pop(); // remove last stroke
            shortSignSignaturePad.fromData(data);
        }
    });

    // Save the signature as base64
    shortSignSaveBase64Button.addEventListener("click", () => {
        if (shortSignSignaturePad.isEmpty()) {
            alert("Please provide a signature first.");
        } else {
            const dataURL = shortSignSignaturePad.toDataURL("image/png");
            shortSignHiddenInput.value = dataURL;
        }
    });

    $('.short-img-block .edit').on('click', function() {
        $('.short-canvas-block').removeClass('hide');
        $('.short-img-block').addClass('hide');
    });
</script>
