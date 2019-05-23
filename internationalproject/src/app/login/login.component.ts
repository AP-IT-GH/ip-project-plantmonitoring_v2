import { Component, OnInit  } from '@angular/core';
import { AuthenticationService } from 'src/app/Services/authentication.service';
import { Router } from '@angular/router';
@Component({
selector: 'app-login',
templateUrl: './login.component.html' ,
styleUrls: ['./login.component.scss']})
export class LoginComponent implements OnInit {

    private authenticationService: AuthenticationService

    constructor(private auth : AuthenticationService ,private router : Router) {  }

    ngOnInit() {
    }

    loginuser(event){
        event.preventDefault();
        const target  =event.target;
        const username = target.querySelector("#username").value;
        const password = target.querySelector("#password").value;

        this.auth.login(username, password).subscribe(data =>{
            if(data.success ==true){

                this.router.navigate(['home'])
                this.auth.setLoggedIn(true);
            }
            else {
                window.alert(data.message);
            }
        })
        console.log(username,password);
    }
}