<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evaluasi Audit Energi</title>

    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
        }

        /* ================= TOPBAR ================= */

        .topbar {

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
            height: 40px;
        }

        .brand h2 {
            font-size: 24px;
        }

        .menu {

            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu a {

            color: white;
            text-decoration: none;

            padding: 10px 18px;

            border-radius: 8px;

        }

        .active {

            background: #0d5eff;

        }

        .logoRight {
            height: 45px;
        }


        /* ================= CONTENT ================= */

        .container {

            padding: 25px;

        }


        /* ================= HEADER ================= */

        .pageHeader {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;

        }

        .pageTitle {

            display: flex;
            align-items: center;
            gap: 15px;

        }

        .iconHeader {

            width: 55px;
            height: 55px;
            border-radius: 12px;
            background: white;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);

            font-size: 25px;
            /* color: #0d5eff; */

        }

        .pageTitle h1 {

            font-size: 35px;
            color: #0f1f4f;

        }

        .pageTitle p {

            color: #666;

        }

        .online {

            display: flex;
            align-items: center;
            gap: 10px;

            color: green;
            font-weight: bold;

        }


        /* ================= FILTER ================= */

        .filterBox {

            background: white;
            padding: 20px;
            border-radius: 15px;

            display: grid;

            grid-template-columns:
                repeat(4, 1fr) 200px;

            gap: 15px;

            margin-bottom: 20px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, .05);

        }

        .filterItem {

            display: flex;
            flex-direction: column;
            gap: 6px;

        }

        .filterItem label {

            font-size: 14px;
            font-weight: bold;

        }

        .filterItem input,
        .filterItem select {

            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;

        }

        .btnBlue {

            background: #0d5eff;
            color: white;
            border: none;
            border-radius: 10px;

            cursor: pointer;
            font-weight: bold;

        }


        /* ================= CARDS ================= */

        /* pembungkus card */
        .cardWrapper {
            position: relative;
            margin-bottom: 25px;
        }

        /* card ditengah */
        .cardGrid {
            position: relative;
            z-index: 2;

            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* card */
        .card {
            background: white;
            padding: 20px 25px;
            border-radius: 15px;

            display: flex;
            align-items: center;
            gap: 15px;

            min-width: 260px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        /* shape background kecil */
        .shape {
            position: absolute;
            background: #2979ff;
            opacity: .08;
            border-radius: 15px;
            z-index: 1;
        }

        .shape1 {
            width: 90px;
            height: 90px;

            top: -15px;
            left: 35%;

            transform: rotate(25deg);
        }

        .shape2 {
            width: 70px;
            height: 70px;

            right: 35%;
            bottom: -10px;

            transform: rotate(-25deg);
        }

        .card {

            background: white;
            padding: 20px;

            border-radius: 15px;

            display: flex;
            gap: 15px;
            align-items: center;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

        }

        .circle {

            width: 65px;
            height: 65px;
            border-radius: 50%;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 28px;
            font-weight: bold;

            color: white;

        }

        .green {
            background: #1db954;
        }

        .blue {
            background: #2979ff;
        }

        .orange {
            background: #ff9800;
        }

        .red {
            background: #ff4444;
        }

        .purple {
            background: #9c27b0;
        }

        .card h3 {

            font-size: 32px;
            margin-top: 5px;

        }

        .card small {
            color: #666;
        }


        /* ================= MIDDLE ================= */

        .middle {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 20px;

            margin-bottom: 20px;

        }

        .box {

            background: white;
            padding: 25px;
            border-radius: 15px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

        }

        .progress {

            height: 10px;
            background: #eee;
            border-radius: 20px;

            margin: 15px 0;

            overflow: hidden;

        }

        .fill {

            height: 100%;
            background: #1db954;

        }

        .rekomendasi {

            margin-top: 20px;

            padding: 15px;

            background: #ecfff2;

            border-radius: 10px;

            border: 1px solid #8ed9a6;

        }


        /* ================= TABLE ================= */

        .tableCard {

            background: white;
            padding: 20px;

            border-radius: 15px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

        }

        .tableHeader {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 15px;

        }

        table {

            width: 100%;
            border-collapse: collapse;

        }

        th {

            background: #00144e;
            color: white;
            padding: 15px;

        }

        td {

            padding: 15px;
            border-bottom: 1px solid #eee;

            text-align: center;

        }

        .badge {

            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;

        }

        .badgeGreen {
            background: #eafaf0;
            color: #1db954;
        }

        .badgeOrange {
            background: #fff3e0;
            color: #ff9800;
        }

        .badgeRed {
            background: #ffe9e9;
            color: red;
        }

        .buttonArea {

            margin-top: 20px;

            display: flex;
            justify-content: flex-end;
            gap: 10px;

        }

        .excelBtn {

            padding: 12px 18px;
            border: none;
            border-radius: 8px;

            background: #16a34a;
            color: white;
            font-weight: bold;

            cursor: pointer;

        }

        .downloadBtn {

            padding: 12px 18px;
            border: none;
            border-radius: 8px;

            background: #0d5eff;
            color: white;
            font-weight: bold;

            cursor: pointer;

        }

        #pagination {

            margin-top: 20px;
            text-align: center;

        }

        #pagination button {

            padding: 8px 12px;
            margin: 3px;

            border: none;
            border-radius: 5px;
            cursor: pointer;

        }

        .activePage {

            background: #0d5eff;
            color: white;

        }

        .pagination-custom {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination-custom a,
        .pagination-custom span {
            min-width: 42px;
            height: 42px;
            padding: 0 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            border: 1px solid #d0d7e2;
            background: #fff;
            color: #002a72;
            font-weight: 600;
        }

        .pagination-custom a:hover {
            background: #002a72;
            color: #fff;
        }

        .pagination-custom .active {
            background: #002a72;
            color: #fff;
            border-color: #002a72;
        }

        .pagination-custom .disabled {
            color: #999;
            background: #f3f4f6;
        }

        .pagination-custom .dots {
            padding: 0 10px;
            font-weight: bold;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="topbar">

        <div class="brand">

            <img src="https://monitoringppns.com/2.png">

            <h2>Monitoring Energy IoT</h2>

        </div>

        <div class="menu">

            <a href="/">Dashboard</a>

            <a href="/hasil" class="active">
                <i class="fa-solid fa-chart-column"></i>
                Evaluasi
            </a>

            <img src="https://monitoringppns.com/1.png"
                class="logoRight">

        </div>

    </div>



    <div class="container">

        <div class="pageHeader">

            <div class="pageTitle">

                <div class="iconHeader">
                    <i class="fa-solid fa-wave-square"></i>
                </div>

                <div>

                    <h1>Evaluasi Audit Energi Kelistrikan</h1>

                    <p>
                        Ringkasan hasil audit kualitas daya
                    </p>

                </div>

            </div>

            <!-- <div class="online">

                🟢 Online

            </div> -->

        </div>



        <!-- <div class="filterBox">

            <div class="filterItem">

                <label>Device</label>

                <select>
                    <option>device_1</option>
                </select>

            </div>

            <div class="filterItem">

                <label>Tanggal</label>

                <input type="date">

            </div>

            <div class="filterItem">

                <label>Rentang Waktu</label>

                <select>
                    <option>60 Menit Terakhir</option>
                </select>

            </div>

            <button class="btnBlue">
                Terapkan Filter
            </button>

        </div> -->


        @php
        $totalData = $data->count();
        $totalNormal = $data->where('audit', 1)->count();
        $totalTidakNormal = $data->where('audit', '!=', 1)->count();

        $statusAudit = $totalTidakNormal == 0 ? 'NORMAL' : 'TIDAK NORMAL';
        $statusColor = $totalTidakNormal == 0 ? 'green' : 'red';
        $statusIcon = $totalTidakNormal == 0 ? '✓' : '✕';
        @endphp
        <div class="cardWrapper">

            <!-- shape kecil -->
            <div class="shape shape1"></div>
            <div class="shape shape2"></div>

            <div class="cardGrid">

                <!-- Status Audit -->
                <div class="card">

                    <div class="circle {{ $statusColor }}">
                        {{ $statusIcon }}
                    </div>

                    <div>
                        <small>Status Audit</small>

                        <h3 style="font-size:24px;white-space:nowrap;">
                            {{ $statusAudit }}
                        </h3>
                    </div>

                </div>

                <!-- Semua Data -->
                <div class="card">

                    <div class="circle blue">
                        <i class="fa-solid fa-database"></i>
                    </div>

                    <div>
                        <small>Jumlah Semua Data</small>
                        <h3>{{ $totalData }}</h3>
                    </div>

                </div>

            </div>

        </div>

        <div class="tableCard">

            <div class="tableHeader">

                <h2>Hasil Audit Energi</h2>

            </div>


            <table>

                <thead>

                    <tr>

                        <th>Device</th>
                        <th>Waktu</th>
                        <th>THD V</th>
                        <th>THD I</th>
                        <th>Unbalance</th>
                        <th>Deviasi</th>
                        <th>Power Factor</th>
                        <th>Audit Energi</th>

                    </tr>

                </thead>

                <tbody id="tableBody">

                    @foreach($data as $d)

                    <tr>
                        <td>{{ $d->id_device }}</td>
                        <td>{{ $d->created_at ? \Carbon\Carbon::parse($d->created_at)->format('d-m-Y H:i:s') : '-' }}</td>

                        <td class="{{ $d->status_thdv == 1 ? 'ok' : 'bad' }}">
                            {{ $d->status_thdv == 1 ? 'Standar' : 'Tidak' }}
                        </td>

                        <td class="{{ $d->status_thdi == 1 ? 'ok' : 'bad' }}">
                            {{ $d->status_thdi == 1 ? 'Standar' : 'Tidak' }}
                        </td>

                        <td class="{{ $d->status_unbalance == 1 ? 'ok' : 'bad' }}">
                            {{ $d->status_unbalance == 1 ? 'Standar' : 'Tidak' }}
                        </td>

                        <td class="{{ $d->status_deviasi == 1 ? 'ok' : 'bad' }}">
                            {{ $d->status_deviasi == 1 ? 'Standar' : 'Tidak' }}
                        </td>

                        <td class="{{ $d->status_pf == 1 ? 'ok' : 'bad' }}">
                            {{ $d->status_pf == 1 ? 'Standar' : 'Tidak' }}
                        </td>

                        <td class="{{ $d->audit == 1 ? 'ok' : 'bad' }}">
                            {{ $d->audit == 1 ? 'NORMAL' : 'TIDAK NORMAL' }}
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>


            <div class="buttonArea">

                <button
                    class="excelBtn"
                    onclick="exportTableToExcel()">

                    Export Excel

                </button>

                <!-- <button class="downloadBtn">

                    Unduh Laporan

                </button> -->

            </div>

            <div id="pagination"></div>
           @if ($data->hasPages())
<div class="pagination-custom">

    {{-- Previous --}}
    @if ($data->onFirstPage())
        <span class="disabled">« Previous</span>
    @else
        <a href="{{ $data->previousPageUrl() }}">« Previous</a>
    @endif

    {{-- Halaman pertama --}}
    @if($data->currentPage() > 3)
        <a href="{{ $data->url(1) }}">1</a>

        @if($data->currentPage() > 4)
            <span class="dots">...</span>
        @endif
    @endif

    {{-- Halaman sekitar current --}}
    @foreach(range(max(1, $data->currentPage()-1), min($data->lastPage(), $data->currentPage()+1)) as $page)
        @if($page == $data->currentPage())
            <span class="active">{{ $page }}</span>
        @else
            <a href="{{ $data->url($page) }}">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Halaman terakhir --}}
    @if($data->currentPage() < $data->lastPage()-2)

        @if($data->currentPage() < $data->lastPage()-3)
            <span class="dots">...</span>
        @endif

        <a href="{{ $data->url($data->lastPage()) }}">
            {{ $data->lastPage() }}
        </a>

    @endif

    {{-- Next --}}
    @if ($data->hasMorePages())
        <a href="{{ $data->nextPageUrl() }}">Next »</a>
    @else
        <span class="disabled">Next »</span>
    @endif

</div>
@endif
        </div>

    </div>

    <script>
        function exportTableToExcel() {

            const table = document.querySelector("table");

            const wb = XLSX.utils.table_to_book(
                table, {
                    sheet: "Audit Energi"
                }
            );

            XLSX.writeFile(
                wb,
                "audit_energi.xlsx"
            );

        }
    </script>

</body>

</html>