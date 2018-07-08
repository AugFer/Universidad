public class CargaDeDatos
{
	public static void main(String[] args)
	{
		//Creacion de alumnos
		Alumno a1 = new Alumno("Augusto Fernandez", 36590282, "madnesskawaii@outlook.com");
		Alumno a2 = new Alumno("Esteban Balliriain", 37268954, "esteban.b@outlook.com");
		Alumno a3 = new Alumno("Christian Botek", 35785169, "c_botek@outlook.com");
		
		//Creacion de docentes
		Docente d1 = new Docente("Alejandra Carrizo", 20349786, "ale_carrizo@outlook.com");
		Docente d2 = new Docente("Analia Pires", 19326987, "analia-pires@outlook.com");
		
		//Creacion y uso de cursos
		Curso c1 = new Curso("Programacion Orientada a Objetos", 201);
		
		c1.asignarDocente(d1);
		c1.asignarDocente(d2);
		
		c1.inscribirAlumno(a1);
		c1.inscribirAlumno(a2);
		c1.inscribirAlumno(a3);
		
		c1.mostrarCurso();
		
		//Creacion y usos de Registros
		Registro r1 = new Registro(a1, c1, "aprobado");
		Registro r2 = new Registro(a2, c1, "desaprobado");
		Registro r3 = new Registro(a3, c1, "aprobado");
		
		r1.condicionAlumno();
		r2.condicionAlumno();
		r3.condicionAlumno();
		
		//Creacion y muestra de cursos
		UNPA u = new UNPA();
		u.agregarCurso(c1);
		
		u.ofrecimientoCursos();
		
	}
}