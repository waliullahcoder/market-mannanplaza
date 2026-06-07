<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/png" sizes="20x20" href="{{ asset('/') }}public/uploads/admin_logo/logo_small.png">
    <title>{{ $title }}</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.css" rel="stylesheet"> --}}
    <style>
        body {
            font-family: bangla, Arial, Helvetica, sans-serif;
            text-align: left;
        }

        #report-table {
            /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
            font-family: bangla;
            border-collapse: collapse;
            width: 100%;
        }

        #report-table td,
        #report-table th {
            border: 1px solid #333;
            color: #333;
        }

        #report-table thead th {
            text-align: left;
        }

        #report-table thead th.text-center {
            text-align: center;
        }

        #report-table tbody {
            text-align: left;
        }

        #report-table tbody td.text-center {
            text-align: center;
        }

        #report-table td {
            font-size: 11px;
            padding: 5px;
        }

        #report-table th {
            font-size: 13px;
            vertical-align: middle;
            padding: 3px;
        }

        .text-center {
            text-align: center !important;
        }

        #report-header {
            background-color: lightgray;
            width: 100%;
            padding: 0px;
            font-weight: bold;
            font-size: 15px;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        #report-table tfoot th {
            background-color: #778899;
            color: black;
        }

        #report-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #report-table tr:hover {
            background-color: #ddd;
        }

        caption {
            font-weight: bold;
            text-decoration: underline;
            padding-bottom: 5px;
        }

        #header-table {
            /* font-family: Times, "Times New Roman", serif; */
            font-family: bangla;
            border-collapse: collapse;
            width: 100%;
        }

        #header-table td,
        #header-table th {
            /*background-color: #a4b7b4;*/
            color: black;
            border: 0px solid #ddd;
            padding: 5px;
        }

        #header-table td {
            font-size: 14px;
        }

        #header-table th {
            font-size: 24px;
            font-weight: B;
        }

        #pad-bottom {
            padding-bottom: 10px;
        }

        .overline {
            border-top: 2px solid currentColor;
        }


        #account-voucher-table {
            /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
            font-family: bangla;
            border-collapse: collapse;
            width: 100%;
        }

        #account-voucher-table td,
        #account-voucher-table th {
            border: 1px solid #ddd;
        }

        #account-voucher-table td {
            font-size: 11px;
            padding: 5px;
        }

        #account-voucher-table th {
            /*background-color: #4CAF50;*/
            color: black;
            font-size: 13px;
            vertical-align: middle;
            padding: 3px;
        }

        #account-voucher-header {
            /*background-color: lightgray;*/
            border: 1px solid #ddd;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            font-size: 15px;
        }

        #account-voucher-table tfoot th {
            color: black;
        }

        #voucher-sign-table {
            width: 100%;
            border-collapse: collapse;
        }

        #voucher-sign-table td {
            width: 50%;
            border: 0px solid black;
        }

        .print-header {
            text-align: center;
        }

        .print-header h4 {
            font-size: 32px;
            margin: 0;
            font-weight: bold;
            line-height: 1;
        }

        .print-header p {
            text-decoration: underline;
            line-height: 1.5;
            font-weight: 600;
            margin-top: 5px;
        }

        .signature-area {
            margin-top: 70px;
        }

        .signature-area .table {
            width: 100%;
        }

        .mb-0 {
            margin-bottom: 0;
        }
    </style>

    @yield('custome-css')
</head>

<body>
    @yield('content')

    <div class="signature-area">
        <table class="table">
            <tbody>
                <tr>
                    <td width="20%" class="text-center">অফিস সহকারী</td>
                    <td width="20%" class="text-center">ক্যাশিয়ার</td>
                    <td width="20%" class="text-center">ইনচার্জ</td>
                    <td width="20%" class="text-center">ম্যানেজার</td>
                    <td width="20%" class="text-center">চেয়ারম্যান</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
