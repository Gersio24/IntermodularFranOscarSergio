import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { AuthService } from './auth-service.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private authService: AuthService, private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    if (!this.authService.hayUsuario()) {
      this.router.navigate(['/login']);
      return false;
    }

    const userRoles = this.authService.getRoles();
    const allowedRoles = route.data['roles'] as string[];

    if (!allowedRoles.some(role => userRoles.includes(role))) {
      this.router.navigate(['/acceso-denegado']);
      return false;
    }

    return true;
  }
}
