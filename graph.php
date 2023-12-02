
<html>

<head>
<!--   starting bootstrap for the buttons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
<!--   starting the google charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Mes-Ano', 'Entradas R$', 'Saidas R$'],
        // diariamente
        <?php
        include('config/dbcon.php');
        $sql = "SELECT DATE_FORMAT(criado_em, '%m/%y') AS mes, 
          SUM(CASE WHEN tipo_m = 1 THEN valor_m ELSE 0 END) AS entradas,
          SUM(CASE WHEN tipo_m = 2 THEN valor_m ELSE 0 END) AS saidas
            FROM controle_caixa
            GROUP BY mes
            ORDER BY mes";
            $sql_run = mysqli_query($con, $sql);

        if(isset($_GET['dia'])){
        $sql = "SELECT DATE_FORMAT(criado_em, '%d/%m/%y') AS mes, 
       SUM(CASE WHEN tipo_m = 1 THEN valor_m ELSE 0 END) AS entradas,
       SUM(CASE WHEN tipo_m = 2 THEN valor_m ELSE 0 END) AS saidas
FROM controle_caixa
WHERE DATE_FORMAT(criado_em, '%Y-%m') = (SELECT MAX(DATE_FORMAT(criado_em, '%Y-%m')) FROM controle_caixa)
GROUP BY mes
ORDER BY STR_TO_DATE(mes, '%d/%m/%y')";
        $sql_run = mysqli_query($con, $sql);
        }
        if(isset($_GET['mes'])){
          $sql = "SELECT DATE_FORMAT(criado_em, '%m/%y') AS mes, 
          SUM(CASE WHEN tipo_m = 1 THEN valor_m ELSE 0 END) AS entradas,
          SUM(CASE WHEN tipo_m = 2 THEN valor_m ELSE 0 END) AS saidas
            FROM controle_caixa
            GROUP BY mes
            ORDER BY mes";
            $sql_run = mysqli_query($con, $sql);}

            while ($dados = mysqli_fetch_array($sql_run)) {
                $mes = $dados['mes'];
                $entrada = $dados['entradas'];
                $saida = $dados['saidas'];


          ?>

          ['<?php echo $mes ?>', <?php echo $entrada ?>, <?php echo $saida ?>],

        <?php } ?>
      ]);

      var options = {
        title: 'Controle de caixa',
        hAxis: { title: 'Mês-Ano', titleTextStyle: { color: '#333' } },
        vAxis: { title: 'Movimentações', minValue: 0 }
      };

      var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
</head>

<body>
<form action="" method="POST" style="text-align:right;">
    <button class="btn btn-secondary"><a style="text-decoration:none; color: white" href="?mes" value="mes" name="mes" id="mes" data-bs-toggle="tooltip" title="Tooltip">Mensal</a></button>
    <button class="btn btn-secondary"><a style="text-decoration:none; color: white" href="?dia" value="dia" name="dia" id="dia" data-bs-toggle="tooltip" title="Tooltip">Diario</a></button>
</form>
  <div id="chart_div" style="width: 100%; height: 500px;"></div>
</body>

</html>
