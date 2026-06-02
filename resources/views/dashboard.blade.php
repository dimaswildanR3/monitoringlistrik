<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Energy IoT</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    body {
        font-family: Arial;
        background: #f4f6f9;
        margin: 0;
    }

    .header {
        background: #2c3e50;
        padding: 15px 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .menu a {
        color: white;
        margin-left: 15px;
        text-decoration: none;
        display: inline-block;
        margin-top: 5px;
    }

    .container {
        padding: 20px;
    }

    .box {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    th {
        background: #34495e;
        color: white;
        padding: 8px;
    }

    td {
        padding: 8px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    h2, h3 {
        margin-bottom: 10px;
        font-size: 1.2em;
    }

    /* =========================
       FIX: FULL WIDTH CHART
    ========================= */
    .charts-row {
        display: block;
    }

    .chart-box {
        width: 100%;
        height: 360px;
        margin-bottom: 20px;
    }

    canvas {
        width: 100% !important;
        height: 100% !important;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
        }

        .menu a {
            margin-left: 0;
            margin-top: 5px;
        }

        .container {
            padding: 15px;
        }
    }

    </style>
</head>

<body>

<div class="header">
    <b>⚡ Monitoring Energy IoT</b>

    <div class="menu">
        <a href="/">Dashboard</a>
        <a href="/hasil">Evaluasi</a>
    </div>
</div>

<div class="container">

<h2>📊 Grafik Monitoring</h2>

@php
$labels=[];$vmean=[];$imean=[];
$energy=[];$thdv=[];$thdi=[];
$unb=[];$dev=[];$pf=[];

foreach($data as $d){
    $labels[] = \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y H:i');
    $vmean[] = (float)$d->vmean;
    $imean[] = (float)$d->imean;
    $energy[] = (float)$d->ener;
    $thdv[] = (float)($d->thdv ?? 0);
    $thdi[] = (float)($d->thdi ?? 0);
    $unb[] = (float)$d->unbalance;
    $dev[] = (float)$d->deviasi;
    $pf[] = (float)$d->pf;
}
@endphp


<!-- TABLE (TETAP) -->
<div class="box">
    <h2>📋 Data Monitoring Energi</h2>

    <table>
        <thead>
        <tr>
            <th>Device</th>
            <th>IR</th><th>IS</th><th>IT</th>
            <th>VRN</th><th>VSN</th><th>VTN</th>
            <th>VRS</th><th>VST</th><th>VTR</th>
            <th>V Mean</th>
            <th>Power (kW)</th>
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
            <td>{{ number_format($d->pw,2) }}</td>
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


<!-- CHARTS FULL WIDTH -->
<div class="charts-row">

    <div class="box chart-box">
        <h3>Voltage (V Mean)</h3>
        <canvas id="chartVoltage"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Current (I Mean)</h3>
        <canvas id="chartCurrent"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Energy (kWh)</h3>
        <canvas id="chartEnergy"></canvas>
    </div>

    <div class="box chart-box">
        <h3>THD Voltage (%)</h3>
        <canvas id="chartTHDV"></canvas>
    </div>

    <div class="box chart-box">
        <h3>THD Current (%)</h3>
        <canvas id="chartTHDI"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Unbalance (%)</h3>
        <canvas id="chartUnbalance"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Deviasi (%)</h3>
        <canvas id="chartDeviasi"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Power Factor</h3>
        <canvas id="chartPF"></canvas>
    </div>

</div>

</div>

<script>
function makeChart(id,label,data,color){
    new Chart(document.getElementById(id),{
        type:'line',
        data:{
            labels:@json($labels),
            datasets:[{
                label:label,
                data:data,
                borderColor:color,
                backgroundColor:color+'33',
                borderWidth:2,
                tension:0.3,
                fill:true
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });
}

// COLORFUL CHARTS (UPDATED)
makeChart('chartVoltage','Voltage',@json($vmean),'#3498db');
makeChart('chartCurrent','Current',@json($imean),'#2ecc71');
makeChart('chartEnergy','Energy',@json($energy),'#9b59b6');
makeChart('chartTHDV','THD Voltage',@json($thdv),'#e67e22');
makeChart('chartTHDI','THD Current',@json($thdi),'#e74c3c');
makeChart('chartUnbalance','Unbalance',@json($unb),'#1abc9c');
makeChart('chartDeviasi','Deviasi',@json($dev),'#f1c40f');
makeChart('chartPF','Power Factor',@json($pf),'#34495e');
</script>

</body>
</html>