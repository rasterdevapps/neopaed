<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

<script type="text/javascript">
    function openViewerWithPost(url, uhid, apiKey) {

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", url+'ripacs1/ipacs');

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'api_key';
        input.value = apiKey;
        form.appendChild(input);

        var input1 = document.createElement('input');
        input1.type = 'hidden';
        input1.name = 'patientID';
        input1.value = uhid;
        form.appendChild(input1);

        var input3 = document.createElement('input');
        input3.type = 'hidden';
        input3.name = 'preview';
        input3.value = 'true';
        form.appendChild(input3);

        //console.log(input1.value + " : " + input3.value);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
    openViewerWithPost('{{ $pacs_link }}', '{{ $patientUhid }}', '{{ $pacs_api_key }}')
</script>
</body>
</html>
