public class Persona {
	private String nombre;
	private int dni;
	
	public Persona(String nom, int d){
		setNombre(nom);
		setDNI(d);
	}
	
	public void setNombre(String nom){
		nombre = nom;
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
}