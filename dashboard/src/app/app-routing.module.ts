import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ConnexionComponent } from './components/connexion/connexion.component';
import { MainDashboardComponent } from './components/main-dashboard/main-dashboard.component';
import { AuthGuard } from './guards/auth.guard';
import { GeneralComponent } from './components/main-dashboard/general/general.component';

const routes: Routes = [
  {
    path: 'connexion',
    component: ConnexionComponent,
  },
  {
    path: 'mainDashboard',
    component: MainDashboardComponent,
    canActivate: [AuthGuard],
    children: [
      { path: 'general', component: GeneralComponent },
      { path: '**', redirectTo: 'general' },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
