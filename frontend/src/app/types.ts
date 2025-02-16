export interface categoria {
    [categoria: string]: string[]
}

export type role = 'admin' | 'moderator' | 'user';

export interface IAuth {
    username: string;
    role: 'student' | 'teacher' | 'business' | 'admin';
    token: string;
}

export interface Empresa {
    id: number;
    name: string;
    cif: string;
    email: string;
    phone: string;
    address: {
        street: string;
        region: string;
        town: string;
        position: {
            lat: number;
            lng: number;
        }
    };
    workingHours: {
        start: string;
        end: string;
    };
    image: string;
    categories: string[];
    services: string[];
    openings: {
        year: number;
        count: number;
    }[];
    score: {
        teacher: number;
        student: number;
    };
    historicVacancies: any[];
    teacherScore: number;
    studentScore: number;
}

export interface Opening {
    year: number;
    count: number;
}

export interface FiltrosFormElements extends HTMLFormControlsCollection{
    nombre: HTMLInputElement;
    provincia: HTMLSelectElement;
    localidad: HTMLSelectElement;
    vacante: HTMLInputElement;
    categoria: HTMLSelectElement;
    servicio: HTMLSelectElement;
}

export interface Region {
    area: string;
    id: string;
    name: string;
}
  
export interface Town {
    region: string;
    id: string;
    name: string;
}

// export interface Town {
//     [region: string]: string[]
// }

export interface Category {
    id: string;
    name: string;
}
  
export interface Service {
    category: string;
    id: string;
    name: string;
    
}
export interface Filtros {
    nombre: string;
    provincia: string;
    localidad: string;
    vacantes: string;
    categoria: string;
    servicio: string;
  }
export interface Preguntas{
    titulo: string;
    tipo: string;
    order: number;
}

// Añadir alias para Company
export type Company = Empresa;






