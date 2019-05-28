<!DOCTYPE html>
<meta charset="utf-8">
<html >
<link rel="stylesheet" type="text/css" href="css/sensors.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>

<?php
include('nav.php');
?>
<body>
  <div><br></div>
  <div class="container-fluid page-container" >
    <div class="row dashboard-container" >
      <div class="col-md-2 column-buttons">
        <h3 >Sensors:</h3>
        
        <br>

        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="010A"  >Sensor 010A</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0101">Sensor 0101</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0102" >Sensor 0102</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0103" >Sensor 0103</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0104" >Sensor 0104</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0105" type="submit">Sensor 0105</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0106" type="submit">Sensor 0106</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0107" type="submit">Sensor 0107</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0108" type="submit">Sensor 0108</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="0109" type="submit">Sensor 0109</button>
        <button class="btn btn-md btn-secondary btn-block " onClick="SeeSensor(this.id)" id="01FF" type="submit">Sensor 01FF</button>
        <!-- <button class="btn btn-md btn-secondary btn-block " type="submit">Add Sensor</button> -->
        
      </div>
      <div class="col-10" >
        <div class="row dashboard-rows"> 
          <div class="col-md-3 pr-md-1"  >
            <div class="graph-containers">
              <div style="height: 11%"></div>
              <div class="variables-name">
                <img class="img-responsive" src="images/temperature.png" alt="" /> 
                <h3 >&ensp;Temperature</h3>
              </div>
              <div style="height: 25%"><br></div>
              <div  style="height: 25%; text-align: center; position:absolute; width:100%;">
                <h1 id="Temp_actual" style="font-size:90px;">°C</h1>
              </div> 
              <div  style="height: 25%"><br></div>    
            </div>
          </div>
          <div class="col-md-9 pr-md-1" >
            <div class="graph-containers">
              <br>
              <h3 style="margin-left: 5%;" >Temperature</h3>
              
              <canvas  id='canvasTemp' height="62"> {{ chart }}</canvas>
            </div>
          </div>
        </div>
        <div class="row dashboard-rows">
          <div class="col-md-3 pr-md-1"  >
            <div class="graph-containers">
              <div style="height: 11%"></div>
              <div class="variables-name">
                <img class="img-responsive" src="images/humidity.png" alt="" /><h3>&ensp;Humidity</h3></div>
                <div style="height: 25%"><br></div>
                <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                  <h1  id="Hum_actual" style="font-size:90px;">%</h1>
                </div> 
                <div  style="height: 25%"><br></div>    
              </div>
            </div>
            <div class="col-md-9 pr-md-1" >
              <div class="graph-containers">
                <br>
                <h3 style="margin-left: 5%;">Humidity</h3>
                <canvas id='canvasHum' height="62"> {{ chart }}></canvas>
              </div>
            </div>
          </div>
          <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1"  >
              <div class="graph-containers">
                <div style="height: 11%"></div>
                <div class="variables-name">
                  <img class="img-responsive" src="images/pressure.png" alt=""/><h3>&ensp;Pressure</h3></div>
                  <div style="height: 25%"><br></div>
                  <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                    <h1 id="Press_actual" style="font-size:90px;">hPa</h1>
                  </div> 
                  <div  style="height: 25%"><br></div>    
                </div>
              </div>
              <div class="col-md-9 pr-md-1" >
                <div class="" style="background-color: #fff; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);  background-color: #fff;">
                  <br>
                  <h3  id="Press_actual"style="margin-left: 5%;">Pressure</h3>
                  <canvas id='canvasPress' height="62"> {{ chart }}></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    </body>
    </html>


    <script>
      var socket = io.connect('http://localhost:8080');
      var dataTemperatura = [];
      var sensorId = '0101';
      //pedido
      socket.on('dbUpdated', function(status){
        console.log("A base de dados foi atualizada!!!!!!");
        
        socket.emit('dbRequest', sensorId);
      });
      //rececao dos dados
      socket.on('dbNewData', function(db){
        console.log('Dados recebidos!');

        dataTemperatura = db.map(sensor => sensor.temperature);
        dataHumidity = db.map(sensor => sensor.humidity);
        dataPressure = db.map(sensor => sensor.pressure);
        dataHour = db.map(sensor => sensor.hour);

        UpdateGraph();
      });

      function UpdateGraph(){

    //temperature chart
    var ctx = document.getElementById('canvasTemp').getContext('2d');
    var myTempChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataTemperatura , //temp,
              backgroundColor: '#D55858',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#D55858",
              pointBorderColor: '#fff',
              borderColor: '#D55858',
              hoverBorderColor:"#D55858",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: 20,
                  max: 30
                }
              }]
            }
          }
        });

      //Humidity chart
      var ctx2 = document.getElementById('canvasHum').getContext('2d');
      var myHumChart = new Chart(ctx2, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataHumidity,//hum,
              backgroundColor: '#3F87CE',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#3F87CE",
              pointBorderColor: '#fff',
              borderColor: '#3F87CE',
              hoverBorderColor:"#3F87CE",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: 30,
                  max: 70
                }
              }]
            }
          }
        });

      
      //Pressure chart
      var ctx3 = document.getElementById('canvasPress').getContext('2d');
      var myPressChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: dataHour, //hours,
            datasets: [
            {
              data: dataPressure,//press,
              backgroundColor: '#40B97C',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#40B97C",
              pointBorderColor: '#fff',
              borderColor: '#40B97C',
              hoverBorderColor:"#40B97C",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: 985,
                  max: 1005
                }
              }]
            }
          }
        });

      console.log("dataTemperatura", dataTemperatura);
      document.getElementById("Temp_actual").innerHTML = parseFloat(dataTemperatura[11]) + "C";
      document.getElementById("Hum_actual").innerHTML = parseFloat(dataHumidity[11]) + "%";
      document.getElementById("Press_actual").innerHTML = parseFloat(dataPressure[11]) + "hPa";
    }
    window.onload = SeeSensor('0101');
    
    function SeeSensor(clicked_id){
      
      sensorId = clicked_id;

      socket.emit('dbRequest', sensorId);

    }
  </script>
   <?php
//include('footer.php');
?>
