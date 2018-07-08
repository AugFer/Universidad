public class Producto {
	protected double precio;
	protected String marca;

	public Producto(String mar, double pre){
		setMarca(mar);
		setPrecio(pre);
	}

	public double getPrecio() {
		return precio;
	}
	public void setPrecio(double pre) {
		precio = pre;
	}

	public String getMarca() {
		return marca;
	}
	public void setMarca(String mar) {
		marca = mar;
	}	
	
	public void mostrar(){
		System.out.println("Marca: "+getMarca());
		System.out.println("Precio: "+getPrecio());
	}
}