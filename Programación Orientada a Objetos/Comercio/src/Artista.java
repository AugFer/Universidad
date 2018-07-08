public class Artista {
	private String nombre, nacionalidad;
	
	
	public void setNombre(String n) {
		this.nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setNacionalidad(String n) {
		this.nacionalidad = n;
	}
	public String getNacionalidad() {
		return nacionalidad;
	}
	
	
	public Artista (String nom, String nac) {
		setNombre(nom);
		setNacionalidad(nac);
	}
	
}