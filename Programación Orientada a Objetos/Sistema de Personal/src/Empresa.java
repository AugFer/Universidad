import java.util.ArrayList;
import java.util.Iterator;

public class Empresa {
	private String nombre, direccion, telefono;
	private ArrayList<Administrativo> personalAdministrativo = new ArrayList<Administrativo>();
	private ArrayList<Tecnico> personalTecnico = new ArrayList<Tecnico>();
	
	public Empresa(String nom, String dir, String tel){
		setNombre(nom);
		setDireccion(dir);
		setTelefono(tel);
	}
	
	public void setNombre(String nom){
		nombre = nom;
	}
	public String getNombre(){
		return nombre;
	}
	public void setDireccion(String dir){
		direccion = dir;
	}
	public String getDireccion(){
		return direccion;
	}
	public void setTelefono(String tel){
		telefono = tel;
	}
	public String getTelefono(){
		return telefono;
	}
	
	
	public void agregarPersonalAdministrativo(Administrativo a){
		personalAdministrativo.add(a);
	}
	
	public void agregarPersonalTecnico(Tecnico t){
		personalTecnico.add(t);
	}
	
	public void removerPersonalAdminsitrativo(Administrativo a){
		if(personalAdministrativo.contains(a)){
			personalAdministrativo.remove(personalAdministrativo.indexOf(a));
		}
		else{
			System.out.println("El empleado solicitado no se encuentra entre el personal administrativo registrado.");
		}
	}
	
	public void removerPersonalTecnico(Tecnico t){
		if(personalTecnico.contains(t)){
			personalTecnico.remove(personalTecnico.indexOf(t));
		}
		else{
			System.out.println("El empleado solicitado no se encuentra entre el personal tecnico registrado.");
		}
	}
	
	public void mostrarListaDePersonal(){
		Iterator<Administrativo> iterAdmin = personalAdministrativo.iterator();
		System.out.println("Empleados administrativos:");
		while(iterAdmin.hasNext()){
			Administrativo a = iterAdmin.next();
			System.out.println(" - "+a.getNombre());
		}
		System.out.println("");
		Iterator<Tecnico> iterTec = personalTecnico.iterator();
		System.out.println("Empleados tecnicos:");
		while(iterTec.hasNext()){
			Tecnico t = iterTec.next();
			System.out.println(" - "+t.getNombre());
		}
	}
	
	public void mostrarGastosTotales(){
		int gastosTotales = 0;
		Iterator<Administrativo> iterAdmin = personalAdministrativo.iterator();
		System.out.println("Empleados administrativos:");
		while(iterAdmin.hasNext()){
			Administrativo a = iterAdmin.next();
			gastosTotales = gastosTotales + a.getSalario();
			System.out.println(" - "+a.getNombre()+": $"+a.getSalario());
		}
		System.out.println("");
		Iterator<Tecnico> iterTec = personalTecnico.iterator();
		System.out.println("Empleados tecnicos:");
		while(iterTec.hasNext()){
			Tecnico t = iterTec.next();
			gastosTotales = gastosTotales + t.getSalario();
			System.out.println(" - "+t.getNombre()+": $"+t.getSalario());
		}
		System.out.println("Gastos totales: $"+gastosTotales);
	}
}