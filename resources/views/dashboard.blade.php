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

.filter-box {
    background: white;
    margin: 20px;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
}

.filter-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    min-width: 200px;
}

.filter-group label {
    font-size: 12px;
    margin-bottom: 5px;
    color: #555;
}

.filter-group input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    outline: none;
}

.filter-actions {
    display: flex;
    gap: 10px;
}

.btn-filter {
    background: #2c3e50;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.btn-filter:hover {
    background: #1a252f;
}

.btn-reset {
    background: #e74c3c;
    color: white;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
}

.btn-reset:hover {
    background: #c0392b;
}


    @media (max-width: 768px) {
        .filter-form {
        flex-direction: column;
    }

    .filter-group {
        width: 100%;
    }

    .filter-actions {
        width: 100%;
        justify-content: space-between;
    }
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
<!-- <div class="filter-box">
    <form method="GET" action="" class="filter-form">

        <div class="filter-group">
            <label>Dari</label>
            <input type="datetime-local" name="start" value="{{ request('start') }}">
        </div>

        <div class="filter-group">
            <label>Sampai</label>
            <input type="datetime-local" name="end" value="{{ request('end') }}">
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter">🔍 Filter</button>
            <a href="/" class="btn-reset">Reset</a>
        </div>

    </form>
</div> -->


    @php
    $labels = [];
    $vmean = [];
    $imean = [];
    $power = [];
    $energy = [];
    $thdi = [];
    $thdv = [];
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
        <div style="margin-bottom:15px;">
    <button onclick="exportTableToExcel()" 
        style="
            background:#27ae60;
            color:white;
            border:none;
            padding:10px 15px;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
        ">
        📥 Export Excel
    </button>
</div>
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
                

                    <!-- TEGANGAN LINE -->
                    <th>VRS</th>
                    <th>VST</th>
                    <th>VTR</th>

                    <th>V Mean</th>
                    <!-- DAYA -->
                    <th>Power (kW)</th>
                    <th>Energy (kWh)</th>

                    <!-- PARAMETER -->
                    <th>THD V</th>
                    <th>THD I</th>
                    <th>Freq (Hz)</th>
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

                    <td>{{ number_format($d->vrs,2) }}</td>
                    <td>{{ number_format($d->vst,2) }}</td>
                    <td>{{ number_format($d->vtr,2) }}</td>

                    <td>{{ number_format($d->vmean,2) }}</td>

                    <!-- DAYA -->
                    <td>{{ number_format($d->pw,2) }}</td>
                    <td>{{ number_format($d->ener,2) }}</td>

                    <!-- PARAMETER -->
                    <td>{{ number_format($d->thdv ?? 0,2) }}%</td>
                    <td>{{ number_format($d->thdi ?? 0,2) }}%</td>
                    <td>{{ number_format($d->freq,2) }}</td>
                    <td>{{ number_format($d->unbalance,2) }}%</td>
                    <td>{{ number_format($d->deviasi,2) }}%</td>
                    <td>{{ number_format($d->pf,2) }}</td>

                    <td>
    {{ \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y H:i:s') }}
</td>
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
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
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
// setTimeout(() => { location.reload(); }, 10000);

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

function exportTableToExcel() {

const table = document.querySelector("table");

// clone table supaya semua row tampil
const clonedTable = table.cloneNode(true);

clonedTable.querySelectorAll("tr").forEach(row => {
    row.style.display = "";
});

const wb = XLSX.utils.table_to_book(clonedTable, {
    sheet: "Monitoring Energy"
});

const today = new Date();

const fileName =
    "monitoring_energy_" +
    today.getFullYear() + "-" +
    (today.getMonth() + 1) + "-" +
    today.getDate() + ".xlsx";

XLSX.writeFile(wb, fileName);
}

function renderPagination() {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    const totalPages = getTotalPages();

    function createButton(label, page, active = false) {
        const btn = document.createElement("button");
        btn.innerText = label;

        if (active) {
            btn.style.background = "#2c3e50";
            btn.style.color = "white";
        }

        btn.onclick = () => showPage(page);
        pagination.appendChild(btn);
    }

    // PREV
    if (currentPage > 1) {
        createButton("Prev", currentPage - 1);
    }

    const maxVisible = 3; // jumlah angka yang ditampilkan di tengah

    // selalu tampilkan halaman 1
    createButton(1, 1, currentPage === 1);

    // titik awal range tengah
    let start = Math.max(2, currentPage - 1);
    let end = Math.min(totalPages - 1, currentPage + 1);

    // kalau ada gap di kiri → tampilkan ...
    if (start > 2) {
        const dots = document.createElement("span");
        dots.innerText = "...";
        dots.style.padding = "5px 10px";
        pagination.appendChild(dots);
    }

    // halaman tengah
    for (let i = start; i <= end; i++) {
        createButton(i, i, currentPage === i);
    }

    // kalau ada gap di kanan → tampilkan ...
    if (end < totalPages - 1) {
        const dots = document.createElement("span");
        dots.innerText = "...";
        dots.style.padding = "5px 10px";
        pagination.appendChild(dots);
    }

    // selalu tampilkan halaman terakhir (kalau > 1)
    if (totalPages > 1) {
        createButton(totalPages, totalPages, currentPage === totalPages);
    }

    // NEXT
    if (currentPage < totalPages) {
        createButton("Next", currentPage + 1);
    }
}
</script>

</body>
</html>