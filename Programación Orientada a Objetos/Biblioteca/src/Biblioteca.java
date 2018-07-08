import java.util.ArrayList;
//import java.util.Iterator;

public class Biblioteca {
	private String nombre;
	private ArrayList<Socio> socios = new ArrayList<Socio>();
	private ArrayList<Libro> libros = new ArrayList<Libro>();
	
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	
	public Biblioteca(String nom) {
		setNombre(nom);
	}
	
	
	public void agregarLibro(Libro l) {
		libros.add(l);
	}
	
	public void agregarSocio(Socio s) {
		socios.add(s);
	}
	
	
	public void quitarLibro(Libro l) {
		if (libros.contains(l) == true) {
			libros.remove(libros.indexOf(l));
		}
		else {
			System.out.println("El libro especificado no se encuentra en la biblioteca.");
		}
	}
	
	public void quitarSocio(Socio s) {
		if (socios.contains(s) == true) {
			socios.remove(socios.indexOf(s));
		}
		else {
			System.out.println("El socio especificado no se encuentra en la biblioteca.");
		}
	}
	
	public void cantidadSocios() {
		if (socios.isEmpty() == true) {
			System.out.println("La biblioteca aún no cuenta con ningun socio registrado.");
		}
		else {
			System.out.println("La cantidad de socios con los que cuenta actualmente la biblioteca es de: "+socios.size()+".");
		}
	}
	
//	public void busquedaPorEditorial(Editorial e) {
//		Iterator<Libro> iter = libros.iterator();	
//	}
	
//	public void busquedaPorAutor(Editorial e) {
//		Iterator<Libro> iter = libros.iterator();
//	}
}