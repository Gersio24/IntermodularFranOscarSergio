import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { FiltrosFormElements } from '../types';
import { EmpresaFiltrarOrdenarService } from '../services/empresa-orden.service';

@Component({
  selector: 'app-filters',
  imports: [FormsModule],
  templateUrl: './filters.component.html',
  styleUrls: ['./filters.component.scss'],
  standalone: true,
})
export class FiltersComponent {
  filtros = {
    nombre: '',
    provincia: '',
    localidad: '',
    categoria: '',
    servicio: ''
  };

  constructor(public empresaService: EmpresaFiltrarOrdenarService) {}

  aplicarFiltros(event: Event) {
    event.preventDefault();
    this.empresaService.actualizarFiltros({...this.filtros, vacantes: ''});
  }

  onProvinciaSelected(event: Event) {
    const target = event.target as HTMLSelectElement;
    const regiones = this.empresaService.getRegiones();
    const region = regiones.find(r => r.name === target.value);
    if (region) {
      this.empresaService.actualizarRegionSeleccionada(region.id);
    }
  }

  onCategoriaChange(event: Event) {
    const target = event.target as HTMLSelectElement;
    const categorias = this.empresaService.getCategorias();
    const categoria = categorias.find(c => c.name === target.value);
    if (categoria) {
      this.empresaService.actualizarCategoriaSeleccionada(categoria.id);
    }
  }

  onReset(e: Event) {
    this.filtros = {
      nombre: '',
      provincia: '',
      localidad: '',
      categoria: '',
      servicio: ''
    };
    
    const regiones = this.empresaService.getRegiones();
    const categorias = this.empresaService.getCategorias();

    if (regiones.length > 0) {
      this.empresaService.actualizarRegionSeleccionada(regiones[0].id);
    }
    
    if (categorias.length > 0) {
      this.empresaService.actualizarCategoriaSeleccionada(categorias[0].id);
    }

    this.empresaService.actualizarFiltros({...this.filtros, vacantes: ''});
  }
}