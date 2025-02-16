import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpCompaniesService } from '../services/http-companies.service';
import { Empresa } from '../types';

@Component({
  selector: 'app-company-detail',
  standalone: true,
  imports: [CommonModule],
  template: `
    @if (loading) {
      <div class="container mt-4">
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
          <p class="mt-2">Cargando información de la empresa...</p>
        </div>
      </div>
    } @else if (error) {
      <div class="container mt-4">
        <div class="alert alert-danger">
          {{ error }}
        </div>
      </div>
    } @else if (company) {
      <div class="container mt-4">
        <div class="card shadow">
          <div class="card-header">
            <h2 class="mb-0 text-white">{{company.name}}</h2>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <h4 class="mb-3">Información de Contacto</h4>
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <i class="bi bi-envelope-fill me-2"></i>
                    <strong>Email:</strong> {{company.email}}
                  </li>
                  <li class="mb-2">
                    <i class="bi bi-telephone-fill me-2"></i>
                    <strong>Teléfono:</strong> {{company.phone}}
                  </li>
                  <li class="mb-2">
                    <i class="bi bi-geo-alt-fill me-2"></i>
                    <strong>Dirección:</strong><br>
                    {{company.address.street}}<br>
                    {{company.address.town}}<br>
                    {{company.address.region}}
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <h4 class="mb-3">Horario y Valoraciones</h4>
                <p>
                  <i class="bi bi-clock-fill me-2"></i>
                  <strong>Horario:</strong> {{company.workingHours.start}} - {{company.workingHours.end}}
                </p>
                <div class="mt-4">
                  <h5>Valoraciones</h5>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <h6 class="mb-0">Calificación Profesor</h6>
                      <span class="rating-value">{{company.score.teacher}}%</span>
                    </div>
                    <div class="progress w-100 mx-0 px-0" role="progressbar" aria-label="progress-bar teacher"
                        [attr.aria-valuenow]="company.score.teacher" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar bg-warning" [style.width.%]="company.score.teacher">
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <h6 class="mb-0">Calificaciones Alumno</h6>
                      <span class="rating-value">{{company.score.student}}%</span>
                    </div>
                    <div class="progress w-100 mx-0 px-0" role="progressbar" aria-label="progress-bar student"
                        [attr.aria-valuenow]="company.score.student" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar bg-warning" [style.width.%]="company.score.student">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="mt-4">
              <h4 class="mb-3">Vacantes Disponibles</h4>
              <div class="row">
                @for (opening of company.openings; track opening.year) {
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <h5 class="card-title">{{opening.year}}</h5>
                        <p class="card-text">{{opening.count}} plazas</p>
                      </div>
                    </div>
                  </div>
                }
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row g-2">
              <div class="col-md-6">
                <button class="btn btn-back w-100" (click)="onBack()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                  </svg>
                  <span>Volver</span>
                </button>
              </div>
              <div class="col-md-6">
                <button class="btn btn-contact w-100" (click)="onContact()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope me-2" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                  </svg>
                  <span>Contactar</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    }
  `,
  styles: [`
    .card-header {
      background: linear-gradient(to right, #F12711, #F5AF19);
      border: none;
    }

    .progress {
      height: 8px;
      margin-bottom: 1rem;
      background-color: #f8f9fa;
      border-radius: 0;
      width: 100%;
      padding: 0;
    }

    .progress-bar {
      background: linear-gradient(to right, #F12711, #F5AF19);
      border-radius: 0;
      margin: 0;
      padding: 0;
    }

    .card {
      border: none;
    }

    .bi {
      color: #F12711;
    }

    .alert-danger {
      background: linear-gradient(to right, #F12711, #F5AF19);
      color: white;
      border: none;
    }

    .spinner-border {
      color: #F5AF19;
    }

    .card-footer {
      background: none;
      border: none;
      padding: 1rem;
    }

    .rating-value {
      color: var(--text-gray-dark);
      font-weight: 500;
      font-size: 0.9rem;
    }

    .btn {
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      border: none;
      color: white;

      &:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);

        &::after {
          opacity: 1;
        }
      }

      &::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
      }

      svg {
        position: relative;
        z-index: 2;
        color: white;
      }

      span {
        position: relative;
        z-index: 2;
      }
    }

    .btn-contact {
      background: linear-gradient(to right, #F12711, #F5AF19);
      
      &::after {
        background: linear-gradient(to right, #F5AF19, #F12711);
      }
    }

    .btn-back {
      background: linear-gradient(to right, #757F9A, #D7DDE8);
      
      &::after {
        background: linear-gradient(to right, #D7DDE8, #757F9A);
      }
    }
  `]
})
export class CompanyDetailComponent implements OnInit {
  company?: Empresa;
  loading = true;
  error?: string;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private companiesService: HttpCompaniesService
  ) {}

  onContact() {
    window.location.href = `mailto:${this.company?.email}`;
  }

  onBack() {
    this.router.navigate(['/dashboard']);
  }

  ngOnInit() {
    const id = Number(this.route.snapshot.paramMap.get('id'));
    if (!id) {
      this.error = 'ID de empresa no válido';
      this.loading = false;
      return;
    }

    this.companiesService.getEmpresa(id).subscribe({
      next: (company) => {
        this.company = company;
        this.loading = false;
      },
      error: (error) => {
        console.error('Error fetching company:', error);
        this.error = 'Error al cargar la información de la empresa';
        this.loading = false;
      }
    });
  }
}