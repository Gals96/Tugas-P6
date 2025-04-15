<?php
session_start();

$bandaraAsal = [
    1 => ["nama" => "Soekarno Hatta", "pajak" => 65000],
    2 => ["nama" => "Husein Sastranegara", "pajak" => 50000],
    3 => ["nama" => "Abdul Rachman Saleh", "pajak" => 40000],
    4 => ["nama" => "Juanda", "pajak" => 30000]
];

$bandaraTujuan = [
    1 => ["nama" => "Ngurah Rai", "pajak" => 85000],
    2 => ["nama" => "Hasanuddin", "pajak" => 70000],
    3 => ["nama" => "Inanwatan", "pajak" => 90000],
    4 => ["nama" => "Sultan Iskandar Muda", "pajak" => 60000]
];

$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 'form';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMaskapai = htmlspecialchars($_POST["nama_maskapai"]);
    $asalId = (int)$_POST["bandara_asal"];
    $tujuanId = (int)$_POST["bandara_tujuan"];
    $hargaTiket = (int)$_POST["harga_tiket"];

    $nomorPenerbangan = "FL" . rand(1000, 9999);
    $tanggal = date("d-m-Y");
    
    $pajakAsal = $bandaraAsal[$asalId]["pajak"];
    $pajakTujuan = $bandaraTujuan[$tujuanId]["pajak"];
    $pajak = $pajakAsal + $pajakTujuan;
    $totalHarga = $hargaTiket + $pajak;
    
    $_SESSION['hasil'] = [
        'nomorPenerbangan' => $nomorPenerbangan,
        'tanggal' => $tanggal,
        'namaMaskapai' => $namaMaskapai,
        'asalId' => $asalId,
        'tujuanId' => $tujuanId,
        'hargaTiket' => $hargaTiket,
        'pajakAsal' => $pajakAsal,
        'pajakTujuan' => $pajakTujuan,
        'pajak' => $pajak,
        'totalHarga' => $totalHarga
    ];

    header("Location: ?halaman=hasil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Rute Penerbangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #2196F3;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #0b7dda;
        }
        .result {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php if ($halaman == 'form'): ?>
        <h1>Pendaftaran Rute Penerbangan</h1>
        
        <form method="post">
            <div class="form-group">
                <label for="nama_maskapai">Nama Maskapai:</label>
                <input type="text" id="nama_maskapai" name="nama_maskapai" required>
            </div>
            
            <div class="form-group">
                <label for="bandara_asal">Bandara Asal:</label>
                <select id="bandara_asal" name="bandara_asal" required>
                    <option value="">-- Pilih Bandara Asal --</option>
                    <?php foreach ($bandaraAsal as $id => $bandara): ?>
                        <option value="<?php echo $id; ?>"><?php echo $bandara["nama"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="bandara_tujuan">Bandara Tujuan:</label>
                <select id="bandara_tujuan" name="bandara_tujuan" required>
                    <option value="">-- Pilih Bandara Tujuan --</option>
                    <?php foreach ($bandaraTujuan as $id => $bandara): ?>
                        <option value="<?php echo $id; ?>"><?php echo $bandara["nama"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="harga_tiket">Harga Tiket (Rp):</label>
                <input type="number" id="harga_tiket" name="harga_tiket" min="0" required>
            </div>
            
            <button type="submit">Proses Data</button>
        </form>
    
    <?php elseif ($halaman == 'hasil' && isset($_SESSION['hasil'])): ?>
        <?php 
        $hasil = $_SESSION['hasil'];
        $asalId = $hasil['asalId'];
        $tujuanId = $hasil['tujuanId'];
        ?>
        
        <h1>Hasil Pendaftaran Penerbangan</h1>
        
        <div class="result">
            <table>
                <tr>
                    <th colspan="2">Data Penerbangan</th>
                </tr>
                <tr>
                    <td>Nomor Penerbangan</td>
                    <td><?php echo $hasil['nomorPenerbangan']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><?php echo $hasil['tanggal']; ?></td>
                </tr>
                <tr>
                    <td>Maskapai</td>
                    <td><?php echo $hasil['namaMaskapai']; ?></td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <th colspan="2">Detail Rute & Biaya</th>
                </tr>
                <tr>
                    <td>Asal</td>
                    <td><?php echo $bandaraAsal[$asalId]["nama"]; ?></td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td><?php echo $bandaraTujuan[$tujuanId]["nama"]; ?></td>
                </tr>
                <tr>
                    <td>Harga Tiket</td>
                    <td>Rp <?php echo number_format($hasil['hargaTiket'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Pajak</td>
                    <td>Rp <?php echo number_format($hasil['pajak'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>Rp <?php echo number_format($hasil['totalHarga'], 0, ',', '.'); ?></td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <th colspan="2">Rincian Pajak</th>
                </tr>
                <tr>
                    <td>Pajak <?php echo $bandaraAsal[$asalId]["nama"]; ?></td>
                    <td>Rp <?php echo number_format($hasil['pajakAsal'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Pajak <?php echo $bandaraTujuan[$tujuanId]["nama"]; ?></td>
                    <td>Rp <?php echo number_format($hasil['pajakTujuan'], 0, ',', '.'); ?></td>
                </tr>
            </table>
            
            <a href="?halaman=form"><button class="back-button">Kembali ke Form</button></a>
        </div>
    
    <?php else: ?>
        <h1>Error: Data tidak ditemukan</h1>
        <p>Silakan kembali ke halaman form untuk melakukan pendaftaran.</p>
        <a href="?halaman=form"><button class="back-button">Kembali ke Form</button></a>
    <?php endif; ?>
</body>
</html>