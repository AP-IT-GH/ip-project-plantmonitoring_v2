import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sensors',
  templateUrl: './sensors.component.html',
  styleUrls: ['./sensors.component.scss']
})
export class SensorsComponent implements OnInit {

  
  public barChartOptions = {
    scaleShowVerticalLines: false,
    responsive: true
  };

  
  public barChartLabels = ['1h', '2h', '3h', '4h', '5h', '6h', '7h', '9h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h','22h', '23h', '24h'];
  public barChartType = 'line';
  public barChartLegend = true;

  public barChartData = [
    { data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40,65, 59, 80, 81, 56, 55, 40, 65, 59, 80],
      label: 'Sensor 1', 
      fill: false,
      
    },  
  
  ];

  public barChartColorsTemperature = [{
    backgroundColor: '#D55858',
    hoverBackgroundColor:"#ffff",
    pointBackgroundColor: "#D55858",
    pointBorderColor: '#fff',
    borderColor: '#D55858',
    hoverBorderColor:"#D55858"
 }];

 public barChartColorsHumidity = [{
  backgroundColor: '#3F87CE',
  hoverBackgroundColor:"#ffff",
  pointBackgroundColor: "#3F87CE",
  pointBorderColor: '#fff',
  borderColor: '#3F87CE',
  hoverBorderColor:"#3F87CE"
}];
public barChartColorsPressure = [{
  backgroundColor: '#40B97C',
  hoverBackgroundColor:"#ffff",
  pointBackgroundColor: "#40B97C",
  pointBorderColor: '#fff',
  borderColor: '#40B97C',
  hoverBorderColor:"#40B97C"
}];
  



  constructor() { }

  ngOnInit() {
  }

}
export class Sensor {
  constructor(
  sensor_id : string,
  temperature : number,
  humidity : number ,
  pressure : number ,
  ativo : boolean,
  altitude?: number 
  ){}

}
