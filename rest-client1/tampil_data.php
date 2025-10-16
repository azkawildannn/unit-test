<?php
	//memasukan file config
	include("config.php");

	//url untuk lihat data
	$url="http://localhost/ppl-azka/rest-api/tampil_data.php";
	//menyimpan hasil dalam variabel
	$data=http_request_get($url);

	//konversi data json ke array
	$hasil=json_decode($data,true);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pengurus dengan RestAPI</title>
</head>
<body>
    <h1>Data Pengurus dengan RestAPI</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>GENDER</th>
            <th>GAJI</th>
            <th>AKSI</th>
        </tr>

        <?php
        if (isset($hasil['pengurus'])) {
            foreach ($hasil['pengurus'] as $r) {
                echo "<tr>
                    <td>{$r['id']}</td>
                    <td>{$r['nama']}</td>
                    <td>{$r['alamat']}</td>
                    <td>{$r['gender']}</td>
                    <td>{$r['gaji']}</td>
                    <td>
                        <a href='edit_data.php?id={$r['id']}'>Edit</a> |
                        <a href='hapus_data.php?id={$r['id']}'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Data tidak ditemukan.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
