<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 5px;
            vertical-align: top;
        }

        .no-border {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
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
