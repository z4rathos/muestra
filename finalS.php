<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medidor Temperatura, Humedad</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['°C', 0],
          ['%', 0]
         
        ]);

        var options = {
          width: 400, height: 400,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5,

        };

        var chart = new google.visualization.Gauge(document.getElementById('Medidores'));

        chart.draw(data, options);

        setInterval(function() {
            var JSON=$.ajax({
                url:"http://www.test.com/platforms/SyA/datoSensores.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
            
          data.setValue(0, 1,Respuesta[0].temperatura);
          data.setValue(1, 1,Respuesta[0].humedad);
          chart.draw(data, options);
        }, 1300);
        
      }
function drawChart1() {
            // create data object with default value
            let data = google.visualization.arrayToDataTable([
                ["Tiempo", "Voltaje"],
                [0, 0]
            ]);
            // create options object with titles, colors, etc.
            let options = {
                title: "Motor",
                hAxis: {
                    title: "Time"
                },
                vAxis: {
                    title: "Volts"
                }
            };
            // draw chart on load
            let chart = new google.visualization.LineChart(
                document.getElementById("chart_div")
            );
            chart.draw(data, options);
            // interval for adding new data every 250ms
            let index = 0;
            setInterval(function() {
				var JSON=$.ajax({
                url:"http://www.test.com/platforms/SyA/datoSensores.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
              var pot;
              pot = Number(Respuesta[0].potenciometro);
                data.addRow([index, pot]);
                chart.draw(data, options);
                index++;
            }, 1000);
        }
  $(document).ready(function(){
  $("#ON").click(function(){
    $("#status").text("Encendido");
    $.post("http://www.test.com/platforms/SyA/vled.php",
    {
      estado: "1"
    });
  });
  $("#OFF").click(function(){
    $("#status").text("Apagado");
    $.post("http://www.test.com/platforms/SyA/vled.php",
    {
      estado: "0"
    });

  });
    $("#txt_name").keypress(function(){
      var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
      var esc = "";
      esc = $("input").val();
      if (esc == ""){
        alert('Ingrese Valor');
      }else{
      $.post("http://www.test.com/platforms/SyA/eLcd.php",
    {
      escrito: esc
    });
      }
    $("input").val("");
    }

  });
});


    </script>
</head>
<body>
  <div class="container">
  <h2>Dashboard</h2>
  <div class="panel panel-default">
    <div class="bg-primary">Sensores Análogos</div>
    <div class="panel-footer" id="Medidores" ></div>
    <div class="panel-footer">
      <div class="bg-primary">Digital</div>
      <input type="text" id="txt_name" maxlength="15" required  />
      
    </div>
    <div class="panel-footer">
      <button id="ON" class="btn btn-success">ON</button>
      <button  id="OFF" class="btn btn-danger">OFF</button>
      <div class='bg-warning' id="status"></div>
      <div class="bg-success">Gráfico</div>
      <div id="chart_div" style="width: 900px; height: 500px"></div>
    </div>
  </div>
</div>

       
   
</body>
</html>
