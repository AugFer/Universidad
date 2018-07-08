public class Prueba
{
	public static void main(String[] args)
	{
	//Creacion del equipo 1
		Director d1 = new Director("Ash Ketchum", "Pueblo Paleta");
		
		Jugador j1 = new Jugador("Augusto", "Argentina", 1.73);
		Jugador j2 = new Jugador("Esteban", "Argentina", 1.78);
		Jugador j3 = new Jugador("Botek", "Provincias Vikingas", 1.82);
		Jugador j4 = new Jugador("Emiliano", "Noruega", 1.84);
		Jugador j5 = new Jugador("Slenndy", "Profundidades del Limbo", 1.73);
	
		Equipo e1 = new Equipo("Madness Kawaii", d1);
		e1.agregarJugador(j1);
		e1.agregarJugador(j2);
		e1.agregarJugador(j3);
		e1.agregarJugador(j4);
		e1.agregarJugador(j5);
		
	//Creacion del equipo 2
		Director d2 = new Director("Kazami Kazuki", "Japon");
		
		Jugador j6 = new Jugador("Shiroe", "Japon", 1.65);
		Jugador j7 = new Jugador("Naotsugu", "Japon", 1.79);
		Jugador j8 = new Jugador("Akatsuki", "Japon", 1.54);
		Jugador j9 = new Jugador("Tetra", "Trapland", 1.66);
		Jugador j10 = new Jugador("Nyanta", "Nekoland", 1.89);
	
		Equipo e2 = new Equipo("Debauchery Tea Party", d2);
		e2.agregarJugador(j6);
		e2.agregarJugador(j7);
		e2.agregarJugador(j8);
		e2.agregarJugador(j9);
		e2.agregarJugador(j10);
		
	//Pruebas
		Partido p1 = new Partido("Los Santos", e1, e2, 105, 98);
		//p1.mostrarPartido();
		Partido p2 = new Partido("Temeria", e1, e2);
		//p2.mostrarPartido();
		
		
		Torneo t1 = new Torneo("Stars League", 2015);
		t1.agregarEquipo(e1);
		t1.agregarEquipo(e2);
		
		t1.agregarPartido(p1);
		t1.agregarPartido(p2);
		
		t1.mostrarTorneo();
		System.out.println();
		t1.mostrarUnPartido(1);
		
		
	}
}