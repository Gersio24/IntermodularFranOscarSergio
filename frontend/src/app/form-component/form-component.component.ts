import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormService } from '../services/form.service';
import { FormQuestion } from '../interfaces/form-question.interface';

@Component({
  selector: 'app-form-component',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-component.component.html',
  styleUrl: './form-component.component.scss'
})
export class FormComponentComponent implements OnInit {
  form!: FormGroup;
  questions: FormQuestion[] = [];
  isLoading = true;
  token: string | null = null;

  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private formService: FormService
  ) {}

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.token = params['token'];
      console.log('Token recibido:', this.token);
      if (this.token) {
        this.loadFormQuestions();
      }
    });
  }

  private loadFormQuestions(): void {
    if (!this.token) return;

    this.isLoading = true;
    this.formService.getFormQuestions(this.token).subscribe({
      next: (questions: FormQuestion[]) => {
        console.log('Preguntas recibidas:', questions.map(q => ({
          pregunta: q.question,
          tipo: q.type,
          tipo_lowercase: q.type?.toLowerCase()
        })));
        
        this.questions = questions;
        this.buildForm();
        this.isLoading = false;
      },
      error: (error) => {
        console.error('Error al cargar preguntas:', error);
        this.isLoading = false;
      },
      complete: () => {
        console.log('Petición completada');
        this.isLoading = false;
      }
    });
  }

  private buildForm(): void {
    const group: any = {};
    this.questions.forEach(question => {
      group['question_' + question.id] = [''];
    });
    this.form = this.formBuilder.group(group);
  }

  isStarQuestion(tipo: string): boolean {
    return tipo?.toLowerCase() === 'estrellas';
  }

  isTextareaQuestion(tipo: string): boolean {
    return tipo.toLowerCase() === 'textarea';
  }

  onStarClick(questionId: number, value: number): void {
    console.log('Valor seleccionado:', value);
    this.form.get('question_' + questionId)?.setValue(value);
  }

  onSubmit(event: Event): void {
    event.preventDefault();
    if (this.form.valid && this.token) {
      const answers = Object.keys(this.form.value).map(key => {
        const questionId = key.replace('question_', '');
        return {
          pregunta_id: parseInt(questionId),
          respuesta: this.form.value[key].toString()
        };
      }).filter(answer => answer.respuesta !== '');

      console.log('Enviando datos:', {
        token: this.token,
        answers: answers
      });

      this.formService.submitFormAnswers(this.token, answers).subscribe({
        next: (response) => {
          console.log('Éxito:', response);
          alert('Formulario enviado correctamente');
        },
        error: (error) => {
          console.error('Error detallado:', {
            status: error.status,
            statusText: error.statusText,
            error: error.error,
            message: error.message,
            url: error.url
          });
          alert(`Error al enviar el formulario: ${error.status} ${error.statusText}`);
        }
      });
    }
  }
}
