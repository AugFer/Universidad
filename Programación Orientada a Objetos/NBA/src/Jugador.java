public class Jugador {
	private String nombre;
	private String nacionalidad;
	private double altura;
	
	
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

	public void setAltura(double alt) {
		this.altura = alt;
	}
	public double getAltura() {
		return altura;
	}

	
	public Jugador(String nom, String nac, double alt) {
		setNombre(nom);
		setNacionalidad(nac);
		setAltura(alt);
	}
}