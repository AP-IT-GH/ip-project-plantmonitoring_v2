import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavComponent } from './nav/nav.component';
import { HttpClientModule } from '@angular/common/http';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import { HomeComponent } from './home/home.component';
import { SensorsComponent } from './sensors/sensors.component';
import { HistoryComponent } from './history/history.component';
import { FooterComponent } from './footer/footer.component';
import { LoginComponent } from './login/login.component';
import { ChartsModule } from 'ng2-charts';
import { AlertComponent } from './alert/alert.component';
import { AdminComponent } from './admin/admin.component';
import { UserService } from './Services/user.service';
import { AuthenticationService } from './Services/authentication.service';
import {AuthhGuard} from './Guards/authh.guard';
import {DataViewModule} from 'primeng/dataview';
import {TableModule} from 'primeng/table';
import {PaginatorModule} from 'primeng/paginator';
import {NgxPaginationModule} from 'ngx-pagination';  
import { Ng2SearchPipeModule } from 'ng2-search-filter';





@NgModule({
  declarations: [
    AppComponent,
    NavComponent,
    HomeComponent,
    SensorsComponent,
    HistoryComponent,
    FooterComponent,
    LoginComponent,
    AlertComponent,
    AdminComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ChartsModule,
    DataViewModule,
    TableModule,
    PaginatorModule,
    NgxPaginationModule,Ng2SearchPipeModule,
    NgbModule.forRoot()
  ],
  providers: [AuthhGuard,AuthenticationService,UserService],
  bootstrap: [AppComponent,NavComponent]
})
export class AppModule { }
