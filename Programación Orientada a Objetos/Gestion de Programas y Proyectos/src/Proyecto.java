import java.util.ArrayList;
import java.util.Iterator;

public class Proyecto {
	
	protected String tema;
	protected double importe;
	protected ArrayList<Persona> responsables = new ArrayList<Persona>();
	
	public Proyecto(String tem, double imp, Persona resp){
		setTema(tem);
		setImporte(imp);
		agregarResponsable(resp);
	}
	
	public void setTema(String tem){
		tema = tem;
	}
	public String getTema(){
		return tema;
	}
	
	public void setImporte(double imp){
		importe = imp;
	}
	public double getImporte(){
		return importe;
	}
	
	
	public void agregarResponsable(Persona resp){
		responsables.add(resp);
	}
	
	public void quitarResponsable(Persona resp){
		if (responsables.contains(resp) == true){
			responsables.remove(resp);
		}
		else{
			System.out.println("La persona ingresada no se encuentra entre los responsables de éste proyecto.");
		}
	}
	
	public void mostrar(){
		System.out.println("  Proyecto: "+getTema());
		System.out.println("  Importe: $"+getImporte());
		System.out.println("  Responsable/s del proyecto:");
		Iterator<Persona> iter = responsables.iterator();
		while(iter.hasNext()){
			Persona p = iter.next();
			System.out.println("     - "+p.getNombre()+" (DNI: "+p.getDNI());
		}
	}
}