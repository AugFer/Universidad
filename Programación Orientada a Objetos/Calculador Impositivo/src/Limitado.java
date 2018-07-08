public class Limitado extends Categoria {
	
	public Limitado(String cat){
		super(cat);
	}
	
	public double montoVariable(double monto){
		double montoVariable=0;
		montoVariable = ((monto*0.5)/100);
		return montoVariable;
	}
}