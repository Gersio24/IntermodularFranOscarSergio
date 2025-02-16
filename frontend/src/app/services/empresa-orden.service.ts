import { Injectable } from '@angular/core';
import { Empresa, Filtros, Region, Category, Service } from '../types';
import { HttpCompaniesService } from './http-companies.service';
import { HttpCategoriesService } from './http-categories.service';
import { HttpRegionsService } from './http-regions.service';
import { BehaviorSubject, Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class EmpresaFiltrarOrdenarService {
  private empresasSubject = new BehaviorSubject<Empresa[]>([]);
  private regionesSubject = new BehaviorSubject<Region[]>([]);
  private categoriasSubject = new BehaviorSubject<Category[]>([]);
  private serviciosSubject = new BehaviorSubject<Service[]>([]);
  private ciudadesSubject = new BehaviorSubject<string[]>([]);
  
  private filtrosSubject = new BehaviorSubject<Filtros>({
    nombre: '',
    provincia: '',
    localidad: '',
    vacantes: '',
    categoria: '',
    servicio: ''
  });
  
  private ordenDireccionSubject = new BehaviorSubject<'ascendente' | 'descendente'>('ascendente');
  private ordenCampoSubject = new BehaviorSubject<'nombre' | 'score' | 'vacantes'>('nombre');

  // Observables públicos
  empresas$ = this.empresasSubject.asObservable();
  filtros$ = this.filtrosSubject.asObservable();
  ordenDireccion$ = this.ordenDireccionSubject.asObservable();
  ordenCampo$ = this.ordenCampoSubject.asObservable();

  constructor(
    private companiesService: HttpCompaniesService,
    private categoriesService: HttpCategoriesService,
    private regionsService: HttpRegionsService
  ) {
    this.cargarDatos();
  }

  private cargarDatos() {
    this.companiesService.getEmpresas().subscribe({
      next: (empresas) => this.empresasSubject.next(empresas),
      error: (error) => {
        console.error('Error cargando empresas:', error);
        this.empresasSubject.next([]);
      }
    });

    this.regionsService.getRegions().subscribe({
      next: (regiones) => {
        this.regionesSubject.next(regiones);
        if (regiones.length > 0) {
          this.actualizarRegionSeleccionada(regiones[0].id);
        }
      },
      error: (error) => console.error('Error cargando regiones:', error)
    });

    this.categoriesService.getCategories().subscribe({
      next: (categorias) => {
        this.categoriasSubject.next(categorias);
        if (categorias.length > 0) {
          this.actualizarCategoriaSeleccionada(categorias[0].id);
        }
      },
      error: (error) => console.error('Error cargando categorías:', error)
    });
  }

  getEmpresasFiltradasOrdenadas(): Observable<Empresa[]> {
    return this.empresasSubject.pipe(
      map(empresas => {
        console.log('Empresas originales:', empresas);
        const empresasFiltradas = this.filtrarEmpresas(empresas);
        console.log('Empresas después de filtrar:', empresasFiltradas);
        const empresasOrdenadas = this.ordenarEmpresas(empresasFiltradas);
        console.log('Empresas después de ordenar:', empresasOrdenadas);
        return empresasOrdenadas;
      })
    );
  }

  private filtrarEmpresas(empresas: Empresa[]): Empresa[] {
    const filtros = this.filtrosSubject.value;
    console.log('Aplicando filtros:', filtros);
    
    if (!filtros.nombre && !filtros.provincia && !filtros.localidad && 
        !filtros.categoria && !filtros.servicio) {
      console.log('No hay filtros activos, devolviendo todas las empresas');
      return empresas;
    }
    
    const empresasFiltradas = empresas.filter(empresa => {
      // Filtro por nombre
      const cumpleNombre = !filtros.nombre || 
        empresa.name.toLowerCase().includes(filtros.nombre.toLowerCase().trim());
      
      // Filtro por provincia/región
      const cumpleProvincia = !filtros.provincia || 
        empresa.address.region.toLowerCase() === filtros.provincia.toLowerCase();
      
      // Filtro por localidad/ciudad
      const cumpleLocalidad = !filtros.localidad || 
        empresa.address.town.toLowerCase() === filtros.localidad.toLowerCase();
      
      // Filtro por categoría
      const cumpleCategoria = !filtros.categoria || 
        empresa.categories.some(cat => cat.toLowerCase() === filtros.categoria.toLowerCase());
      
      // Filtro por servicio
      const cumpleServicio = !filtros.servicio || 
        empresa.services.some(serv => serv.toLowerCase() === filtros.servicio.toLowerCase());

      const cumpleTodo = cumpleNombre && 
                        cumpleProvincia && 
                        cumpleLocalidad && 
                        cumpleCategoria && 
                        cumpleServicio;

      if (!cumpleTodo) {
        console.log(`Empresa ${empresa.name} no cumple los filtros:`, {
          nombre: cumpleNombre,
          provincia: cumpleProvincia,
          localidad: cumpleLocalidad,
          categoria: cumpleCategoria,
          servicio: cumpleServicio
        });
      }

      return cumpleTodo;
    });

    console.log(`Filtrado completado: ${empresasFiltradas.length} empresas de ${empresas.length}`);
    return empresasFiltradas;
  }

  private ordenarEmpresas(empresas: Empresa[]): Empresa[] {
    const direccion = this.ordenDireccionSubject.value;
    const campo = this.ordenCampoSubject.value;
    
    return [...empresas].sort((a, b) => {
      let comparacion = 0;
      
      switch (campo) {
        case 'nombre':
          comparacion = a.name.localeCompare(b.name);
          break;
        case 'score':
          const scoreA = (a.score.teacher + a.score.student) / 2;
          const scoreB = (b.score.teacher + b.score.student) / 2;
          comparacion = scoreA - scoreB;
          break;
        case 'vacantes':
          const vacantesA = a.openings.reduce((sum, o) => sum + o.count, 0);
          const vacantesB = b.openings.reduce((sum, o) => sum + o.count, 0);
          comparacion = vacantesA - vacantesB;
          break;
      }

      return direccion === 'ascendente' ? comparacion : -comparacion;
    });
  }

  // Métodos públicos para actualizar filtros y orden
  actualizarFiltros(filtros: Filtros) {
    console.log('Actualizando filtros:', filtros);
    this.filtrosSubject.next({...filtros});
    // Forzar una nueva emisión de empresas filtradas
    const empresasActuales = this.empresasSubject.value;
    this.empresasSubject.next([...empresasActuales]);
  }

  actualizarOrdenDireccion(direccion: 'ascendente' | 'descendente') {
    this.ordenDireccionSubject.next(direccion);
  }

  actualizarOrdenCampo(campo: 'nombre' | 'score' | 'vacantes') {
    this.ordenCampoSubject.next(campo);
  }

  // Getters para los datos
  getRegiones(): Region[] {
    return this.regionesSubject.value;
  }

  getCategorias(): Category[] {
    return this.categoriasSubject.value;
  }

  getServicios(): Service[] {
    return this.serviciosSubject.value;
  }

  getCiudades(): string[] {
    return this.ciudadesSubject.value;
  }

  // Métodos para actualizar datos relacionados
  actualizarRegionSeleccionada(regionId: string) {
    this.regionsService.getTowns(regionId).subscribe({
      next: (ciudades) => this.ciudadesSubject.next(ciudades.map(ciudad => ciudad.name)),
      error: (error) => console.error('Error cargando ciudades:', error)
    });
  }

  actualizarCategoriaSeleccionada(categoryId: string) {
    this.categoriesService.getServices(categoryId).subscribe({
      next: (servicios) => this.serviciosSubject.next(servicios),
      error: (error) => console.error('Error cargando servicios:', error)
    });
  }
}