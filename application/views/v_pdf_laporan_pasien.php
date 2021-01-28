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
            <th>No.</th>
            <th>Identitas Pasien</th>
            <th>Kode Pasien</th>
            <th>Kategori</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>No Hp</th>
        </tr>
        <?php
        if (empty($data)) {
            echo "<tr><td colspan=20 class='text-center'>Tidak ada data ditemukan!</td></tr>";
        } else {
            $no = 1;
            foreach ($data as $key => $value) {
                echo "<tr >";
                echo "<td class='text-center'>$no</td>";
                echo "<td>$value[nama_pasien]<br/>
                    <small><strong>NIK : " . decode_rsa($value['nik'], $rsa_key['d'], $rsa_key['n']) . " | $value[alamat]</strong></small>
                </td>";
                echo "<td class='text-center'>$value[kode_pasien]</td>";
                echo "<td>$value[kategori]</td>";
                echo "<td class='text-center'>$value[umur] tahun</td>";
                echo "<td>$value[jenis_kelamin]</td>";
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