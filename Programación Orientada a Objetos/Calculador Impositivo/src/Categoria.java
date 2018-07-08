public abstract class Categoria {
	protected String categoria;
	
	public Categoria(String cat){
		setCategoria(cat);
	}
	
	public void setCategoria(String cat){
		categoria = cat;
	}
	public String getCategoria(){
		return categoria;
	}
	
	public abstract double montoVariable(double montoFijo);
}