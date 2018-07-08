public class Test {
	public static void main(String[] args) {
		// Creacion de personas
		Persona persona1 = new Persona("Augusto Fernandez", 36590282);
		Persona persona2 = new Persona("Makina Irisu", 39642159);
		Persona persona3 = new Persona("Juan Diaz", 18649578);
		
		//Creacion de empresas
		Empresa e1 = new Empresa("R-Security", "Japan", "777-5-168947");
		Empresa e2 = new Empresa("NEET", "EEUU", "555-27-364976");
		
		//Creacion de puestos
		Puesto puesto1 = new Puesto("CEO", persona1);
		Puesto puesto2 = new Puesto("Presidente", persona2);
		
		//Creacion de proyectos de desarrollo
		ProyDesarrollo proyDes1 = new ProyDesarrollo("Security System's", 750000, persona3, e1);
		
		//Agregar empresas en proyectos de desarrollo
		proyDes1.agregarEmpresa(e2);
		
		//Creacion de proyectos politicos
		ProyPolitico proyPoli1 = new ProyPolitico("NAVER", 850000, persona1);
		
		//Agregar postulantes en proyectos politicos
		proyPoli1.agregarIntegrante(puesto2);
		
		//Creacion de programas
		Programa programa1 = new Programa("Tea Party", 2015, 2022, proyDes1);
		
		//Agregar proyectos a un programa
		programa1.agregarProyecto(proyPoli1);
		
		//Ejecutando mensajes
		programa1.mostrarPrograma();
		programa1.buscarProyectoPorResponsable(persona3);
		programa1.buscarProyectoPorResponsable(persona1);
		programa1.pryectoMayorImporte();
	}
}