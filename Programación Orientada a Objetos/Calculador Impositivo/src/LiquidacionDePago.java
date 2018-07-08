public class LiquidacionDePago {
	private double montoFijoTotal, montoVariable, montoTotal;
	private String nombreContribuyente;
	private Factura facturaInicial, facturaFinal;
	
	public LiquidacionDePago(String nom, double monFij, double monVar, double monTot, Factura facIni, Factura facFin){
		nombreContribuyente = nom;
		montoFijoTotal = monFij;
		montoVariable = monVar;
		montoTotal = monTot;
		facturaInicial = facIni;
		facturaFinal = facFin;
	}
	
	
	public void nombreDelContribuyente(){
		 System.out.println("Nombre del contribuyente: "+nombreContribuyente);
	}
	
	public void montoFijoTotal(){
		System.out.println("Monto fijo total: $"+montoFijoTotal);
	}
	
	public void montoVariableTotal(){
		System.out.println("Monto variable total: $"+montoVariable);
	}
	
	public void montoAPagar(){
		System.out.println("Monto a pagar: $"+montoTotal);
	}
	
	public void primeraFacturaConsiderada(){
		System.out.println("Primera factura considerada: ");
		System.out.println(" - Numero: "+facturaInicial.getNumero());
		System.out.println(" - Servicio: "+facturaInicial.getServicio());
		System.out.println(" - Monto: $"+facturaInicial.getMonto());
	}
	
	public void ultimaFacturaConsiderada(){
		System.out.println("Ultima factura considerada: ");
		System.out.println(" - Numero: "+facturaFinal.getNumero());
		System.out.println(" - Servicio: "+facturaFinal.getServicio());
		System.out.println(" - Monto: $"+facturaFinal.getMonto());
	}	
}