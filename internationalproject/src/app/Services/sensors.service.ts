import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { Sensor } from '../sensors/sensors.component';
@Injectable({
  providedIn: 'root'
})
export class SensorsService {
  baseUrl = 'http://localhost/DATABASES/PHPApi/';
  sensors: Sensor[];

  constructor(private http: HttpClient) { }
  getAll(): Observable<Sensor[]> {
    return this.http.get(`${this.baseUrl}/getlist.php`).pipe(
      map((res) => {
        this.sensors = res['data'];
        return this.sensors;
    }),
    catchError(this.handleError));


  }
  private handleError(error: HttpErrorResponse) {
    console.log(error);
   
    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }
}

