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
    <nav class="navbar">
      <div class="container d-flex justify-content-end">
        <div class="button-group">
          <span class="username">{{getUserName()}}</span>
          <button class="btn-small" (click)="onLogout()">Cerrar sesión</button>
        </div>
      </div>
    </nav>
  `,
  styles: [`
    .navbar {
      background-color: white;
      border-bottom: 1px solid #eee;
      padding: 8px 0;
    }

    .container {
      width: 100%;
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
      display: flex;
      justify-content: flex-end;
    }

    .button-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .username {
      font-size: 14px;
      color: #666;
      padding: 4px 8px;
      background-color: #f5f5f5;
      border-radius: 4px;
    }

    .btn-small {
      font-size: 14px;
      padding: 4px 12px;
      border: none;
      border-radius: 4px;
      background: linear-gradient(to right, #F12711, #F5AF19);
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

      &:hover {
        background: linear-gradient(to right, #F5AF19, #F12711);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }
    }
  `]
})
export class NavbarComponent {
  constructor(
    public authService: AbstractAuthService,
    private router: Router
  ) {}

  getUserName(): string {
    const userStr = localStorage.getItem('user');
    if (userStr) {
      try {
        const user = JSON.parse(userStr);
        return user.nombre || 'Usuario';
      } catch (e) {
        console.error('Error parsing user from localStorage:', e);
        return 'Usuario';
      }
    }
    return 'Usuario';
  }

  isAuthenticated = computed(() => {
    return !!localStorage.getItem('user');
  });

  onLogout() {
    console.log('Logout clicked');
    localStorage.removeItem('user');
    this.authService.logout().subscribe({
      next: () => {
        console.log('Logout successful');
        this.router.navigate(['/logout']);
      },
      error: (error) => {
        console.error('Error en logout:', error);
      }
    });
  }
}
