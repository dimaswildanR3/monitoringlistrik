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
        display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 15px;
        flex-wrap: wrap; /* agar responsive */
    }

    .chart-box {
        flex: 1;
        min-width: 300px; /* supaya tidak terlalu kecil di mobile */
        height: 300px;    /* sedikit lebih kecil agar pas di HP */
    }

    .charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 15px;
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
    $power = [];
    $energy = [];
    $thdi = [];
$unb = [];
$dev = [];
$pf = [];

    foreach($data as $d){
        $labels[] = \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y H:i');
        $vmean[] = (float)$d->vmean;
        $imean[] = (float)$d->imean;
        $power[] = (float)$d->pw;
        $energy[] = (float)$d->ener;
        $thdv[] = (float)($d->thdv ?? 0);
    $thdi[] = (float)($d->thdi ?? 0);
    $unb[] = (float)$d->unbalance;
    $dev[] = (float)$d->deviasi;
    $pf[] = (float)$d->pf;
    }




@endphp

 

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

            <tbody id="tableBody">
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
        <div id="pagination" style="margin-top:10px;"></div>
    </div>
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

    <div class="charts-row">
    <!-- Power -->
    <div class="box chart-box">
        <h3>Power (kW)</h3>
        <canvas id="chartPower"></canvas>
    </div>

    <!-- Energy -->
    <div class="box chart-box">
        <h3>Energy (kWh)</h3>
        <canvas id="chartEnergy"></canvas>
    </div>
</div>

<div class="charts-row">
    <div class="box chart-box">
        <h3>THD Voltage (%)</h3>
        <canvas id="chartTHDV"></canvas>
    </div>

    <div class="box chart-box">
        <h3>THD Current (%)</h3>
        <canvas id="chartTHDI"></canvas>
    </div>
</div>

<div class="charts-row">
    <div class="box chart-box">
        <h3>Unbalance (%)</h3>
        <canvas id="chartUnbalance"></canvas>
    </div>

    <div class="box chart-box">
        <h3>Deviasi (%)</h3>
        <canvas id="chartDeviasi"></canvas>
    </div>
</div>

<div class="charts-row" style="justify-content:center;">
    <div class="box chart-box" style="max-width:47%;">
        <h3>Power Factor (PF)</h3>
        <canvas id="chartPF"></canvas>
    </div>
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

// POWER
const ctxP = document.getElementById('chartPower').getContext('2d');
new Chart(ctxP, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Power (kW)',
            data: @json($power),
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// ENERGY
const ctxE = document.getElementById('chartEnergy').getContext('2d');
new Chart(ctxE, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Energy (kWh)',
            data: @json($energy),
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

new Chart(document.getElementById('chartTHDV'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'THDV (%)',
            data: @json($thdv),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

new Chart(document.getElementById('chartTHDI'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'THDI (%)',
            data: @json($thdi),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

new Chart(document.getElementById('chartUnbalance'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Unbalance (%)',
            data: @json($unb),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

new Chart(document.getElementById('chartDeviasi'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Deviasi (%)',
            data: @json($dev),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

new Chart(document.getElementById('chartPF'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Power Factor',
            data: @json($pf),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

// auto refresh
setTimeout(() => { location.reload(); }, 10000);

const rowsPerPage = 10;
const table = document.getElementById("tableBody");
const rows = Array.from(table.querySelectorAll("tr"));

let currentPage = parseInt(localStorage.getItem("page")) || 1;
function getTotalPages() {
    return Math.ceil(rows.length / rowsPerPage);
}
// tampilkan data sesuai page
function showPage(page) {
    currentPage = page;
    localStorage.setItem("page", page);

    rows.forEach((row, index) => {
        row.style.display =
            (index >= (page - 1) * rowsPerPage &&
             index < page * rowsPerPage)
            ? ""
            : "none";
    });

    renderPagination();
}

// render tombol pagination
function renderPagination() {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    const totalPages = getTotalPages();

    // PREV
    if (currentPage > 1) {
        const prev = document.createElement("button");
        prev.innerText = "Prev";
        prev.onclick = () => showPage(currentPage - 1);
        pagination.appendChild(prev);
    }

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.innerText = i;

        if (i === currentPage) {
            btn.style.background = "#2c3e50";
            btn.style.color = "white";
        }

        btn.onclick = () => showPage(i);
        pagination.appendChild(btn);
    }

    // NEXT
    if (currentPage < totalPages) {
        const next = document.createElement("button");
        next.innerText = "Next";
        next.onclick = () => showPage(currentPage + 1);
        pagination.appendChild(next);
    }
}

// init
showPage(parseInt(currentPage));
</script>

</body>
</html>