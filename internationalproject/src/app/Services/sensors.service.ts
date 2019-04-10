import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Sensor } from '../sensors/sensors.component';
@Injectable({
  providedIn: 'root'
})
export class SensorsService {
  baseUrl = 'http://localhost/DATABASES/PHPApi';
  sensors: Sensor[];

  constructor(private http: HttpClient) { }

  getData(){
    return this.http.get<Sensorinfo>(`${this.baseUrl}/getlist.php`)
  }

  private handleError(error: HttpErrorResponse) {
    console.log(error);
   
    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }


}

export interface ISensor{
  sensor_id: string;
  temperature: string;
  hour: string;
  date: string;
  humidity: string;
  pressure: string;
  altitude?: any;
  ativo: string;
}

export interface Sensorinfo{
  data: ISensor[];
}

