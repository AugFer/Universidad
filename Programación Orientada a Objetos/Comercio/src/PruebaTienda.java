public class PruebaTienda {
	public static void main(String[] args) {
		//Creacion de artistas
		Artista a1 = new Artista ("Robbie Williams", "Inglaterra");
		Artista a2 = new Artista ("Mix", "Argentina");
		
		//Creacion de temas
		Tema t1 = new Tema ("Angel", 2004, 3.52);
		Tema t2 = new Tema ("Feel", 2004, 3.36);
		Tema t3 = new Tema ("Taco Powa", 2015, 2.37);
		Tema t4 = new Tema ("Conecction", 2015, 3.14);
		
		//Creacion de CDs
		CD c1 = new CD ("Greatest Hits", a1, 9.99);
		CD c2 = new CD ("Madness Returns", a2, 14.99);
		
		//Creacion del almacen de la tienda
		AlmacenTienda almacen = new AlmacenTienda();
		
		//Agregar temas a un CD
		c1.agregarTema(t1);
		c1.agregarTema(t2);
		c2.agregarTema(t3);
		c2.agregarTema(t4);
		
		//Creacion del cerrito de compras
		Carrito carro = new Carrito ();
		
		//Uso de carrito de compras
		carro.agregarCD(c1);
		carro.agregarCD(c2);
		
		carro.mostrarCarro();
		
		//Uso del Almacen de la tienda
		almacen.almacenar(c1);
		almacen.almacenar(c2);
		
		almacen.mostrarAlmacen();
		
		almacen.consultarAlmacen("Madness Returns");
		almacen.consultarAlmacen(c1);
		almacen.consultarAlmacen("Hells Metallic");
	}

}