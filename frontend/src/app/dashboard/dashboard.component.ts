import { Component } from '@angular/core';
import { EmpresaFiltrarOrdenarService } from '../services/empresa-orden.service';
import { FiltersComponent } from '../filters/filters.component';
import { BodyComponent } from '../body/body.component';
import { NavbarComponent } from '../navbar/navbar.component';
import { Observable } from 'rxjs';
import { Empresa } from '../types';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
  imports: [
    FiltersComponent, 
    BodyComponent,
    NavbarComponent,
    RouterModule
  ],
  standalone: true
})
export class DashboardComponent {
  empresasFiltradasOrdenadas: Observable<Empresa[]>;

  constructor(private empresaService: EmpresaFiltrarOrdenarService) {
    this.empresasFiltradasOrdenadas = this.empresaService.getEmpresasFiltradasOrdenadas();
  }

  cambiarOrden(direccion: 'ascendente' | 'descendente') {
    this.empresaService.actualizarOrdenDireccion(direccion);
  }

  cambiarFactorOrden(campo: 'nombre' | 'score' | 'vacantes') {
    this.empresaService.actualizarOrdenCampo(campo);
  }
}