
public class Administrativo extends Empleado{
	private Categoria categoria;
	private int antigüedad;
	
	public Administrativo(String nom, int dni, String puest, Categoria cat, int ant){
		super(nom, dni, puest);
		setCategoria(cat);
		setAntigüedad(ant);
		this.Salario();
	}
	
	public void setCategoria(Categoria cat){
		categoria = cat;
	}
	public Categoria getCategoria(){
		return categoria;
	}
	
	public void setAntigüedad(int ant){
		antigüedad = ant;
	}
	public int getAntigüedad(){
		return antigüedad;
	}
	
	
	public void Salario(){
		if (antigüedad>5){
			salario = categoria.getSueldoBasico() + (categoria.getSueldoBasico()/2);
		}
		else {
			salario = categoria.getSueldoBasico();
		}
	}
	
	public void Mostrar(){
		super.Mostrar();
		System.out.println("Categoria: "+categoria.getCategoria());
		System.out.println("Antigüedad (años): "+getAntigüedad());
	}
}