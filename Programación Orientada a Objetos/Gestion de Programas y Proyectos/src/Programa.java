import java.util.ArrayList;
import java.util.Iterator;

public class Programa {
	private ArrayList<Proyecto> proyectos = new ArrayList<Proyecto>();
	private int añoInicio, añoFin;
	private String tema;
	
	public Programa(String tem, int aIni, int aFin, Proyecto proy){
		setTema(tem);
		setAñoInicio(aIni);
		setAñoFin(aFin);
		agregarProyecto(proy);
	}
	
	public void setTema(String tem){
		tema = tem;
	}
	public String getTema(){
		return tema;
	}
	
	public void setAñoInicio(int aIni){
		añoInicio = aIni;
	}
	public int getAñoInicio(){
		return añoInicio;
	}
	
	public void setAñoFin(int aFin){
		añoFin = aFin;
	}
	public int getAñoFin(){
		return añoFin;
	}
	
	
	public void agregarProyecto(Proyecto proy){
		proyectos.add(proy);
	}
	
	public void quitarProyecto(Proyecto proy){
		if(proyectos.contains(proy)){
			proyectos.remove(proy);
		}
		else{
			System.out.println("El proyecto especificado no se encuentra asociado a éste programa.");
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
		System.out.println("Año de inicio: "+getAñoInicio());
		System.out.println("Año de finalizacion: "+getAñoFin());
		System.out.println("");
		System.out.println("Listado de proyectos:");
		Iterator<Proyecto> iter = proyectos.iterator();
		while(iter.hasNext()){
			Proyecto proy = iter.next();
			proy.mostrar();
		}
	}
}