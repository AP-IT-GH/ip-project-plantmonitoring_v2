import { NgModule,NO_ERRORS_SCHEMA } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { SensorsComponent } from './sensors/sensors.component';
import { HistoryComponent } from './history/history.component';
import { LoginComponent } from './login/login.component';
//import { AuthGuard } from './Guards/auth.guard';
import {AuthhGuard} from './Guards/authh.guard'
import { AdminComponent } from './admin/admin.component';

const routes: Routes = [
  {path: '', redirectTo:'login', pathMatch: 'full'},
  {path : 'home' , component: HomeComponent, canActivate: [AuthhGuard]},
  {path : 'sensors', component: SensorsComponent, canActivate: [AuthhGuard]},
  {path : 'history', component: HistoryComponent, canActivate: [AuthhGuard]},
  {path : 'admin', component : AdminComponent, canActivate: [AuthhGuard]},
  {path : 'login', component: LoginComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

