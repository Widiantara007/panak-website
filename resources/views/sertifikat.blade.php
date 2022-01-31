<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
    body {
        background: url('{{asset("img/sertif.webp")}}');
        background-repeat: no-repeat;
        background-size: contain;
        height: 750px;
    }

    .paragraph {
        /* border: 1px solid black; */
        font-family: 'Times New Roman', Times, serif;
        margin: 350px 0px 0px 80px;
        width: 590px;
        font-size: 1.14em;
        
        /* background-color: lightblue; */
        text-align: center;
        /* font-weight: 600; */

    }

    .container-1 {
        max-width: 300px;
        word-wrap: break-word;

    }

    h2,
    p {
        margin: 0;
    }

    p {
        font-size: 1.14em;
        text-align: center;
    }

    .nama-investor {
        /* margin-bottom: 1em; */
        padding: 0;
        /* background-color: lightblue; */
        height: 60px;
        /* margin-bottom: 5px; */
    }

    .essay {
        height: 8em;
        margin-top: 10px;
        /* background-color: lightblue; */
        /* text-align: center; */
    }

    #verticalDiv {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
    }

    .profit {
        margin-top: 110px;
        font-size: 1.22em;
    }
    </style>
</head>

<body>
    @php
    use App\Models\Address;
    use Carbon\Carbon;
    Carbon::setLocale('id');
    @endphp
    <div class="paragraph">
        <div class="nama-investor">
            <h2><u>{{$portofolio->user->name}}</u></h2>
        </div>
        <div class="essay">
            <p id="verticalDiv">Atas penanaman modal sebesar Rp {{number_format($portofolio->nominal,0,",",".")}} <br>
                Kepada {{$portofolio->project_batch->fullName()}}
                <br>
                Di {{Str::title(Address::getFullAddressCertificate($portofolio->project->location_code))}}
                <br>
                Dimulai sejak {{ Carbon::parse($portofolio->project_batch->start_date)->isoFormat('MMMM Y')}} Sampai {{ Carbon::parse($portofolio->project_batch->end_date)->isoFormat('MMMM Y')}}
            </p>
        </div>
    </div>

    <p class="profit">Hasil Profit sharing sebesar : {{$portofolio->profitPercentage()}}%</p>

</body>

</html>