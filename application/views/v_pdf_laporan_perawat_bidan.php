<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>

<body>
    <h2 class="text-center"><?= $title; ?></h2>
    <table id="table">
        <tr>
            <th width="10mm">No.</th>
            <th>Nama Perawat/Bidan</th>
            <th>NIP</th>
            <th>Pekerjaan</th>
            <th>No Hp</th>
        </tr>
        <?php
        if (empty($data)) {
            echo "<tr><td colspan=20 class='text-center'>Tidak ada data ditemukan!</td></tr>";
        } else {
            $no = 1;
            foreach ($data as $key => $value) {
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>" . $value['nama'] . "</td>";
                echo "<td>" . $value['pekerjaan'] . "</td>";
                echo "<td>" . decode_rsa($value['nip'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                echo "<td>" . decode_rsa($value['no_hp'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                $no++;
            }
        }
        ?>
    </table>

</body>
<style>
    h2 {
        font-family: Arial, Helvetica, sans-serif;
    }

    #table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table td,
    #table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table tr:hover {
        background-color: #ddd;
    }

    #table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    .text-center {
        text-align: center;
    }
</style>

</html>