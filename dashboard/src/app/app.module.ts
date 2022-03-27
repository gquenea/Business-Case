import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ConnexionComponent } from './components/connexion/connexion.component';
import { MainDashboardComponent } from './components/main-dashboard/main-dashboard.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatNativeDateModule } from '@angular/material/core';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { GeneralComponent } from './components/main-dashboard/general/general.component';
import { NgChartsModule } from 'ng2-charts';
import { HttpClientModule } from '@angular/common/http';
import { OrdersService } from './service/orders.service';

@NgModule({
  declarations: [
    AppComponent,
    ConnexionComponent,
    MainDashboardComponent,
    GeneralComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    BrowserAnimationsModule,
    NgChartsModule,
    MatNativeDateModule,
    MatFormFieldModule,
    MatDatepickerModule,
    HttpClientModule,
  ],
  providers: [
    OrdersService
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
