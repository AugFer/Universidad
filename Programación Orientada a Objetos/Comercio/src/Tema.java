public class Tema {
	private String titulo;
	private int a�o;
	private double duracion;
	
	
	public void setTitulo(String t) {
		this.titulo = t;
	}
	public String getTitulo() {
		return titulo;
	}
	
	public void setA�o(int a) {
		this.a�o = a;
	}
	public int getA�o() {
		return a�o;
	}
	
	public void setDuracion(double d) {
		this.duracion = d;
	}
	public double getDuracion() {
		return duracion;
	}
	
	
	public Tema (String t, int a, double d) {
		setTitulo(t);
		setA�o(a);
		setDuracion(d);
	}
	
}