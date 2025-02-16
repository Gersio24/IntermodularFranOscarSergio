import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { EmpresaFiltrarOrdenarService } from '../services/empresa-orden.service';
import { Empresa } from '../types';
import { CompanyComponent } from '../company/company.component';

@Component({
  selector: 'app-body',
  standalone: true,
  imports: [CompanyComponent],
  templateUrl: './body.component.html',
  styleUrls: ['./body.component.css']
})
export class BodyComponent implements OnInit, OnDestroy {
  empresas: Empresa[] = [];
  private subscription: Subscription = new Subscription();

  constructor(private empresaService: EmpresaFiltrarOrdenarService) {}

  ngOnInit() {
    this.subscription.add(
      this.empresaService.getEmpresasFiltradasOrdenadas().subscribe(
        empresas => {
          console.log('Empresas filtradas:', empresas);
          this.empresas = empresas;
        }
      )
    );
  }

  ngOnDestroy() {
    this.subscription.unsubscribe();
  }
}