
public class Tecnico extends Empleado{
	private int horas;
	private String titulo;
	
	public Tecnico (String nom, int dni, String puest, int hs, String tit){
		super(nom, dni, puest);
		setHoras(hs);
		setTitulo(tit);
		Salario();
	}
	
	public void setHoras(int hs){
		horas = hs;
	}
	public int getHoras(){
		return horas;
	}
	public void setTitulo(String tit){
		titulo = tit;
	}
	public String getTitulo(){
		return titulo;
	}
	
	public void Salario(){
		setSalario(getHoras()*10); 
	}
}