<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Audit Energi Kelistrikan</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            background: #2c3e50;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
        }

        .menu a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #34495e;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .ok { color: green; font-weight: bold; }
        .bad { color: red; font-weight: bold; }

        #pagination {
            margin-top: 15px;
            text-align: center;
        }

        #pagination button {
            margin: 2px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="header">
    <b>⚡ Audit Energi Kelistrikan</b>

    <div class="menu">
        <a href="/">Dashboard</a>
        <a href="/hasil">Evaluasi</a>
    </div>
</div>

<div class="container">

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
        <td>{{ \Carbon\Carbon::parse($d->waktu_log)->format('d-m-Y H:i:s') }}</td>

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

<div id="pagination"></div>

</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
function exportTableToExcel() {
    const table = document.querySelector("table");
    const clonedTable = table.cloneNode(true);

    const wb = XLSX.utils.table_to_book(clonedTable, {
        sheet: "Audit Energi"
    });

    const today = new Date();
    const fileName =
        "audit_energi_" +
        today.getFullYear() + "-" +
        (today.getMonth() + 1) + "-" +
        today.getDate() + ".xlsx";

    XLSX.writeFile(wb, fileName);
}

/* ================= PAGINATION ================= */

const rowsPerPage = 10;
const tableBody = document.getElementById("tableBody");
const rows = Array.from(tableBody.querySelectorAll("tr"));

let currentPage = 1;

function getTotalPages() {
    return Math.ceil(rows.length / rowsPerPage);
}

function showPage(page) {
    currentPage = page;

    rows.forEach((row, index) => {
        row.style.display =
            (index >= (page - 1) * rowsPerPage &&
             index < page * rowsPerPage)
            ? ""
            : "none";
    });

    renderPagination();
}

function renderPagination() {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    const totalPages = getTotalPages();

    function btn(label, page, active = false) {
        const b = document.createElement("button");
        b.innerText = label;

        if (active) {
            b.style.background = "#2c3e50";
            b.style.color = "white";
        }

        b.onclick = () => showPage(page);
        pagination.appendChild(b);
    }

    // Prev
    if (currentPage > 1) btn("Prev", currentPage - 1);

    // page 1
    btn(1, 1, currentPage === 1);

    let start = Math.max(2, currentPage - 1);
    let end = Math.min(totalPages - 1, currentPage + 1);

    if (start > 2) {
        const dots = document.createElement("span");
        dots.innerText = "...";
        pagination.appendChild(dots);
    }

    for (let i = start; i <= end; i++) {
        btn(i, i, currentPage === i);
    }

    if (end < totalPages - 1) {
        const dots = document.createElement("span");
        dots.innerText = "...";
        pagination.appendChild(dots);
    }

    if (totalPages > 1) {
        btn(totalPages, totalPages, currentPage === totalPages);
    }

    // Next
    if (currentPage < totalPages) btn("Next", currentPage + 1);
}

// init
showPage(1);

</script>

</body>
</html>