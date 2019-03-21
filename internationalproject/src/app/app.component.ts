import { Component } from '@angular/core';
import { LoginComponent } from './login/login.component';
import { AuthenticationService } from 'src/app/Services/authentication.service';
 @Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  rootPage: any = LoginComponent;

  constructor(){
  }
}
