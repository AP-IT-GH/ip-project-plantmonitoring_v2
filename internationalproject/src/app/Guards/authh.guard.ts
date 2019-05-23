import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, CanActivate, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthenticationService } from '../Services/authentication.service';


@Injectable({
  providedIn: 'root'
})
export class AuthhGuard implements CanActivate{
  constructor(private auth: AuthenticationService , private router :Router){

  }

  canActivate(
    next : ActivatedRouteSnapshot,
    state : RouterStateSnapshot) : Observable<boolean> |Promise<boolean> | boolean{
      //if it is not the correct user
      if(!this.auth.isLoggedIn){
        this.router.navigate(['login'])

      //if correct user
      }
      return this.auth.isLoggedIn;

    }
  
}
