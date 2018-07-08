import java.util.ArrayList;
import java.util.Iterator;

public class ProyPolitico extends Proyecto{
	private ArrayList<Puesto> puestos = new ArrayList<Puesto>();
	
	public ProyPolitico(String tem, double imp, Persona resp){
		super(tem, imp, resp);
	}
	
	public void agregarIntegrante(Puesto p){
		puestos.add(p);
	}
	
	public void quitarIntegrante(Persona per){
		Iterator<Puesto> iter = puestos.iterator();
		while(iter.hasNext()){
			Puesto pues = iter.next();
			if (per.equals(pues.getPersona())){
				puestos.remove(pues);
			}
		}
	}
	
	public void mostrar(){
		super.mostrar();
		Iterator<Puesto> iter = puestos.iterator();
		System.out.println("  Lista de postulantes:");
		while(iter.hasNext()){
			Puesto p = iter.next();
			System.out.println("     - "+p.getPuesto()+": "+((p.getPersona()).getNombre())+".");
		}
		System.out.println("");
	}
}