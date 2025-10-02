<?php
?>
<!doctype html>
<html>
<head>
    <title>DISC Personality Test Result</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='stylesheet' href='css/style.css?<?php echo md5(date('r'));?>' />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
</head>
<body>
<header class="header">
    <img src="img/home.png" alt="Home" class="home-icon">
    <h1>DISC Personality Result</h1>
</header>
<div class="container mt-4">
<?php
if(isset($_POST['m']) && isset($_POST['l'])){
  include 'inc/db.php';
  include 'inc/formula.php';
  $most=array_count_values($_POST['m']);
  $least=array_count_values($_POST['l']);
  $result=array();
  $aspect=array(
      'D' => '(Dominance) / Dominasi',
      'I' => '(Influence) / Pengaruh',
      'S' => '(Steadiness) / Kestabilan',
      'C' => '(Conscientiousness) / Ketelitian'
  );
  foreach($aspect as $key => $value){
    $result[$key][1]=isset($most[$key])?$most[$key]:0;
    $result[$key][2]=isset($least[$key])?$least[$key]:0;
    $result[$key][3]=($key!='N'?$result[$key][1]-$result[$key][2]:0);
  }
  $line1=getPattern($db,$result,1);
  $line2=getPattern($db,$result,2);
  $line3=getPattern($db,$result,3);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Result Graph</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="graph" style="height: 280px; width:100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Tally Box</div>
                <div class="card-body">
                    <?php
                    foreach($aspect as $key => $value){
                        echo "<div><strong>{$key} {$value}</strong></div>";
                        echo "<div class='progress mb-2'>";
                        echo "<div class='progress-bar' role='progressbar' style='width: ".($result[$key][1]*10)."%' aria-valuenow='{$result[$key][1]}' aria-valuemin='0' aria-valuemax='10'>MOST: {$result[$key][1]}</div>";
                        echo "</div>";
                        echo "<div class='progress mb-2'>";
                        echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".($result[$key][2]*10)."%' aria-valuenow='{$result[$key][2]}' aria-valuemin='0' aria-valuemax='10'>LEAST: {$result[$key][2]}</div>";
                        echo "</div>";
                        echo "<div class='progress mb-3'>";
                        echo "<div class='progress-bar bg-info' role='progressbar' style='width: ".(abs($result[$key][3])*10)."%' aria-valuenow='{$result[$key][3]}' aria-valuemin='-10' aria-valuemax='10'>CHANGE: {$result[$key][3]}</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion mt-4" id="resultAccordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-users"></i> Kepribadian di Muka Umum (Public Self)
                    </button>
                </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#resultAccordion">
                <div class="card-body">
                    <h3><?php echo $line1[1]->pattern; ?></h3>
                    <ul class="list-group list-group-flush"><?php echo "<li class='list-group-item'><i class='fas fa-check-circle'></i>".implode("</li><li class='list-group-item'><i class='fas fa-check-circle'></i>",explode(',',$line1[1]->behaviour))."</li>"; ?></ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-user-shield"></i> Kepribadian Saat Mendapat Tekanan (Core Self)
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#resultAccordion">
                <div class="card-body">
                    <h3><?php echo $line2[1]->pattern; ?></h3>
                    <ul class="list-group list-group-flush"><?php echo "<li class='list-group-item'><i class='fas fa-check-circle'></i>".implode("</li><li class='list-group-item'><i class='fas fa-check-circle'></i>",explode(',',$line2[1]->behaviour))."</li>"; ?></ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-user-secret"></i> Kepribadian Asli yang Tersembunyi (Mirror Self)
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#resultAccordion">
                <div class="card-body">
                    <h3><?php echo $line3[1]->pattern; ?></h3>
                    <p><?php echo $line3[1]->description; ?></p>
                    <h4><i class="fas fa-briefcase"></i> Job Match:</h4>
                    <ul class="list-group list-group-flush"><?php echo "<li class='list-group-item'><i class='fas fa-check'></i>".implode("</li><li class='list-group-item'><i class='fas fa-check'></i>",explode(',',$line3[1]->jobs))."</li>"; ?></ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
    $(function(){
      Morris.Line({
        element: 'graph',
        data: [
          <?php
          echo "
          { y: 'D', a: {$line1[0]->d}, b:{$line2[0]->d}, c:{$line3[0]->d}},
          { y: 'I', a: {$line1[0]->i},  b:{$line2[0]->i}, c:{$line3[0]->i}},
          { y: 'S', a: {$line1[0]->s},  b:{$line2[0]->s}, c:{$line3[0]->s}},
          { y: 'C', a: {$line1[0]->c},  b:{$line2[0]->c}, c:{$line3[0]->c}},
          ";
          ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b','c'],
        parseTime:false,
        labels: ['MOST', 'LEAST','CHANGE'],
        ymax: 8,
        ymin: -8,
        lineColors: ['#6a11cb', '#2575fc', '#28a745'],
        pointFillColors: ['#ffffff'],
        pointStrokeColors: ['#000000'],
        lineWidth: 3,
        pointSize: 5,
        hideHover: 'auto',
        resize: true,
        gridTextColor: '#4a4a4a',
        gridLineColor: '#e0e0e0',
        goalLineColors: ['#d9d9d9'],
        goalStrokeWidth: 1
      });
    });
    </script>
<?php
}
?>
</div>
<footer>copyright &copy; 2025<?php echo (date('Y')>2016?'-'.date('Y'):'');?> by <a href='mailto:kautsarrabdal@gmail.com'>TheRabdal</a></footer>
</body>
</html>