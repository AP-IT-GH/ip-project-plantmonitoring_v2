var http = require('http');
var fs = require('fs');
var mysql  = require('mysql');

// Loading the index file . html displayed to the client
var server = http.createServer(function(req, res) {
    fs.readFile('./index.html', 'utf-8', function(error, content) {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(content);
    });
});


// Loading socket.io
var io = require('socket.io').listen(server);

// When a client connects, we note it in the console
io.sockets.on('connection', function (socket) {
  console.log('A client is connected!');

  socket.on('dbRequest', function(sensorId){
    console.log("Id sensor: " + sensorId);

    con.query("SELECT * FROM sensors where id_sensor=" + sensorId + " order BY DATE DESC, hour LIMIT 12", function(err, result){
      result;
      io.emit('dbNewData', result);
    });
  });


  /////////////////////////
  socket.on('dbRequestTemp', function(){
    console.log('Temperature request received!');
   
    con.query("SELECT m1.sensor_id, m1.id_sensor, m1.temperature, l.location_x, l.location_y FROM (sensors m1) JOIN location l ON l.id_sensor= m1.id_sensor LEFT JOIN sensors m2 ON (m1.id_sensor = m2.id_sensor AND m1.sensor_id < m2.sensor_id) WHERE m2.sensor_id IS NULL ", function(err, resultTemp){
      io.emit('dbTemp', resultTemp);
      console.log(resultTemp);
    });
  });


   ////////////////////////////////////
});
//node index.js to start

server.listen(8080);

var rowNumber = 0;

var con = mysql.createConnection({
  host: "104.198.216.26",//"localhost",
  user: "root",
  password: "root",
  database: "plantdb"
});

con.connect(function(err){
  if(err) throw err;
  console.log("Connected to MySql!");

  setInterval(function() {
    con.query("SELECT COUNT(*) AS count FROM sensors", function(err, result){
      rowNumberTemp = result[0].count;
      console.log("rowNumber: " +  rowNumber + ", rowNumberTemp: " + rowNumberTemp);

      if(rowNumber != rowNumberTemp){
        io.emit('dbUpdated', true);
        rowNumber = rowNumberTemp;
      }
    });
  }, 5000);
});