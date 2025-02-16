import { Empresa } from "../types";

export abstract class GenerarEmpresas {
    abstract getEmpresas(): Promise<Empresa[]>;
}
