import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, catchError, map, tap } from 'rxjs';
import { Empresa } from '../types';

@Injectable({
  providedIn: 'root'
})
export class HttpCompaniesService {
  private apiUrl = 'http://localhost:8000/api/empresas';

  constructor(private http: HttpClient) {}

  getEmpresas(): Observable<Empresa[]> {
    return this.http.get<any[]>(this.apiUrl).pipe(
      map(empresas => empresas.map(empresa => this.mapearEmpresa(empresa))),
      tap(empresas => console.log('Empresas mapeadas:', empresas)),
      catchError(error => {
        console.error('Error al obtener empresas:', error);
        throw error;
      })
    );
  }

  getEmpresa(id: number): Observable<Empresa> {
    return this.http.get<any>(`${this.apiUrl}/${id}`).pipe(
      map(empresa => this.mapearEmpresa(empresa))
    );
  }

  private mapearEmpresa(data: any): Empresa {
    return {
      id: data.id,
      name: data.nombre,
      cif: data.cif,
      email: data.email,
      phone: data.telefono,
      address: {
        street: data.direccion_calle,
        region: data.direccion_provincia,
        town: data.poblacion,
        position: {
          lat: data.direccion_lat,
          lng: data.direccion_lng
        }
      },
      workingHours: {
        start: data.horario_inicio.substring(0, 5),
        end: data.horario_fin.substring(0, 5),
      },
      image: data.imagen,
      categories: data.categorias,
      services: data.servicios,
      openings: data.vacantes_historico,
      score: {
        teacher: data.puntuacion_profesor,
        student: data.puntuacion_alumno
      },
      historicVacancies: data.vacantes_historico,
      teacherScore: data.puntuacion_profesor,
      studentScore: data.puntuacion_alumno
    };
  }
}
