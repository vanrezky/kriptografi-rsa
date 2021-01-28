<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>

<body>
    <h2 class="text-center"><?= $title; ?></h2>
    <h4 class="text-center"><?= $tgl; ?></h4>
    <table id="table">
        <tr>
            <th width="10mm">No.</th>
            <th>Identitas Pasien</th>
            <th>Tanggal Berobat</th>
            <th>Gejala</th>
            <th>Obat</th>
            <th>Dokter/Perawat</th>
        </tr>
        <?php
        if (empty($data)) {
            echo "<tr><td colspan='6' class='text-center'>Tidak ada data ditemukan!</td></tr>";
        } else {
            $no = 1;
            foreach ($data as $key => $value) {
                echo "<tr >";
                echo "<td class='text-center'>$no</td>";
                echo "<td>" . ucwords($value['nama_pasien']) . "<br/>
                                            <small><i>Kode Pasien : $value[kode_pasien], TB: $value[tb], BB: $value[bb], TD: $value[td]/120</i></small>
                                        </td>";
                echo "<td class='text-center'>" . format_hari_tanggal($value['tgl_berobat']) . "</td>";
                echo "<td class='text-center'>" . decode_rsa($value['gejala'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                echo "<td class='text-center'>" . decode_rsa($value['obat'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                echo "<td>Dokter: " . (!empty($value['id_dokter']) ? ucfirst($value['nama_dokter']) : '-') . "<br/>
                                                  Perawat/Bidan:" .  (!empty($value['id_pb']) ? ucfirst($value['nama']) : '-') . "
                                            </td>";
                echo "</tr>";
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