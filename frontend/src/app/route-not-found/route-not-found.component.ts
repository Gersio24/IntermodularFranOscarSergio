import { Component } from '@angular/core';

@Component({
  selector: 'app-route-not-found',
  standalone: true,
  template: `
    <div class="container mt-5 text-center">
      <h1>404</h1>
      <h2>Página no encontrada</h2>
      <p>Usted no puede pasar, por tonto</p>
      <a class="btn btn-primary" href="/" >Volver al inicio</a>
    </div>
  `
})
export class RouteNotFoundComponent {}
