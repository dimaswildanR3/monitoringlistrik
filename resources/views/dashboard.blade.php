<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Monitoring Kelistrikan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    <style>
        /* TABLE RESPONSIVE */

.tableContainer{
    width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    border-radius:10px;
    margin-top:15px;
}

.tableContainer::-webkit-scrollbar{
    height:8px;
}

.tableContainer::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:10px;
}

table{
    width:100%;
    min-width:1400px;
    border-collapse:collapse;
    white-space:nowrap;
}

thead{
    position:sticky;
    top:0;
    z-index:2;
}

th{
    background:#002a72;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:center;
}

tr:hover{
    background:#f8fafc;
}
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
        }

        /* HEADER */

        .header {
            background: #002a72;
            height: 75px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand img {
            height: 45px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 20px;
        }

        .box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
            margin-bottom: 20px;
        }

        /* TOP TITLE */

        .topHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }



        /* STATUS */

        .statusGrid {

            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
margin-bottom: 10px;
        }

        .statusCard {

            background: white;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            gap: 15px;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

        }

        .iconCircle {

            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;

        }

        .greenBg {
            background: #dff5e6;
        }

        .blueBg {
            background: #dfe9ff;
        }

        .orangeBg {
            background: #fff1d6;
        }

        .redBg {
            background: #ffe2e2;
        }

        .big {

            font-size: 30px;
            font-weight: bold;

        }

        .green {
            color: #16a34a;
        }

        .blue {
            color: #2563eb;
        }

        .orange {
            color: #f59e0b;
        }

        .red {
            color: #ef4444;
        }

        .badge {

            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;

        }

        .badgeGreen {
            background: #dcfce7;
            color: #16a34a;
        }

        .badgeOrange {
            background: #ffedd5;
            color: #f97316;
        }

        /* CONTENT */

        .content {

            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 20px;

        }

        .chartGrid {

            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;

        }

        .chartCard {

            height: 300px;

        }

        .sidePanel {

            height: 100%;

        }

        .eval {

            padding: 15px 0;
            border-bottom: 1px solid #eee;

        }

        .recommend {

            background: #ecfdf5;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            border: 1px solid #86efac;

        }

        /* TABLE */

        .exportBtn {

            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 20px;

        }

        table {

            width: 100%;
            border-collapse: collapse;
            min-width: 1500px;

        }

        th {

            background: #002a72;
            color: white;
            padding: 10px;

        }

        td {

            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: center;

        }

        canvas {

            height: 220px !important;

        }

        @media(max-width:1000px) {

            .statusGrid {
                grid-template-columns: 1fr;
            }

            .content {
                grid-template-columns: 1fr;
            }

            .chartGrid {
                grid-template-columns: 1fr;
            }

        }
    </style>
</head>

<body>
@php
$labels=[];$thdv=[];$thdi=[];
$unb=[];$dev=[];

foreach($data as $d){

    $labels[]=\Carbon\Carbon::parse(
        $d->waktu_log
    )->format('H:i');

    $thdv[]=(float)$d->thdv;
    $thdi[]=(float)$d->thdi;
    $unb[]=(float)$d->unbalance;
    $dev[]=(float)$d->deviasi;
}

$lastData = $data->last();
@endphp


    <div class="header">

        <div class="brand">

            <img src="https://monitoringppns.com/2.png">

            <h2>Monitoring Kelistrikan</h2>

        </div>

        <div class="nav">

            <a href="/">Dashboard</a>
            <a href="/hasil">Evaluasi</a>

            <img
                src="https://monitoringppns.com/1.png"
                style="height:45px">

        </div>

    </div>



    <div class="container">

        <div class="box topHeader">

            <div>

                <h2>
                    Dashboard Monitoring
                </h2>

                <p>
                    Monitoring kualitas daya dan konsumsi energi listrik secara real-time
                </p>

            </div>

            <div>

                <div>
                    Pembaruan terakhir:
                    {{now()}}
                </div>

            </div>

        </div>


        <div class="statusGrid">
        <div class="statusCard">
    <div class="iconCircle 
        {{ isset($lastData) ? ($lastData->audit == 1 ? 'greenBg' : 'redBg') : 'grayBg' }}">
        ⚡
    </div>

    <div class="statusContent">
        <div>Status Sistem</div>

        <div class="big 
            {{ isset($lastData) ? ($lastData->audit == 1 ? 'green' : 'red') : 'gray' }}">
            
            {{ isset($lastData)
                ? ($lastData->audit == 1 ? 'NORMAL' : 'TIDAK NORMAL')
                : 'DATA KOSONG' }}
        </div>

        <span class="badge 
            {{ isset($lastData) ? ($lastData->audit == 1 ? 'badgeGreen' : 'badgeRed') : 'badgeGray' }}">
            
            {{ isset($lastData)
                ? ($lastData->audit == 1 ? 'Normal' : 'Tidak Normal')
                : 'Belum ada data' }}
        </span>
    </div>
</div>

<style>
.statusCard{
    display:flex;
    align-items:center;
    gap:12px;
}

.statusContent{
    min-width:0;
}

.big{
    white-space:nowrap;
    font-weight:bold;
}

.badge{
    white-space:nowrap;
}

.green{
    color:#22c55e;
}

.red{
    color:#ef4444;
}
</style>

<div class="statusCard">
    <div class="iconCircle blueBg">
        T%
    </div>

    <div>
        <div>THD V</div>

        <div class="big blue">
            {{ number_format(optional($lastData)->thdv ?? 0, 2) }}
        </div>

        <span class="badge 
        {{ optional($lastData)->status_thdv == 1 ? 'badgeGreen' : 'badgeRed' }}">
        
            {{ optional($lastData)->status_thdv == 1 
                ? 'Standar' 
                : 'Belum ada data' }}
                
        </span>
    </div>
</div>
<div class="statusCard">
    <div class="iconCircle greenBg">
        ⚡
    </div>

    <div>
        <div>THD I</div>

        <div class="big green">
            {{ number_format(optional($lastData)->thdi ?? 0, 2) }}
        </div>

        <span class="badge
        {{
            is_null(optional($lastData)->status_thdi)
            ? 'badgeGray'
            : (optional($lastData)->status_thdi == 1
                ? 'badgeGreen'
                : 'badgeRed')
        }}">
            {{
                is_null(optional($lastData)->status_thdi)
                ? 'Belum ada data'
                : (optional($lastData)->status_thdi == 1
                    ? 'Standar'
                    : 'Tidak')
            }}
        </span>
    </div>
</div>


<div class="statusCard">
    <div class="iconCircle orangeBg">
        ⚖️
    </div>

    <div>
        <div>Unbalance</div>

        <div class="big orange">
            {{ number_format(optional($lastData)->unbalance ?? 0, 2) }}
        </div>

        <span class="badge
        {{
            is_null(optional($lastData)->status_unbalance)
            ? 'badgeGray'
            : (optional($lastData)->status_unbalance == 1
                ? 'badgeGreen'
                : 'badgeRed')
        }}">
            {{
                is_null(optional($lastData)->status_unbalance)
                ? 'Belum ada data'
                : (optional($lastData)->status_unbalance == 1
                    ? 'Standar'
                    : 'Tidak')
            }}
        </span>
    </div>
</div>


<div class="statusCard">
    <div class="iconCircle redBg">
        Δ
    </div>

    <div>
        <div>Deviasi</div>

        <div class="big red">
            {{ number_format(optional($lastData)->deviasi ?? 0, 2) }}
        </div>

        <span class="badge
        {{
            is_null(optional($lastData)->status_deviasi)
            ? 'badgeGray'
            : (optional($lastData)->status_deviasi == 1
                ? 'badgeGreen'
                : 'badgeRed')
        }}">
            {{
                is_null(optional($lastData)->status_deviasi)
                ? 'Belum ada data'
                : (optional($lastData)->status_deviasi == 1
                    ? 'Standar'
                    : 'Tidak')
            }}
        </span>
    </div>
</div>

</div>



        <div class="content">

            <div>

                <div class="chartGrid">

                    <div class="box chartCard">
                        <h3>Tren THD V (%)</h3>
                        <canvas id="chartTHDV"></canvas>
                    </div>

                    <div class="box chartCard">
                        <h3>Tren THD I (%)</h3>
                        <canvas id="chartTHDI"></canvas>
                    </div>

                    <div class="box chartCard">
                        <h3>Tren Unbalance (%)</h3>
                        <canvas id="chartUnbalance"></canvas>
                    </div>

                    <div class="box chartCard">
                        <h3>Tren Deviasi (%)</h3>
                        <canvas id="chartDeviasi"></canvas>
                    </div>

                </div>

            </div>


            <div class="box sidePanel">

                <h2>Hasil Evaluasi Otomatis</h2>

                <div class="eval">
                    ✓ THD V ({{number_format(end($thdv),2)}}%)
                </div>

                <div class="eval">
                    ✓ THD I ({{number_format(end($thdi),2)}}%)
                </div>

                <div class="eval">
                    ✓ Unbalance ({{number_format(end($unb),2)}}%)
                </div>

                <div class="eval">
                    ⚠ Deviasi ({{number_format(end($dev),2)}}%)
                </div>

                <div class="recommend">

                    <b>Rekomendasi</b>

                    <p>

                        THD V, THD I dan Unbalance normal.

                        Deviasi perlu dipantau.

                    </p>

                </div>

            </div>

        </div>



        <div class="box" style="margin-top: 10px;">

            <button
                class="exportBtn"
                onclick="exportTableToExcel()">

                📥 Export Excel

            </button>

            <h2>Data Monitoring Energi</h2>

            <div class="tableContainer">

            <table>

                <thead>

                <tr>
            <th>Device</th>
            <th>IR</th><th>IS</th><th>IT</th>
            <th>VRN</th><th>VSN</th><th>VTN</th>
            <th>VRS</th><th>VST</th><th>VTR</th>
            <th>V Mean</th>
            <!-- <th>Power (kW)</th> -->
            <th>Energy (kWh)</th>
            <th>THD V</th>
            <th>THD I</th>
            <th>Freq</th>
            <th>Unbalance</th>
            <th>Deviasi</th>
            <th>PF</th>
            <th>Waktu</th>
        </tr>

                </thead>

                <tbody id="tableBody">

                    @foreach($data as $d)

                    <tr>
            <td>{{ $d->id_device }}</td>
            <td>{{ number_format($d->ir,2) }}</td>
            <td>{{ number_format($d->is,2) }}</td>
            <td>{{ number_format($d->it,2) }}</td>
            <td>{{ number_format($d->vrn,2) }}</td>
            <td>{{ number_format($d->vsn,2) }}</td>
            <td>{{ number_format($d->vtn,2) }}</td>
            <td>{{ number_format($d->vrs,2) }}</td>
            <td>{{ number_format($d->vst,2) }}</td>
            <td>{{ number_format($d->vtr,2) }}</td>
            <td>{{ number_format($d->vmean,2) }}</td>
            <!-- <td>{{ number_format($d->pw,2) }}</td> -->
            <td>{{ number_format($d->ener,2) }}</td>
            <td>{{ number_format($d->thdv ?? 0,2) }}%</td>
            <td>{{ number_format($d->thdi ?? 0,2) }}%</td>
            <td>{{ number_format($d->freq,2) }}</td>
            <td>{{ number_format($d->unbalance,2) }}%</td>
            <td>{{ number_format($d->deviasi,2) }}%</td>
            <td>{{ number_format($d->pf,2) }}</td>
            <td>{{ \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y H:i:s') }}</td>
        </tr>

                    @endforeach

                </tbody>

            </table>
            </div>
        </div>

    </div>

    <script>
        function makeChart(id, data, color) {

            new Chart(

                document.getElementById(id),

                {

                    type: 'line',

                    data: {

                        labels: @json($labels),

                        datasets: [{

                            data: data,
                            borderColor: color,
                            backgroundColor: color + '33',
                            fill: true,
                            tension: .4

                        }]

                    }

                });

        }

        makeChart(
            'chartTHDV',
            @json($thdv),
            '#2563eb'
        );

        makeChart(
            'chartTHDI',
            @json($thdi),
            '#16a34a'
        );

        makeChart(
            'chartUnbalance',
            @json($unb),
            '#f59e0b'
        );

        makeChart(
            'chartDeviasi',
            @json($dev),
            '#ef4444'
        );

        function exportTableToExcel() {

            const table =
                document.querySelector("table");

            const wb =
                XLSX.utils.table_to_book(
                    table, {
                        sheet: "Monitoring"
                    }
                );

            XLSX.writeFile(
                wb,
                "monitoring.xlsx"
            );

        }
    </script>

</body>

</html>