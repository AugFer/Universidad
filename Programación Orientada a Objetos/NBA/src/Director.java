public class Director {
	private String nombre;
	private String nacionalidad;
	
	
	public void setNombre(String nom) {
		this.nombre = nom;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setNacionalidad(String nac) {
		this.nacionalidad = nac;
	}
	public String getNacionalidad() {
		return nacionalidad;
	}
	
	
	public Director(String nom, String nac){
		setNombre(nom);
		setNacionalidad(nac);
	}
}