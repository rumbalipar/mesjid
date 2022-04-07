<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kwitansi</title>
    <style>
        * {
            margin:0;
            padding:0;
        }
        body {
            background:#FFF;
            margin:0px auto;
            padding:0;
            font-family:"Times New Roman", Times, serif;
        }
        /* wrapper */
        div.pagewidth {
            width:100%;
            margin:0px auto;
            background-color:#ffffff;
        }
        
        #judul{
            font-size:24px;
            text-align:center;
            margin-bottom:10px;
            margin-top:20px;
            letter-spacing: 2px;
            font-family:Arial, Helvetica, sans-serif;
        }
        #no_kwitansi{
            width:100%;
            text-align:right;
        }
        table{
            font-size:12px;
            width:100%;
        }
        table tr td{
            padding:10px;
        }
        .ttd{
            margin-top:20px;
            float:right;
            width:200px;
            text-align:center;
        }
        .no{
            float:left;
            margin-top:20px;
            margin-left:10px;
        }
        /* default links */	
        
        /* centeral page */
        div.page {
            clear:both;
            margin:0;
            padding:0;
            background-color:#ffffff;
        }
        
        /* content */
        div.page-wrap {
            padding:5px 10px;
            clear:both;
            background-color:#fff;
        }
        </style>
</head>
<body>
<div class="pagewidth">
    <div class="page-wrap">
	<div id="judul"><u>KWITANSI</u><br>RECEIPT</div>
    <div id="no_kwitansi"><i>No Kwitansi : {{ date('Ymd',strtotime($data['tanggal'])).$data['id'] }}</i></div>
    <table>
    	<tr>
        	<td width="200px"><u>Sudah Terima Dari</u><br>Receive From</td>
            <td width="20px">:</td>
            <td>{{ $data['pemberi'] }}</td>
        </tr>
        <tr>
        	<td><u>Banyaknya Uang</u><br>In Words</td>
            <td>:</td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000;"><i># {{ $terbilang }} Rupiah #</i></td>
        </tr>
        <tr>
        	<td><u>Untuk Pembayaran</u><br>Payment For</td>
            <td>:</td>
            <td>{{ $data['deskripsi'] }}</td>
        </tr>
        <tr>
        	<td><u>Jumlah Uang</u><br>Total</td>
            <td>:</td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000;">Rp {{ number_format($data['jumlah']) }}.00</td>
        </tr>
    </table>
    
    <div class="ttd">
    Bandung, {{ date('d-m-Y',strtotime($data['tanggal'])) }}
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    ( {{ ucwords($data['penerima']); }} )
    </div>
    </div>
</div>
</body>
</html>