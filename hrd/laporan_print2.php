<?php
include '../koneksi.php';

$date1 = $_GET['mulai'];
$date2 = $_GET['sampai'];
if (!empty($date1) && !empty($date2)) {
	// perintah tampil data berdasarkan range tanggal
	$query_tampil = mysqli_query($koneksi, "SELECT users.*, pelamars.*, lamarans.*, lowongans.*
	FROM users
	JOIN pelamars
	ON pelamars.id_user=users.id_user
	JOIN lamarans
	ON lamarans.id_pelamar=pelamars.id_pelamar
	JOIN lowongans
	ON lowongans.id_lowongan=lamarans.id_lowongan
	WHERE lamarans.keputusan='Diterima'
	AND lamarans.tgl_lamaran BETWEEN '$date1' and '$date2' ORDER BY tgl_lamaran ASC");
} else {
	// perintah tampil semua data
	$query_tampil = mysqli_query($koneksi, "SELECT users.*, pelamars.*, lamarans.*, lowongans.*
	FROM users
	JOIN pelamars
	ON pelamars.id_user=users.id_user
	JOIN lamarans
	ON lamarans.id_pelamar=pelamars.id_pelamar
	JOIN lowongans
	ON lowongans.id_lowongan=lamarans.id_lowongan
	WHERE lamarans.keputusan='Diterima'");
}

?>
<!DOCTYPE html>
<html>

<head>
	<link rel="icon" type="image/x-icon" href="../assets/img/logo ciomas.jpg">
	<title>HRD - Cetak Laporan Pelamar</title>
	<style type="text/css">
		table {
			border-style: double;
			border-width: 3px;
			border-color: white;
		}

		table tr .text2 {
			text-align: right;
			font-size: 13px;
		}

		table tr .text {
			text-align: center;
			font-size: 15px;
		}

		table tr td {
			font-size: 15px;
		}

		th,
		td {
			padding: 10px;
			text-align: left;
		}

		#t01 {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>

<body>
	<center>
		<table>
			<tr>
				<td><img src="https://kompaskerja.com/wp-content/uploads/2019/09/logo-japfa-630x380.jpg" width="90"
						height="90"></td>
				<td>
					<center>
						<font size="5">PT Ciomas Adisatwa Yogakarta</font><br>
						<font size="2">Alamat : Madurejo, Kec. Prambanan, Kabupaten Sleman, Daerah Istimewa Yogyakarta
						</font><br>
						<font size="2"><i>Phone/Fax : 08XX-XXXX-XXXX </i></font>
					</center>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr>
				</td>
			</tr>
	</center>
	<table>
		<h2>Laporan Lulus Administrasi</h2>
	</table>
	<table width="625" id="t01">
		<thead id="t01">
			<tr>
				<th width="2%" id="t01">No</th>
				<th width="20%" id="t01">Nama Pelamar</th>
				<th width="40%" id="t01">Nama Lowongan</th>
				<th width="43%" id="t01">Tanggal Lamaran</th>
				<th width="10%" id="t01">Status Lamaran</th>
			</tr>
		</thead>
		<tbody id="t01">
			<?php
			$no = 1; //nilai awal nomer
			while ($data_cek = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
				?>
				<tr>
					<td id="t01"><?php echo $no; ?>.</td>

					<td id="t01"><?php echo $data_cek['nama']; ?></td>
					<td id="t01">
						<?php echo $data_cek['nama_lowongan']; ?>
					</td>

					<?php $tanggal = $data_cek['tgl_lamaran']; ?>
					<td id="t01"><?php echo tgl_indo(date($tanggal)); ?></td>
					<td id="t01"><?php echo $data_cek['keputusan']; ?></td>
				</tr>
				<?php
				//auto increment nomer
				$no++;
			}
			?>
		</tbody>
	</table>
	<br>
	</table>
	<table width="700">
		<tr><?php $tgl = date('Y-m-d'); ?>
			<td width="350" class="text"><br><br><br><br><br><br><br><br></td>
			<td width="370" class="text">Yogyakarta, <?php echo tgl_indo(date($tgl)); ?><br>HRD PT Ciomas Adisatwa
				Yogyakarta<br><br><br><br><br><br>Fergusto Orlando Cantona</td>
		</tr>
	</table>
	<script>
		//perintah untuk cetak di browser
		window.print();
	</script>
</body>

</html>
<?php
function tgl_indo($tanggal)
{
	$bulan = array(
		1 => 'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
?>