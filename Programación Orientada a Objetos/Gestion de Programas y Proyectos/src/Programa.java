import java.util.ArrayList;
import java.util.Iterator;

public class Programa {
	private ArrayList<Proyecto> proyectos = new ArrayList<Proyecto>();
	private int a�oInicio, a�oFin;
	private String tema;
	
	public Programa(String tem, int aIni, int aFin, Proyecto proy){
		setTema(tem);
		setA�oInicio(aIni);
		setA�oFin(aFin);
		agregarProyecto(proy);
	}
	
	public void setTema(String tem){
		tema = tem;
	}
	public String getTema(){
		return tema;
	}
	
	public void setA�oInicio(int aIni){
		a�oInicio = aIni;
	}
	public int getA�oInicio(){
		return a�oInicio;
	}
	
	public void setA�oFin(int aFin){
		a�oFin = aFin;
	}
	public int getA�oFin(){
		return a�oFin;
	}
	
	
	public void agregarProyecto(Proyecto proy){
		proyectos.add(proy);
	}
	
	public void quitarProyecto(Proyecto proy){
		if(proyectos.contains(proy)){
			proyectos.remove(proy);
		}
		else{
			System.out.println("El proyecto especificado no se encuentra asociado a �ste programa.");
		}
	}
	
	public void buscarProyectoPorResponsable(Persona resp){
		Iterator<Proyecto> iter = proyectos.iterator();
		System.out.println("Los proyectos dirigidos por "+resp.getNombre()+" son:");
		while(iter.hasNext()){
			Proyecto p = iter.next();
			if (p.responsables.contains(resp)){
				System.out.println(" - "+p.getTema());
			}
		}
	}
	
	public void pryectoMayorImporte(){
		double max=0;
		String nom=null;
		Iterator<Proyecto> iter = proyectos.iterator();
		while(iter.hasNext()){
			Proyecto p = iter.next();
			if(p.getImporte()>max){
				max = p.getImporte();
				nom = p.getTema();
			}
		}
		System.out.println("El proyecto que tiene asignado el mayor importe es: "+nom+" ($"+max+").");
	}	
	
	public void mostrarPrograma(){
		System.out.println("Programa: "+getTema());
		System.out.println("A�o de inicio: "+getA�oInicio());
		System.out.println("A�o de finalizacion: "+getA�oFin());
		System.out.println("");
		System.out.println("Listado de proyectos:");
		Iterator<Proyecto> iter = proyectos.iterator();
		while(iter.hasNext()){
			Proyecto proy = iter.next();
			proy.mostrar();
		}
	}
}