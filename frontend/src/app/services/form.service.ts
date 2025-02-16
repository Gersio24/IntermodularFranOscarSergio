import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { FormQuestion } from '../interfaces/form-question.interface';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class FormService {
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getFormQuestions(token: string): Observable<FormQuestion[]> {
    const url = `${this.apiUrl}/form/preguntas/${token}`;
    return this.http.get<FormQuestion[]>(url);
  }

  submitFormAnswers(token: string, answers: any[]): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    });

    const body = { answers: answers };
    
    console.log('URL:', `${this.apiUrl}/form/respuestas/${token}`);
    console.log('Datos enviados:', body);

    return this.http.post(
      `${this.apiUrl}/form/respuestas/${token}`, 
      body,
      { headers }
    );
  }
}