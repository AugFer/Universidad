
public class Persona {
	protected String nombre;
	protected int dni;
	
	
	public Persona (String nom, int dni){
		setNombre(nom);
		setDNI(dni);
	}
	
	
	public void setNombre(String n){
		nombre = n;
	}
	public String getNombre(){
		return nombre;
	}
	
	public void setDNI(int d){
		dni = d;
	}
	public int getDNI(){
		return dni;
	}
	
	
	public void Mostrar(){
		System.out.println("Nombre: "+getNombre());
		System.out.println("DNI: "+getDNI());
	}
}