public class Autor {
	private String nombre, nacionalidad;
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setNacionalidad(String n) {
		nacionalidad = n;
	}
	public String getNacionalidad() {
		return nacionalidad;
	}
	
	
	public Autor(String nom, String nac) {
		setNombre(nom);
		setNacionalidad(nac);
	}
	
	public void mostrarAutor(Autor a) {
		System.out.println("Nombre: "+a.getNombre());
		System.out.println("Nacionalidad: "+a.getNacionalidad());
	}	
}