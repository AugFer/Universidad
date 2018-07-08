import java.util.ArrayList;
import java.util.Iterator;

public class Torneo {
	private String nombre;
	private int año;
	private ArrayList<Equipo> equipos = new ArrayList<Equipo>();
	private ArrayList<Partido> partidos = new ArrayList<Partido>();
	
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setAño(int a) {
		año = a;
	}
	public int getAño() {
		return año;
	}
	
	
	public Torneo(String nom, int a) {
		setNombre(nom);
		setAño(a);
	}
	
	public void agregarPartido(Partido p) {
		partidos.add(p);
	}
	
	public void agregarEquipo(Equipo e) {
		equipos.add(e);
	}
	
	public void mostrarTorneo() {
		System.out.println("Nombre: "+getNombre());
		System.out.println("Año: "+getAño());
		System.out.println("Equipos:");
		Iterator<Equipo> iter = equipos.iterator();	
		while (iter.hasNext())
		{
			Equipo e = iter.next();
			System.out.println(e.getNombre());
		}
	}
	
	public void mostrarUnPartido(int n) {
		int x=n-1;
		Partido p = partidos.get(x);
		
		System.out.println("Partido número "+(x+1)+":");
		p.mostrarPartido();
	}
}
