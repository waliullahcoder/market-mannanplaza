@php
    use App\HelperClass;
@endphp

<style>
    .noprint{ margin-bottom:15px; }

    .bill-page{
        width:210mm;
        min-height:297mm;
        margin:auto;
        background:#fff;
    }

    .bill-copy{
         margin-top:60px;
        width:210mm;
        height:160mm;
        /* padding:10mm 12mm 7mm; */
        box-sizing:border-box;
        position:relative;
        font-family:Arial, sans-serif;
        color:#111;
        overflow:hidden;
    }

    .copy-divider{
        border:0;
        /* border-top:1px dashed #000; */
        margin:0;
    }

    .bill-top{
        display:grid;
        grid-template-columns:30mm 1fr 45mm;
        align-items:start;
    }

    .logo img{
        width:80px;
        height:auto;
    }

    .bill-title{
        text-align:center;
        line-height:1.25;
    }

    .bill-title h2{
        margin:0;
        font-size:22px;
        font-weight:800;
    }

    .bill-title h4,
    .bill-title p{
        margin:2px 0;
        font-size:13px;
        font-weight:700;
    }

    .copy-name{
        text-align:right;
        font-weight:800;
        font-size:14px;
    }

    .paid-box{
        margin-top:10px;
        border:2px solid #777;
        height:55px;
        text-align:center;
        font-size:24px;
        font-weight:900;
        color:#777;
        opacity:.55;
        padding-top:10px;
    }

    .bill-body{
        display:grid;
        grid-template-columns:1fr 1fr;
        font-size:16px;
    }

    .info-grid{
        display:grid;
        grid-template-columns:140px 10px 1fr;
        row-gap:4px;
        align-items:center;
    }

    .info-grid .label{
        font-weight:800;
    }

    .amount-box{
        display:inline-block;
        border:2px solid #000;
        padding:1px 12px;
        min-width:95px;
        font-weight:900;
        background:#ddd;
    }

    .right-grid{
        display:grid;
        grid-template-columns:145px 10px 1fr;
        row-gap:4px;
        align-items:center;
    }

    .right-grid .label{
        font-weight:800;
    }

    .word-line{
        display:grid;
        grid-template-columns:140px 10px 1fr;
        margin-top:3px;
        font-size:16px;
    }

    .signature-row{
        display:grid;
        grid-template-columns:1fr 1fr;
        margin-top:1mm;
        font-size:15px;
        font-weight:700;
        align-items:end;
    }

    .signature-line{
        width:220px;
        border-top:2px solid #000;
        padding-top:4px;
    }

    .signature-right{
        text-align:right;
    }

    .signature-right .signature-line{
        margin-left:auto;
        text-align:center;
    }

    .signature-img{
        width:130px;
        height:45px;
        object-fit:contain;
        display:block;
        margin-left:auto;
        margin-bottom:-4px;
    }

    .notice{
        text-align:center;
        margin-top:8mm;
        font-size:18px;
        font-weight:900;
    }

    .thanks{
        text-align:center;
        font-size:16px;
        font-weight:800;
        margin-top:5px;
    }

    .print-footer{
        position:absolute;
        left:12mm;
        right:12mm;
        bottom:7mm;
        display:flex;
        justify-content:space-between;
        font-size:13px;
        font-style:italic;
    }

    @media print{
        @page{
            size:A4 portrait;
            margin:0;
        }

        body{
            margin:0 !important;
            background:#fff !important;
        }

        .noprint,
        .sidebar,
        .navbar,
        .footer{
            display:none !important;
        }

        .bill-page{
            width:210mm;
            height:297mm;
            page-break-after:always;
        }

        .bill-copy{
            page-break-inside:avoid;
            break-inside:avoid;
        }
    }
</style>

<div class="mt-4 noprint">
    <div class="row">
        <div class="col-md-2 offset-md-10 text-right">
            <button class="btn btn-info" onclick="window.print()">Print</button>
        </div>
    </div>
</div>

<div id="report_div">

@if(count($data->bills) > 0)

@foreach(array_slice($data->bills, 0, 1) as $bill)

@php
    $total = 0;

    if(isset($bill[0])) $total += $bill[0]->Amount;
    if(isset($bill[1])) $total += $bill[1]->Amount;

    if(isset($sbills)){
        foreach($sbills as $sb){
            $total += $sb->Amount;
        }
    }

    $copies = ['Office Copy', 'Client Copy'];
@endphp

<div class="bill-page">

@foreach($copies as $copy)

<div class="bill-copy">

    <div class="bill-top">
        <div class="logo">
            <img src="{{ asset('public/elite-admin/assets/images/ksc_logo.png') }}" alt="Logo">
        </div>

        <div class="bill-title">
            <h2>Electricity & Utility Bill</h2>
            <h4>Project Name : {{ $data->project->name }}</h4>
            <p>{{ $data->project->address }}</p>
            <p>Ph- {{ $data->project->contact }}</p>
            <p>
                Pay Circle :
                @if(isset($bill[0]) && $bill[0] != null)
                    {{ $bill[0]->CMonth }}, {{ $bill[0]->CYear }}
                @endif
            </p>
        </div>

        <div>
            <div class="copy-name">{{ $copy }}</div>

            @if(isset($bill[0]) && $bill[0]->ReceiveDate)
                <div class="paid-box">
                    PAID<br>
                    <small>{{ date('d M Y', strtotime($bill[0]->ReceiveDate)) }}</small>
                </div>
            @endif
        </div>
    </div>

    <div class="bill-body">

        <div>
            <div class="info-grid">
                <div class="label">Shop No</div><div>:</div><div>{{ $bill['tenant']->Code ?? '' }}</div>
                <div class="label">Mobile</div><div>:</div><div>{{ $bill['tenant']->Mobile ?? '' }}</div>

                <div class="label">WP Unit</div><div>:</div><div>{{ isset($bill[1]) ? $bill[1]->PreviousUnit : 0 }}</div>
                <div class="label">Uses Unit</div><div>:</div><div>{{ isset($bill[1]) ? $bill[1]->UsesUnit : 0 }}</div>

                
               
                <div class="label">WC Unit</div><div>:</div><div>{{ isset($bill[1]) ? $bill[1]->LastUnit : 0 }}</div>
                <div class="label">W Bill</div><div>:</div><div>{{ isset($bill[1]) ? number_format($bill[1]->Amount, 2) : '0.00' }}</div>

                <div class="label">EP Unit</div><div>:</div><div>{{ isset($bill[0]) ? $bill[0]->PreviousUnit : 0 }}</div>

                <div class="label">EC Unit</div><div>:</div><div>{{ isset($bill[0]) ? $bill[0]->LastUnit : 0 }}</div>
                 <div class="label">Uses Unit</div><div>:</div><div>{{ isset($bill[0]) ? $bill[0]->UsesUnit : 0 }}</div>

                <div class="label">Total Bill</div><div>:</div>
                <div><span class="amount-box">{{ number_format($total, 2) }}</span></div>
            </div>

            <div class="word-line">
                <div class="label"><b>In a Word</b></div>
                <div>:</div>
                <div>{{ HelperClass::numberToWords($total) }} only.</div>
            </div>
        </div>

        <div>
            <div class="right-grid">
                <div class="label">Shop Name</div><div>:</div><div>{{ $bill['tenant']->shop_name ?? $bill['tenant']->Name ?? '' }}</div>
                <div class="label">Floor No</div><div>:</div><div>{{ $bill['tenant']->Floor ?? '' }}</div>
                <div class="label">Client Code</div><div>:</div><div>{{ $bill['tenant']->Code ?? '' }}</div>
                <div class="label">Client Name</div><div>:</div><div>{{ $bill['tenant']->Name ?? '' }}</div>
                <div class="label">EBill + Vat</div><div>:</div><div>{{ isset($bill[0]) ? number_format($bill[0]->Amount, 2) : '0.00' }}</div>

                @if(isset($sbills))
                    @foreach($sbills as $sb)
                        <div class="label">{{ $sb->utility->name }}</div><div>:</div>
                        <div>{{ number_format($sb->Amount, 2) }}</div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    <div class="signature-row">
        <div>
            <div class="signature-line">On behalf of Client Signature</div>
        </div>

        <div class="signature-right">
            <img class="signature-img"
                 src="{{ asset('public/elite-admin/assets/images/signature.png') }}"
                 alt="Signature">

            <div class="signature-line">Authorize Signature</div>
        </div>
    </div>

    <div class="notice">
        Please pay your bill in appropriate time. Otherwise your Electric Supply will be disconnected.
    </div>
    <div class="thanks">Thank you for your co-operation.</div>

</div>

@if(!$loop->last)
    <hr class="copy-divider">
@endif

@endforeach

</div>

@endforeach

@else
    <h2 class="text-center mt-4">No Data Found</h2>
@endif

</div>