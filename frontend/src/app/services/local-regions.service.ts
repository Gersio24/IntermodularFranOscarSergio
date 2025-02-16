import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Region, Town } from '../types';
import { AbstractRegionsService } from './abstract-regions.service';
import regionsData from '../../../regions.json';
import townsData from '../../../towns.json';

@Injectable({
  providedIn: 'root'
})
export class LocalRegionsService extends AbstractRegionsService {
  getRegions(): Observable<Region[]> {
    // Filtramos las regiones del área 10
    const regions = regionsData.filter(region => region.area === '10');
    return of(regions);
  }

  getTowns(regionId: string): Observable<Town[]> {
    // Filtramos las poblaciones de la región especificada
    const towns = townsData.filter(town => town.region === regionId);
    return of(towns);
  }
}
