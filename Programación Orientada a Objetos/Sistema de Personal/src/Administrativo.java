
public class Administrativo extends Empleado{
	private Categoria categoria;
	private int antig�edad;
	
	public Administrativo(String nom, int dni, String puest, Categoria cat, int ant){
		super(nom, dni, puest);
		setCategoria(cat);
		setAntig�edad(ant);
		this.Salario();
	}
	
	public void setCategoria(Categoria cat){
		categoria = cat;
	}
	public Categoria getCategoria(){
		return categoria;
	}
	
	public void setAntig�edad(int ant){
		antig�edad = ant;
	}
	public int getAntig�edad(){
		return antig�edad;
	}
	
	
	public void Salario(){
		if (antig�edad>5){
			salario = categoria.getSueldoBasico() + (categoria.getSueldoBasico()/2);
		}
		else {
			salario = categoria.getSueldoBasico();
		}
	}
	
	public void Mostrar(){
		super.Mostrar();
		System.out.println("Categoria: "+categoria.getCategoria());
		System.out.println("Antig�edad (a�os): "+getAntig�edad());
	}
}