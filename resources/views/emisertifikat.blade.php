<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Business Capital</title>
    <style>
        body {

            background: url('{{asset("img/EMI5.webp")}}');
            background-repeat: no-repeat;
            background-size: contain;
            height: 750px;
        }

        .paragraph {
            /* border: 1px solid black; */
            font-family: 'Times New Roman', Times, serif;
            margin: 300px 0px 70px 80px;
            width: 590px;
            font-size: 1.12em;
            height: 250px;
            /* background-color: lightblue; */
            /* font-weight: 600; */
        }

        span {
            display: inline-block;
            min-width: 190px;
        }

        .container-1 {
            display: flex;
            max-width: 565px;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .container-2 {
            width: 195px;
            word-wrap: break-word;
        }

        .container-3 {
            width: 360px;
            word-wrap: break-word;
            padding-left: 10px;
        }
        
        .tanggal-terbit{
            margin-top:140px;
            font-size: 1.12em;
            text-align: center;
            width: 590px;
            margin-left:80px;
            /* background-color: lightblue; */

        }
    </style>
</head>

<body>
  @php
  use Carbon\Carbon;
  Carbon::setLocale('id');
  @endphp
    <div class="paragraph">
        <div class="container-1">
            <div class="container-2">
                <span>Proyek Bisnak</span>:
            </div>
            <div class="container-3"> {{$portofolio->project_batch->fullName()}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Nama Lengkap</span>:
            </div>
            <div class="container-3"> {{$portofolio->user->name}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Nomor Kontrak</span>:
            </div>
            <div class="container-3"> {{$portofolio->contract_number}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Jumlah Dana</span>:
            </div>
            <div class="container-3"> Rp {{number_format($portofolio->nominal,0,",",".")}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Tanggal Bergabung</span>:
            </div>
            <div class="container-3"> {{ Carbon::parse($portofolio->created_at)->isoFormat('D MMMM Y')}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Masa Proyek</span>:
            </div>
            <div class="container-3">{{ Carbon::parse($portofolio->project_batch->start_date)->isoFormat('D MMMM Y')}} - {{ Carbon::parse($portofolio->project_batch->end_date)->isoFormat('D MMMM Y')}}</div>
        </div>
        <div class="container-1">
            <div class="container-2">
                <span>Estimasi Profit Sharing</span>:
            </div>
            <div class="container-3"> {{$portofolio->project_batch->getRangeROI()}} % / {{$portofolio->project_batch->period()}} Bulan</div>
        </div>
    </div>

    <p class="tanggal-terbit">Denpasar , {{ Carbon::parse($portofolio->created_at)->isoFormat('D MMMM Y')}}</p>

</body>

</html>
