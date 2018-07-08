import java.util.ArrayList;
import java.util.Calendar;
import java.util.Iterator;

public  class Gondola {
	private ArrayList<Lata> latas = new ArrayList<Lata>();
	private ArrayList<Botella> botellas = new ArrayList<Botella>();
	private ArrayList<Canasto> canastos = new ArrayList<Canasto>();
	
	public Gondola(){
	}
	
	public void cantidadDeProductos(){
		System.out.println("Cantidad de latas: "+latas.size());
		System.out.println("Cantidad de botellas: "+botellas.size());
		System.out.println("Cantidad de jabones:");
		
		Iterator<Canasto> iter = canastos.iterator();
		int nro=1;
		while(iter.hasNext()){
			Canasto c = iter.next();
			System.out.println(" - Canasto "+nro+": "+c.cantidadJabones());
			nro++;
		}
	}
	 
	public void removerLatasVencidas(){
		Iterator<Lata> iter = latas.iterator();
		Calendar fecha = Calendar.getInstance();
		while(iter.hasNext()){
			Lata l = iter.next();
			if((l.getFechaVencimiento()).before(fecha)){
				iter.remove();
			}
		}
	}
	
	public void agregarLata(Lata l){
		latas.add(l);
	}
	
	public void agregarBotella(Botella b){
		botellas.add(b);
	}
	
	public void agregarCanasto(Canasto c){
		canastos.add(c);
	}
}