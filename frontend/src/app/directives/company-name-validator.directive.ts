import { HttpClient } from '@angular/common/http';
import { Directive, Inject } from '@angular/core';
import { AbstractControl, NG_ASYNC_VALIDATORS, AsyncValidator, ValidationErrors } from '@angular/forms';
import { Observable, catchError, map, of } from 'rxjs';
import { API_URL } from '../tokens/api-url.token';
import { Empresa } from '../types';

@Directive({
  selector: '[company-name-available]',
  standalone: true,
  providers: [{provide: NG_ASYNC_VALIDATORS, useExisting: CompanyNameValidatorDirective, multi: true}],
})
export class CompanyNameValidatorDirective implements AsyncValidator {
  constructor(
    private http: HttpClient,
    @Inject(API_URL) private apiUrl: string
  ) {}

  validate(control: AbstractControl): Observable<ValidationErrors | null> {
    if (!control.value) return of(null);
    return this.http.get<Empresa[]>(`${this.apiUrl}/companies`).pipe(
      map(companies => {
        const exists = companies.some(company => 
          company.name.toLowerCase() === control.value.toLowerCase()
        );
        return exists ? { 'companyExists': true } : null;
      }),
      catchError(() => of(null))
    );
  }
}