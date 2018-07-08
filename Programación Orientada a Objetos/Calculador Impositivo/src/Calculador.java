import java.util.ArrayList;
import java.util.Iterator;

public class Calculador {
	private Categoria categoria;
	private String nombre;
	private ArrayList<Factura> facturas = new ArrayList<Factura>();
	
	public Calculador(String nom, Categoria cat){
		setNombre(nom);
		setCategoria(cat);
	}
	
	public Categoria getCategoria() {
		return categoria;
	}
	public void setCategoria(Categoria cat) {
		categoria = cat;
	}

	public String getNombre() {
		return nombre;
	}
	public void setNombre(String nom) {
		nombre = nom;
	}
	
	public void agregarFactura(Factura f){
		facturas.add(f);
	}

	public LiquidacionDePago calcularImpuesto(int min, int max){
		double montoFijo=0, montoVariable=0, montoTotal=0;
		Factura facturaInicial=null, facturaFinal=null;
		int i = 0;
		Iterator<Factura> iter = facturas.iterator();
		while(iter.hasNext()){
			Factura f = iter.next();	
			if(f.getNumero()>=min && f.getNumero()<=max){
				i++;
				montoFijo = montoFijo + f.getMonto() + 5;
				montoVariable = montoVariable + (categoria.montoVariable(f.getMonto()));
				if(i==1){
					facturaInicial = f;
					facturaFinal = f;
				}
				else{
					facturaFinal = f;
				}
			}
		}
		montoTotal = montoFijo + montoVariable;
		LiquidacionDePago liquidacion = new LiquidacionDePago(getNombre(), montoFijo, montoVariable, montoTotal, facturaInicial, facturaFinal);
		return liquidacion;
	}
}