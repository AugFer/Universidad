import java.util.ArrayList;
import java.util.Iterator;

public class CD {
	private String titulo;
	private double precio;
	private Artista interprete;
	private ArrayList<Tema> temas = new ArrayList<Tema>();
	
	
	public void setTitulo(String titulo) {
		this.titulo = titulo;
	}
	public String getTitulo() {
		return titulo;
	}
	
	public void setPrecio(double p) {
		precio = p;
	}
	public double getPrecio() {
		return precio;
	}
	
	
	public CD (String t, Artista i, double p) {
		setTitulo(t);
		interprete = i;
		setPrecio(p);
	}
	
	
	public void agregarTema(Tema t) {
		temas.add(t);
		System.out.println("El tema ''"+t.getTitulo()+"'' ha sido agregado al TrackList del CD ''"+getTitulo()+"''.");
	}
	
	public void quitarTema(Tema t) {
		if (temas.contains(t) == true) {
			int x = temas.indexOf(t);
			temas.remove(x);
			System.out.println("El tema ''"+t.getTitulo()+"'' ha sido eliminado del TrackList del CD ''"+getTitulo()+"''.");
		}
	}
	
	public void mostrarCD() {
		System.out.println("Titulo: "+getTitulo());
		System.out.println("Artista: "+interprete.getNombre());
		System.out.println("Precio: "+getPrecio());
		System.out.println("TrackList:");
		Iterator<Tema> iter = temas.iterator();
		int x = 1;
		while(iter.hasNext()) {
			Tema t = iter.next();
			System.out.println(x+" - "+t.getTitulo());
			x = x+1;
		}
	}
	
}