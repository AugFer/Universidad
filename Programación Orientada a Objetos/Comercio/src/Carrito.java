import java.util.ArrayList;
import java.util.Iterator;

public class Carrito {
	private ArrayList<CD> carro = new ArrayList<CD>();
	private double importe = 0;
	
	
	public void setImporte(double i) {
		importe = i;
	}
	public double getImporte() {
		return importe;
	}
	
	
	public void agregarCD (CD c) {
		carro.add(c);
		System.out.println("El CD ''"+c.getTitulo()+"'' ha sido agregado al carro de compras.");
	}
	
	public void quitarCD(CD c) {
		if (carro.contains(c) == true) {
			int x = carro.indexOf(c);
			carro.remove(x);
			System.out.println("El CD ''"+c.getTitulo()+"'' fue removido del carro de compras.");
		}
		else {
			System.out.println("El CD indicado no se encuentra en el carro de compras.");
		}
	}
	
	public void importeTotal() {
		Iterator<CD> iter = carro.iterator();
		double x = 0;
		while(iter.hasNext()) {
			CD c = iter.next();
			x = x + c.getPrecio();
		}
		importe = x;
		System.out.println("El importe total es: "+getImporte());
	}
	
	public void mostrarCarro() {
		System.out.println("CDs en el carro de compras:");
		Iterator<CD> iter = carro.iterator();
		int x = 1;
		while(iter.hasNext()) {
			CD c = iter.next();
			System.out.println(x+" - "+c.getTitulo());
		}
		System.out.println("");
		importeTotal();
	}
	
}