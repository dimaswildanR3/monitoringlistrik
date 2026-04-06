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
    </style>
</head>
<body>

<div class="header">
    <b>⚡ Audit Energi Kelistrikan</b>

    <div class="menu">
        <a href="/">Dashboard</a>
        <a href="/evaluasi">Evaluasi</a>
    </div>
</div>

<div class="container">

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

    <tbody>
    @foreach($data as $d)
    <tr>
        <td>{{ $d->id_device }}</td>
        <td>{{ $d->waktu_log }}</td>

        <td class="{{ $d->status_thdv ? 'ok' : 'bad' }}">
            {{ $d->status_thdv ? 'Standar' : 'Tidak' }}
        </td>

        <td class="{{ $d->status_thdi ? 'ok' : 'bad' }}">
            {{ $d->status_thdi ? 'Standar' : 'Tidak' }}
        </td>

        <td class="{{ $d->status_unbalance ? 'ok' : 'bad' }}">
            {{ $d->status_unbalance ? 'Standar' : 'Tidak' }}
        </td>

        <td class="{{ $d->status_deviasi ? 'ok' : 'bad' }}">
            {{ $d->status_deviasi ? 'Standar' : 'Tidak' }}
        </td>

        <td class="{{ $d->status_pf ? 'ok' : 'bad' }}">
            {{ $d->status_pf ? 'Standar' : 'Tidak' }}
        </td>

        <td class="{{ $d->audit ? 'ok' : 'bad' }}">
            {{ $d->audit ? 'NORMAL' : 'TIDAK NORMAL' }}
        </td>
    </tr>
    @endforeach
</tbody>
</table>

</div>

</body>
</html>