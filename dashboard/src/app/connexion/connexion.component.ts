import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../service/auth.service';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.css'],
})
export class ConnexionComponent implements OnInit {
  public email!: string;
  public password!: string;
  public souvenir: boolean = false;
  public numberOfOrders = 0;

  constructor(public router: Router, public authServe: AuthService) {
  }

  ngOnInit(): void {
  }

  connexion(monForm: NgForm) {
    this.authServe.login();
    this.router.navigate(['./mainDashboard']);
    monForm.reset();
  }
}
