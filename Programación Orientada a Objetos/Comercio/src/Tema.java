public class Tema {
	private String titulo;
	private int año;
	private double duracion;
	
	
	public void setTitulo(String t) {
		this.titulo = t;
	}
	public String getTitulo() {
		return titulo;
	}
	
	public void setAño(int a) {
		this.año = a;
	}
	public int getAño() {
		return año;
	}
	
	public void setDuracion(double d) {
		this.duracion = d;
	}
	public double getDuracion() {
		return duracion;
	}
	
	
	public Tema (String t, int a, double d) {
		setTitulo(t);
		setAño(a);
		setDuracion(d);
	}
	
}