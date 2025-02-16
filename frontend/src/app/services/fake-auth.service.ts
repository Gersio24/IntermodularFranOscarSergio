import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { AbstractAuthService } from './abstarct-auth.service';
import { IAuth } from '../types';
import { faker } from '@faker-js/faker/locale/es';

@Injectable({
  providedIn: 'root'
})
export class FakeAuthService extends AbstractAuthService {
  login(username: string, password: string): Observable<IAuth> {
    // 80% de probabilidad de éxito
    if (Math.random() < 0.8) {
      const auth: IAuth = {
        username,
        role: faker.helpers.arrayElement(['student', 'teacher', 'business', 'admin']) as IAuth['role'],
        token: faker.string.alphanumeric({ length: 32 })
      };

      // Actualizamos las señales
      this.username.set(auth.username);
      this.role.set(auth.role);
      this.token.set(auth.token);

      return of(auth);
    }

    return throwError(() => new Error('Login fallido'));
  }

  logout(): Observable<boolean> {
    // Limpiamos las señales
    this.username.set(undefined);
    this.role.set(undefined);
    this.token.set(undefined);

    return of(true);
  }
}
