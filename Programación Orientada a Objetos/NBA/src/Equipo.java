import java.util.*;


public class Equipo {
	private String nombre;
	private Director dirTec;
	private ArrayList<Jugador> jugadores = new ArrayList<Jugador>();
	
	public void setNombre(String nom) {
		this.nombre = nom;
	}
	public String getNombre() {
		return nombre;
	}
	
	
	public Equipo(String nom, Director dir) {
		setNombre(nom);
		dirTec = dir;
	}
	
	
		public void agregarJugador(Jugador j) {
		jugadores.add(j);
	}
	
	public void mostrarEquipo() {
		System.out.println("Nombre: "+getNombre());
		System.out.println("DT: "+dirTec.getNombre());
		System.out.println("Jugadores:");
		Iterator<Jugador> iter = jugadores.iterator();	
		while (iter.hasNext())
		{
			Jugador j = iter.next();
			System.out.println(j.getNombre());
		}
	}
}