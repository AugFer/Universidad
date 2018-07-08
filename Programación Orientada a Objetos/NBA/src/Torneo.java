import java.util.ArrayList;
import java.util.Iterator;

public class Torneo {
	private String nombre;
	private int a�o;
	private ArrayList<Equipo> equipos = new ArrayList<Equipo>();
	private ArrayList<Partido> partidos = new ArrayList<Partido>();
	
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setA�o(int a) {
		a�o = a;
	}
	public int getA�o() {
		return a�o;
	}
	
	
	public Torneo(String nom, int a) {
		setNombre(nom);
		setA�o(a);
	}
	
	public void agregarPartido(Partido p) {
		partidos.add(p);
	}
	
	public void agregarEquipo(Equipo e) {
		equipos.add(e);
	}
	
	public void mostrarTorneo() {
		System.out.println("Nombre: "+getNombre());
		System.out.println("A�o: "+getA�o());
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
		
		System.out.println("Partido n�mero "+(x+1)+":");
		p.mostrarPartido();
	}
}
