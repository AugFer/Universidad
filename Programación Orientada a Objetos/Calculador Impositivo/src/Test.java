public class Test {
	public static void main(String[] args) {
		
		//Creando categorias
		Limitado limitado = new Limitado("Limitado");
		Completo completo = new Completo("Completo");
		Extendido extendido = new Extendido("Extendido");
		
		//Creando facturas
		Factura f1 = new Factura("Cambio de aceite", 1000, 1);
		Factura f2 = new Factura("Faros halogenos", 750, 2);
		Factura f3 = new Factura("Chapa", 10000, 3);
		Factura f4 = new Factura("Pintura", 8000, 4);
		Factura f5 = new Factura("Limpieza y lavado", 200, 5);
		Factura f6 = new Factura("Cambio de 4 cubiertas", 5500, 6);
		Factura f7 = new Factura("Tanque de NO2", 3200, 7);
		Factura f8 = new Factura("Suspension Hidraulica", 19000, 8);
		Factura f9 = new Factura("Cambio de filtros", 600, 9);
		Factura f10 = new Factura("Bateria", 1050, 10);
		
		//Creando calculador
		Calculador c1 = new Calculador("Augusto Fernandez", completo);
		
		//Agregando facturas al calculador
		c1.agregarFactura(f1);
		c1.agregarFactura(f2);
		c1.agregarFactura(f3);
		c1.agregarFactura(f4);
		c1.agregarFactura(f5);
		c1.agregarFactura(f6);
		c1.agregarFactura(f7);
		c1.agregarFactura(f8);
		c1.agregarFactura(f9);
		c1.agregarFactura(f10);
		
		//Calculando el impuesto
		(c1.calcularImpuesto(1, 10)).nombreDelContribuyente();
		System.out.println();
		(c1.calcularImpuesto(1, 10)).montoFijoTotal();
		(c1.calcularImpuesto(1, 10)).montoVariableTotal();
		(c1.calcularImpuesto(1, 10)).montoAPagar();
		System.out.println();
		(c1.calcularImpuesto(1, 10)).primeraFacturaConsiderada();
		System.out.println();
		(c1.calcularImpuesto(1, 10)).ultimaFacturaConsiderada();
	}
}