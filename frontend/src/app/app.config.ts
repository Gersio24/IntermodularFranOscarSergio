import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';
import { routes } from './app.routes';
import { provideHttpClient, withInterceptors } from '@angular/common/http';
import { authInterceptor } from './intercecptors/auth.interceptor';
import { API_URL } from './tokens/api-url.token';
import { AbstractAuthService } from './services/abstarct-auth.service';
import { HttpAuthService } from './services/http-auth.service';
import { FakeAuthService } from './services/fake-auth.service';


export const appConfig: ApplicationConfig = {
  providers: [
    provideRouter(routes),
    provideHttpClient(withInterceptors([authInterceptor])),
    { provide: API_URL, useValue: 'http://localhost:8000' },
    { provide: AbstractAuthService, useClass: FakeAuthService },

  ]
};
