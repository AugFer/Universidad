public class Completo extends Categoria{

	public Completo(String cat){
		super(cat);
	}
	
	public double montoVariable(double monto){
		double montoVariable=0;
		if(monto>5000){
			montoVariable = ((monto*50)/100);
		}
		return montoVariable;
	}
}