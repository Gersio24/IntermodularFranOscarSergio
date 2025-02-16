import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Empresa } from '../types';
import { Router } from '@angular/router';

@Component({
  selector: 'app-company',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './company.component.html',
  styleUrl: './company.component.scss'
})
export class CompanyComponent {
  @Input() empresa!: Empresa;

  constructor(private router: Router) {}

  onContact() {
    this.router.navigate(['/empresa', this.empresa.id]);
  }

  onForm() {
    this.router.navigate(['/create-form', this.empresa.id]);
  }
}

