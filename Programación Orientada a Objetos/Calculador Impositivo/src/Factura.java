public class Factura {
	private int numero;
	private String servicio;
	private double monto;
	
	public Factura(String serv, double mon, int num){
		setServicio(serv);
		setMonto(mon);
		setNumero(num);
	}
	
	public int getNumero() {
		return numero;
	}

	public void setNumero(int num) {
		numero = num;
	}

	public String getServicio() {
		return servicio;
	}

	public void setServicio(String serv) {
		servicio = serv;
	}

	public double getMonto() {
		return monto;
	}

	public void setMonto(double mon) {
		monto = mon;
	}
}