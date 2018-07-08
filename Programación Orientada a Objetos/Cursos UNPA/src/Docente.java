public class Docente {
	private String nombre, correo;
	private int dni;
	
	
	public void setNombre(String n) {
		nombre = n;
	}
	public String getNombre() {
		return nombre;
	}
	
	public void setCorreo(String c) {
		correo = c;
	}
	public String getCorreo() {
		return correo;
	}
	
	public void setDNI(int d) {
		dni = d;
	}
	public int getDNI() {
		return dni;
	}
	
	
	public Docente(String n, int d, String c) {
		setNombre(n);
		setDNI(d);
		setCorreo(c);
	}
	
}