<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>TAGIHAN #{{$data->no}} </title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: Arya, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.top table td.subtitle {
        /*padding-top: 8px;*/
        /*font-size: 20px;*/
        line-height: 20px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    .text-left {
        text-align: left;
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
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title" style="width: 60%;">
                              <img src="{!! config()->get('tcust.logo') !!}" style="max-height: 100px;">
                            </td>
                            
                            <td class="subtitle" style="width: 40%;">
                                <span style="font-size:15px;">
                                    <strong>{{$data->customer['name']}}</strong>
                                </span><br/>
                                <span style="font-size:12px;">
                                    {{$data->customer['address']}}<br/>
                                    {{$data->customer['phone']}}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <hr style="height:.5px;border-width:0;color:#bbb;background-color:#bbb">
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td style="width: 35%;font-size:12px;">
                                <strong>Kepada</strong><br/>
                                  {{$data->loger['name']}}<br/>
                                  {{$data->loger['address']}}<br/>
                                  {{$data->loger['phone']}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
              
            <tr>
                <td colspan="5" style="padding-bottom: 20px !important;">
                    <table>
                        <tr>
                            <td style="width: 45%;">
                                <table>
                                    <tr style="font-size:11px;">
                                        <td>
                                            <strong>Tagihan</strong><br/>
                                            Nomor <br/>
                                            Tanggal <br/>
                                            ID Pelanggan <br/>
                                            Website 
                                        </td>
                                        <td class="text-left">
                                            &nbsp; <br/>
                                            {{ $data->no }} <br/>
                                            {{ $data->issued_at->format('d M Y') }} <br/>
                                            {{ $data->loger['account_no'] }} <br/>
                                            {{ $data->loger['website'] }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 55%;">
                                <table>
                                    <tr class="heading" style="font-size:12px;">
                                        <td colspan="2">Tagihan Periode {{ $data->customer['period_start'] }} - {{ $data->customer['period_end'] }} </td>
                                        
                                    </tr>
                                    
                                    @foreach($data->loging as $v)
                                    <tr class="details" style="font-size:12px;">
                                        <td>
                                            {{$v['description']}}
                                        </td>
                                        <td class="text-right">
                                            Rp {{number_format($v['amount'], 0, '.', ',')}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    <tr class="total" style="font-size:14px;">
                                        <td>
                                            <strong>Total</strong>
                                        </td>
                                        <td class="text-right" >
                                            Rp {{ number_format($data->ux_log, 0, '.', ',') }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td style="font-size: 12px; line-height: 21px;">
                                @if(!$data->paid_at && $data->due_at)
                                    Harap melakukan pembayaran sebelum {{ $data->due_at->format('d M Y') }}.<br/>
                                @endif
                                @if($data->paid_at)
                                <strong>Lunas {{ $data->paid_at->format('d M Y') }}</strong>
                                @else
                                <strong><a href="{{ $url }}" target="__blank">Bayar Sekarang</a></strong>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
