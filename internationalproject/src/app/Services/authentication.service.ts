import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, config } from 'rxjs';

interface mydata{
    success: boolean;
    message : string;
}

@Injectable({ providedIn: 'root' })

export class AuthenticationService {

  private  loggedinstatus = false 

    constructor(private http: HttpClient) {
    }
    setLoggedIn(value : boolean){
        this.loggedinstatus = value
    }
   get isLoggedIn (){
      return  this.loggedinstatus
    }
     login(username: string, password: string) {
        return this.http.post<mydata>('http://localhost/DATABASES/PHPApi/auth.php', { username, password }
    

        )}
}
