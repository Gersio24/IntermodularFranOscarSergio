import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, NgForm } from '@angular/forms';
import { LocalRegionsService } from '../services/local-regions.service';
import { HttpCategoriesService } from '../services/http-categories.service';
import { Region, Category, Empresa, Service } from '../types';
import { CompanyNameValidatorDirective } from '../directives/company-name-validator.directive';
import { BusinessHoursValidatorDirective } from '../directives/business-hours-validator.directive';

@Component({
  selector: 'app-create-company',
  standalone: true,
  imports: [
    CommonModule, 
    FormsModule,
    CompanyNameValidatorDirective,
    BusinessHoursValidatorDirective
  ],
  templateUrl: './create-company.component.html',
  styleUrl: './create-company.component.scss'
})
export class CreateCompanyComponent implements OnInit {
  regiones: Region[] = [];
  categorias: Category[] = [];
  servicios: Service[] = [];
  serviciosPorCategoria: { [key: string]: Service[] } = {};
  selectedServices: { [key: string]: boolean } = {};
  selectedCategory: string = '';
  errorMsg = '';

  company: Partial<Empresa> = {
    name: '',
    phone: '',
    email: '',
    address: {
      region: '',
      town: '',
      street: '',
      position: {
        lat: 0,
        lng: 0
      }
    },
    workingHours: {
      start: '',
      end: ''
    },
    image: '',
    categories: [],
    services: [],
    openings: [{
      year: new Date().getFullYear(),
      count: 0
    }],
    score: {
      teacher: 0,
      student: 0
    }
  };

  constructor(
    private regionesService: LocalRegionsService,
    private categoriasService: HttpCategoriesService
  ) {
    this.serviciosPorCategoria = {};
  }

  ngOnInit() {
    this.loadRegiones();
    this.loadCategorias();
    this.loadServicios();
  }

  loadRegiones() {
    this.regionesService.getRegions().subscribe({
      next: (data) => this.regiones = data,
      error: () => this.errorMsg = 'Error al cargar las regiones'
    });
  }

  loadCategorias() {
    this.categoriasService.getCategories().subscribe({
      next: (data) => this.categorias = data,
      error: () => this.errorMsg = 'Error al cargar las categorías'
    });
  }

  loadServicios() {
    this.categoriasService.getServices('all').subscribe({
      next: (data) => {
        this.servicios = data;
        this.serviciosPorCategoria = this.servicios.reduce((acc, servicio) => {
          if (!acc[servicio.category]) {
            acc[servicio.category] = [];
          }
          acc[servicio.category].push(servicio);
          return acc;
        }, {} as { [key: string]: Service[] });
        console.log('Servicios por categoría:', this.serviciosPorCategoria); // Para debug
      },
      error: () => this.errorMsg = 'Error al cargar los servicios'
    });
  }

  getServiciosCategoria(categoryId: string): Service[] {
    const servicios = this.serviciosPorCategoria[categoryId] || [];
    console.log('Servicios para categoría', categoryId, ':', servicios); // Para debug
    return servicios;
  }

  onCategoryChange(categoryId: string) {
    this.selectedCategory = categoryId;
    this.selectedServices = {};
    this.company.categories = categoryId ? [categoryId] : [];
    this.company.services = [];
  }

  updateServices() {
    const selectedServiceIds = Object.entries(this.selectedServices)
      .filter(([_, isSelected]) => isSelected)
      .map(([serviceId, _]) => serviceId);
    
    this.company.services = selectedServiceIds;
    console.log('Servicios seleccionados:', this.company.services); // Para debug
  }

  hasSelectedServices(): boolean {
    return this.company.services !== undefined && this.company.services.length > 0;
  }

  onSubmit(form: NgForm) {
    if (form.valid && this.hasSelectedServices()) {
      console.log('Empresa a crear:', this.company);
    }
  }
}