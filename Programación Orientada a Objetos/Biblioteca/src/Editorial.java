
public class Editorial {
	private String nombre, direccion;
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setDireccion(String d) {
		direccion = d;
	}
	public String getDireccion() {
		return direccion;
	}
	
	
	public Editorial(String nom, String dir) {
		setNombre(nom);
		setDireccion(dir);
	}
	
	public void mostrarEditorial(Editorial e) {
		System.out.println("Nombre: "+e.getNombre());
		System.out.println("Nacionalidad: "+e.getDireccion());
	}	
	
}