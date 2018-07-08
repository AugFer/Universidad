import java.util.ArrayList;
import java.util.Iterator;

public class Curso {
	private int codigo;
	private String nombre;
	private ArrayList<Docente> docentes = new ArrayList<Docente>();
	private ArrayList<Alumno> alumnos = new ArrayList<Alumno>();
	
	
	public void setCodigo(int c) {
		this.codigo = c;
	}
	public int getCodigo() {
		return codigo;
	}
	
	public void setNombre(String n) {
		this.nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	
	public Curso(String n, int c) {
		setNombre(n);
		setCodigo(c);
	}
	
	public void asignarDocente(Docente d) {
		docentes.add(d);
		System.out.println("El docente "+d.getNombre()+" ha sido asignado al curso "+this.getNombre());
	}
	
	public void removerDocente(Docente d) {
		if (docentes.contains(d) == true) {
			docentes.remove(docentes.indexOf(d));
			System.out.println("El docente "+d.getNombre()+" ha sido eliminado del curso "+this.getNombre());
		}
		else{
			System.out.println("El docente "+d.getNombre()+" no se encuentra en éste curso.");
		}
	}
	
	public void inscribirAlumno(Alumno a) {
		alumnos.add(a);
	}
	
	public void removerAlumno(Alumno a) {
		if(alumnos.contains(a) == true) {
			alumnos.remove(alumnos.indexOf(a));
		}
	}
	
	public void mostrarCurso() {
		System.out.println("Codigo: "+this.getCodigo());
		System.out.println("Nombre: "+this.getNombre());
		System.out.println("Docente/s a cargo:");
		
		Iterator<Docente> iter = docentes.iterator();
		while(iter.hasNext() == true) {
			Docente d = iter.next();
			System.out.println(" - "+d.getNombre());
		}
		System.out.println("");
		if (alumnos.isEmpty() == true) {
			System.out.println("No hay alumnos inscriptos.");
		}
		else {
			System.out.println("Alumnos inscriptos:");
			Iterator<Alumno> iter2 = alumnos.iterator();
			while(iter.hasNext() == true) {
				Alumno a = iter2.next();
				System.out.println(" - "+a.getNombre());
			}
		}
	}
	
}