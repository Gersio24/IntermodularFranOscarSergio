import { Component, Input } from '@angular/core';
import { Empresa } from '../types';
import { Router } from '@angular/router';

@Component({
  selector: 'app-company',
  standalone: true,
  templateUrl: './company.component.html',
  styleUrl: './company.component.scss'
})
export class CompanyComponent {
  @Input() company!: Empresa;

  constructor(private router: Router) {}

  onContact() {
    this.router.navigate(['/company', this.company.id]);
  }

  onForm(){
    this.router.navigate(['/create-form', this.company.id]);
  }
}

