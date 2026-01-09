<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }
        .page-break {
            page-break-after: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>

@include('pdf.keuangans.rincian')

<div class="page-break"></div>

@include('pdf.keuangans.riil')

<div class="page-break"></div>

@include('pdf.keuangans.spby')

</body>
</html>
