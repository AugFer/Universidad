
public abstract class  Empleado extends Persona{
	protected String puesto;
	protected int salario;
	
	public abstract void Salario();
	
	
	public Empleado (String nom, int dni, String puest){
		super(nom, dni);
		setPuesto(puest);
	}
	
	
	public void setPuesto(String p){
		puesto = p;
	}
	public String getPuesto(){
		return puesto;
	}
	
	public void setSalario(int sal){
		salario = sal;
	}
	public int getSalario(){
		return salario;
	}
	
	
	public void Mostrar(){
		super.Mostrar();
		System.out.println("Puesto de trabajo: "+getPuesto());
		System.out.println("Salario: $"+getSalario());
	}

}