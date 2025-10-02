<?php
include 'inc/db.php';
//-- query data from database
$sql='SELECT * FROM tbl_personalities ORDER BY no ASC';
$result=$db->query($sql);
$x=array();
$no=0;
while($row=$result->fetch_object()){
  if($no!=$row->no){
    $no=$row->no;
    $x[$no]=array();
  }
  $x[$no][]=$row;
}
$data=array();
foreach($x as $dt){
  foreach($dt as $d){
    $data[]=$d;
  }
}
?>
<!doctype html>
<html>
<head>
    <title>DISC Personality Test</title>
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='css/style.css?<?php echo md5(date('r'));?>' />
    <style>
        .loader {
            border: 16px solid #f3f3f3; 
            border-top: 16px solid #6a11cb;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="loader"></div>
<header class="header">
    <img src="img/home.png" alt="Home" class="home-icon">
    <h1>DISC Personality Test</h1>
</header>
<div class='container'>
    <div class='info-box'>
        <b>INSTRUKSI</b> : Setiap nomor di bawah ini memuat 4 (empat) kalimat. Tugas anda adalah : <br />
        <ol>
            <li>Beri tanda/cek pada kolom di bawah huruf  [P] di samping kalimat yang PALING menggambarkan diri anda</li>
            <li>Beri tanda/cek pada kolom di bawah huruf  [K] di samping kalimat yang PALING TIDAK menggambarkan diri anda</li>
        </ol>
        <br />
        <b>PERHATIKAN</b> : Setiap nomor hanya ada 1 (satu) tanda/cek di bawah masing-masing kolom P dan K.<br />
    </div>
    <form method='post' action='result.php' id="discForm">
        <?php
        for($i=0; $i<24; $i++) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-header'><b>Pertanyaan ".($i+1)."</b></div>";
            echo "<div class='card-body'>";
            for($j=0; $j<4; $j++) {
                $no = $i * 4 + $j;
                if(isset($data[$no])) {
                    echo "<div class='question-row'>";
                    echo "<div class='question-text'>{$data[$no]->term}</div>";
                    echo "<div class='radio-group'>";
                    echo "<div class='form-check'><input class='form-check-input' type='radio' name='m[{$i}]' value='{$data[$no]->most}' required> <label class='form-check-label'>P</label></div>";
                    echo "<div class='form-check'><input class='form-check-input' type='radio' name='l[{$i}]' value='{$data[$no]->least}' required> <label class='form-check-label'>K</label></div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
        <div class="text-center">
            <button type='submit' class='btn btn-primary btn-lg'>Proses</button>
        </div>
    </form>
</div>
<footer>copyright &copy; 2025<?php echo (date('Y')>2016?'-'.date('Y'):'');?> by <a href='mailto:kautsarrabdal@gmail.com'>TheRabdal</a></footer>
<script>
    document.getElementById('discForm').addEventListener('submit', function() {
        document.querySelector('.loader').style.display = 'block';
    });
</script>
</body>
</html>