import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sensors',
  templateUrl: './sensors.component.html',
  styleUrls: ['./sensors.component.scss']
})
export class SensorsComponent implements OnInit {

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
