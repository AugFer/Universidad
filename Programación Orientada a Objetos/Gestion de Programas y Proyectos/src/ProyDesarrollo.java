import java.util.ArrayList;
import java.util.Iterator;

public class ProyDesarrollo extends Proyecto{
	private ArrayList<Empresa> empresas = new ArrayList<Empresa>();
	
	public ProyDesarrollo(String tem, double imp, Persona resp, Empresa emp){
		super(tem, imp, resp);
		agregarEmpresa(emp);
	}
	
	public void agregarEmpresa(Empresa emp){
		empresas.add(emp);
	}
	
	public void quitarEmpresa(Empresa emp){
		if(empresas.contains(emp) == true){
			empresas.remove(emp);
		}
		else{
			System.out.println("La empresa especificada no se encuentra asociada a éste proyecto.");
		}
	}
	
	public void mostrar(){
		super.mostrar();
		Iterator<Empresa> iter = empresas.iterator();
		System.out.println("  Empresas asociadas:");
		while(iter.hasNext()){
			Empresa e = iter.next();
			System.out.println("     - "+e.getNombre()+", (telefono: "+e.getTelefono()+"), direccion: "+e.getDireccion()+".");
		}
		System.out.println("");
	}
}