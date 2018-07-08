public class Extendido extends Categoria{

	public Extendido(String cat){
		super(cat);
	}

	public double montoVariable(double monto){
		double montoVariable=0;
		if(monto>5000){
			montoVariable = 10 + ((monto*50)/100);
		}
		return montoVariable;
	}
}