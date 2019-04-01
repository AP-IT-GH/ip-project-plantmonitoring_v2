import { Component, OnInit } from '@angular/core';
import { SensorsService, Sensorinfo } from '../Services/sensors.service';

@Component({
  selector: 'app-history',
  templateUrl: './history.component.html',
  styleUrls: ['./history.component.scss']
})
export class HistoryComponent implements OnInit {

  sensorInfo:Sensorinfo;
  constructor(public data:SensorsService) {
    this.data.getData().subscribe((info) => {
      this.sensorInfo = info;
    })
   }

  ngOnInit() {

  }
}
