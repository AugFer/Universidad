import java.util.ArrayList;
import java.util.Iterator;

public class AlmacenTienda {
	private ArrayList<CD> cds = new ArrayList<CD>();
	
	public void almacenar(CD c) {
		cds.add(c);
	}
	
	public void quitarDelAlmacen(CD c) {
		if (cds.contains(c) == true) {
			cds.remove(cds.indexOf(c));
			System.out.println("El CD "+c.getTitulo()+" ha sido eliminado del almacen de la tienda.");
		}
		else {
			System.out.println("El CD "+c.getTitulo()+" no se encuentra en el almacen de la tienda.");
		}
	}
	
	public void consultarAlmacen(CD c) {
		if (cds.contains(c) == true) {
			System.out.println("El CD "+c.getTitulo()+" se encuentra en el almacen de la tienda.");
		}
		else {
			System.out.println("El CD "+c.getTitulo()+" no se encuentra en el almacen de la tienda.");
		}
	}
	
	public void consultarAlmacen(String tit) {	
		Iterator<CD> iter = cds.iterator();
		boolean compa = false;
		while(iter.hasNext()) {
			CD c = iter.next();
			compa = c.getTitulo().equalsIgnoreCase(tit);
		}
		if (compa == true) {
			System.out.println("El CD "+tit+" se encuentra en el almacen de la tienda.");
		}
		else {
			System.out.println("El CD "+tit+" no se encuentra en el almacen de la tienda.");
		}
	}
	
	
	public void mostrarAlmacen() {
		System.out.println("CDs disponibles en la tienda:");
		Iterator<CD> iter = cds.iterator();
		while(iter.hasNext() == true) {
			CD c = iter.next();
			System.out.println(" - "+c.getTitulo());
		}
	}
	
}