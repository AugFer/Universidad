public class Socio {
	private String nombre, telefono;
	private int numero = 0;
	
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setTelefono(String t) {
		telefono = t;
	}
	public String getTelefono() {
		return telefono;
	}
	
	public int getNumero() {
		return numero;
	}
	
	
	public Socio(String nom, String tel) {
		setNombre(nom);
		setTelefono(tel);
		numero = numero + 1;
	}
	
	public void mostrarSocio(Socio s) {
		System.out.println("Numero de socio: "+s.getNumero());
		System.out.println("Nombre: "+s.getNombre());
		System.out.println("Telefono: "+s.getTelefono());
	}
		
}