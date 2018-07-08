import java.util.Calendar;

public class Lata extends Producto{
	private Calendar fechaVencimiento;
	
	public Lata(String mar, double pre, Calendar fv){
		super(mar, pre);
		setFechaVencimiento(fv);
	}
	
	public Calendar getFechaVencimiento() {
		return fechaVencimiento;
	}
	public void setFechaVencimiento(Calendar fv) {
		fechaVencimiento = fv;
	}
	
	public void mostrar(){
		super.mostrar();
		System.out.println("Fecha de Vencimiento: "+fechaVencimiento.get(Calendar.DAY_OF_MONTH)+"/"+fechaVencimiento.get(Calendar.MONTH)+"/"+fechaVencimiento.get(Calendar.YEAR));
	}
}