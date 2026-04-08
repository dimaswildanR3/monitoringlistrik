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
        overflow-x: auto; /* agar tabel bisa scroll horizontal */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px; /* agar tabel scroll jika layar sempit */
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

    /* Flex container untuk dua grafik */
    .charts-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap; /* agar responsive */
    }

    .chart-box {
        flex: 1;
        min-width: 300px; /* supaya tidak terlalu kecil di mobile */
        height: 300px;    /* sedikit lebih kecil agar pas di HP */
    }

    @media (max-width: 768px) {
        .charts-row {
            flex-direction: column; /* grafik stack di HP */
        }

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
        $labels = [];
        $vmean = [];
        $imean = [];

        foreach($data as $d){
            // X-axis = tanggal
            $labels[] = \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y');
            $vmean[] = (float)$d->vmean;
            $imean[] = (float)$d->imean;
        }
    @endphp

    <!-- GRAFIK DUA KANVAS SEBELAH-SEBELAH -->
    <div class="charts-row">
        <!-- Grafik V Mean -->
        <div class="box chart-box">
            <h3>Voltage (V Mean)</h3>
            <canvas id="chartVoltage"></canvas>
        </div>

        <!-- Grafik I Mean -->
        <div class="box chart-box">
            <h3>Current (I Mean)</h3>
            <canvas id="chartCurrent"></canvas>
        </div>
    </div>

    <!-- TABLE -->
    <div class="box">
        <h2>📋 Data Monitoring Energi</h2>

        <table>
            <thead>
                <tr>
                    <th>Device</th>

                    <!-- ARUS -->
                    <th>IR</th>
                    <th>IS</th>
                    <th>IT</th>

                    <!-- TEGANGAN PER PHASE -->
                    <th>VRN</th>
                    <th>VSN</th>
                    <th>VTN</th>
                    <th>V Mean</th>

                    <!-- DAYA -->
                    <th>Power (kW)</th>
                    <th>Energy (kWh)</th>

                    <!-- PARAMETER -->
                    <th>THD V</th>
                    <th>THD I</th>
                    <th>Unbalance</th>
                    <th>Deviasi</th>
                    <th>PF</th>

                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>{{ $d->id_device }}</td>

                    <!-- ARUS -->
                    <td>{{ number_format($d->ir,2) }}</td>
                    <td>{{ number_format($d->is,2) }}</td>
                    <td>{{ number_format($d->it,2) }}</td>

                    <!-- TEGANGAN -->
                    <td>{{ number_format($d->vrn,2) }}</td>
                    <td>{{ number_format($d->vsn,2) }}</td>
                    <td>{{ number_format($d->vtn,2) }}</td>
                    <td>{{ number_format($d->vmean,2) }}</td>

                    <!-- DAYA -->
                    <td>{{ number_format($d->pw,2) }}</td>
                    <td>{{ number_format($d->ener,2) }}</td>

                    <!-- PARAMETER -->
                    <td>{{ number_format($d->thdv ?? 0,2) }}%</td>
                    <td>{{ number_format($d->thdi ?? 0,2) }}%</td>
                    <td>{{ number_format($d->unbalance,2) }}%</td>
                    <td>{{ number_format($d->deviasi,2) }}%</td>
                    <td>{{ number_format($d->pf,2) }}</td>

                    <td>{{ $d->waktu_log }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- SCRIPT GRAFIK -->
<script>
const ctxV = document.getElementById('chartVoltage').getContext('2d');
new Chart(ctxV, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Voltage (V Mean)',
            data: @json($vmean),
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top' } },
        scales: {
            x: { title: { display: true, text: 'Tanggal' } },
            y: { title: { display: true, text: 'V Mean' }, beginAtZero: false }
        }
    }
});

const ctxI = document.getElementById('chartCurrent').getContext('2d');
new Chart(ctxI, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Current (I Mean)',
            data: @json($imean),
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top' } },
        scales: {
            x: { title: { display: true, text: 'Tanggal' } },
            y: { title: { display: true, text: 'I Mean' }, beginAtZero: false }
        }
    }
});

// auto refresh
setTimeout(() => { location.reload(); }, 10000);
</script>

</body>
</html>