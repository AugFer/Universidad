import java.util.Calendar;

public class Prueba {
	public static void main(String[] args) {
		//Creando fechas de vencimiento
		Calendar d1 = Calendar.getInstance();
		Calendar d2 = Calendar.getInstance();
		Calendar d3 = Calendar.getInstance();
		Calendar d4 = Calendar.getInstance();
		Calendar d5 = Calendar.getInstance();
		Calendar d6 = Calendar.getInstance();
		Calendar d7 = Calendar.getInstance();
		Calendar d8 = Calendar.getInstance();
		
		d1.set(2015, Calendar.SEPTEMBER, 5);
		d2.set(2015, Calendar.MARCH, 1);
		d3.set(2015, Calendar.APRIL, 9);
		d4.set(2015, Calendar.OCTOBER, 1);
		d5.set(2015, Calendar.OCTOBER, 2);
		d6.set(2015, Calendar.DECEMBER, 22);
		d7.set(2015, Calendar.JUNE, 3);
		d8.set(2015, Calendar.DECEMBER, 25);
		
		//Creando latas
		Lata l1 = new Lata("Arcor", 15.45, d1);
		Lata l2 = new Lata("Arcor", 15.45, d2);
		Lata l3 = new Lata("Arcor", 15.45, d3);
		Lata l4 = new Lata("Arcor", 15.45, d4);
		Lata l5 = new Lata("Arcor", 15.45, d5);
		Lata l6 = new Lata("Arcor", 15.45, d6);
		Lata l7 = new Lata("Arcor", 15.45, d7);
		Lata l8 = new Lata("Arcor", 15.45, d8);
		
		//Creando botellas
		Botella b1 = new Botella("Manaos", 9.99);
		Botella b2 = new Botella("7-UP", 21.50);
		Botella b3 = new Botella("Mirinda", 19.99);
		Botella b4 = new Botella("Sprite", 20.50);
		Botella b5 = new Botella("Paso de los Toros", 14.00);
		Botella b6 = new Botella("Fanta", 17.50);
		
		//Creando jabones
		Jabon j1 = new Jabon("Dove", 1.99);
		Jabon j2 = new Jabon("Dove", 1.99);
		Jabon j3 = new Jabon("Dove", 1.99);
		Jabon j4 = new Jabon("Axe", 2.50);
		Jabon j5 = new Jabon("Axe", 2.50);
		Jabon j6 = new Jabon("Axe", 2.50);
		Jabon j7 = new Jabon("Axe", 2.50);
		Jabon j8 = new Jabon("Rexona", 1.55);
		Jabon j9 = new Jabon("Rexona", 1.55);
		Jabon j10 = new Jabon("Rexona", 1.55);
		Jabon j11 = new Jabon("Rexona", 1.55);
		
		//Creando gondola
		Gondola g1 = new Gondola();
		
		//Creando canastos
		Canasto c1 = new Canasto();
		Canasto c2 = new Canasto();
		Canasto c3 = new Canasto();
		
		//Agregando jabones en los canastos
		c1.agregarJabones(j1);
		c1.agregarJabones(j2);
		c1.agregarJabones(j3);
		c2.agregarJabones(j4);
		c2.agregarJabones(j5);
		c2.agregarJabones(j6);
		c2.agregarJabones(j7);
		c3.agregarJabones(j8);
		c3.agregarJabones(j9);
		c3.agregarJabones(j10);
		c3.agregarJabones(j11);
		
		//Agregando canastos a la gondola
		g1.agregarCanasto(c1);
		g1.agregarCanasto(c2);
		g1.agregarCanasto(c3);
		
		//Agregando latas
		g1.agregarLata(l1);
		g1.agregarLata(l2);
		g1.agregarLata(l3);
		g1.agregarLata(l4);
		g1.agregarLata(l5);
		g1.agregarLata(l6);
		g1.agregarLata(l7);
		g1.agregarLata(l8);
		
		//Agregando botellas
		g1.agregarBotella(b1);
		g1.agregarBotella(b2);
		g1.agregarBotella(b3);
		g1.agregarBotella(b4);
		g1.agregarBotella(b5);
		g1.agregarBotella(b6);
		
		//Operando
		g1.cantidadDeProductos();
		System.out.println();
		g1.removerLatasVencidas();
		System.out.println();
		g1.cantidadDeProductos();
		System.out.println();
		
	}
}