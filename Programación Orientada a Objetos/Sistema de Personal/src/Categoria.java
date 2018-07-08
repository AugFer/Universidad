public class Categoria {
	private String categoria;
	private int sueldoBasico;
	
	
	public Categoria(String abc, int basico){
		setCategoria(abc);
		setSueldoBasico(basico);
	}

	
	public void setCategoria(String abc){
		categoria = abc;
	}
	public String getCategoria(){
		return categoria;
	}
	
	public void setSueldoBasico(int bas){
		sueldoBasico = bas;
	}
	public int getSueldoBasico(){
		return sueldoBasico;
	}
}