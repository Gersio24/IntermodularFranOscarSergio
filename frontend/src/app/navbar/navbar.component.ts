import { Component, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AbstractAuthService } from '../services/abstarct-auth.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  template: `
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" routerLink="/">Proyecto intermodular</a>

      @if (!isAuthenticated()) {
        <form class="d-flex" (ngSubmit)="onLogin()">
          <input class="form-control me-2" type="text" [(ngModel)]="username" name="username" placeholder="Usuario">
          <input class="form-control me-2" type="password" [(ngModel)]="password" name="password" placeholder="Contraseña">
          <button class="btn btn-light" type="submit">Login</button>
        </form>
      } @else {
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" routerLink="/profile" routerLinkActive="active">Perfil</a>
            </li>
            @if (showDashboard()) {
              <li class="nav-item">
                <a class="nav-link" routerLink="/dashboard" routerLinkActive="active">Dashboard</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" routerLink="/solicitud" routerLinkActive="active">Solicitar Alumnos</a>
              </li>
            }
            @if (isAdmin()) {
                <li class="nav-item">
                  <a class="nav-link" routerLink="/create-company" routerLinkActive="active">Crear Empresa</a>
                </li>
              }
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <span class="nav-link">{{authService.username()}}</span>
            </li>
            <li class="nav-item">
              <button class="btn btn-light" (click)="onLogout()">Cerrar sesión</button>
            </li>
          </ul>
        </div>
      }
    </div>
  </nav>
`
})
export class NavbarComponent {
  username = '';
  password = '';

  constructor(
    public authService: AbstractAuthService,
    private router: Router
  ) {}

  isAuthenticated = computed(() => !!this.authService.username());

  showDashboard = computed(() => {
    const role = this.authService.role();
    return role === 'teacher' || role === 'admin';
  });

  isAdmin = computed(() => this.authService.role() === 'admin');


  onLogin() {
    if (this.username && this.password) {
      this.authService.login(this.username, this.password).subscribe({
        next: () => {
          this.username = '';
          this.password = '';
          this.router.navigate(['/profile']);
        },
        error: (error) => {
          console.error('Error en login:', error);
          alert('Error en el login. Por favor, inténtalo de nuevo.');
        }
      });
    }
  }

  onLogout() {
    this.authService.logout().subscribe({
      next: () => {
        this.router.navigate(['/']);
      },
      error: (error) => console.error('Error en logout:', error)
    });
  }
}
