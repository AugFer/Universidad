public class Partido {
	private String lugar;
	private Equipo equipo1, equipo2;
	private int resultado1, resultado2;
	
	
	public void setLugar(String lug) {
		this.lugar = lug;
	}
	public String getLugar() {
		return lugar;
	}
	
	
	public Partido(String lug, Equipo e1, Equipo e2, int r1, int r2) {
		setLugar(lug);
		equipo1 = e1;
		equipo2 = e2; 
		resultado1 = r1;
		resultado2 = r2;
	}
	
	public Partido(String lug, Equipo e1, Equipo e2) {
		setLugar(lug);
		equipo1 = e1;
		equipo2 = e2;
		resultado1 = (int)(Math.random()*(135-85+1)+85);
		resultado2 = (int)(Math.random()*(135-85+1)+85);
	}
	
	
	public void mostrarPartido() {
		System.out.println("Lugar del encuentro: "+getLugar());
		System.out.println();
		System.out.println("Equipo local:");
		equipo1.mostrarEquipo();
		System.out.println();
		System.out.println("Equipo visitante:");
		equipo2.mostrarEquipo();
		System.out.println();
		System.out.println("Resultado final:");
		System.out.println(equipo1.getNombre()+" "+resultado1+" - "+resultado2+" "+equipo2.getNombre());
	}
}