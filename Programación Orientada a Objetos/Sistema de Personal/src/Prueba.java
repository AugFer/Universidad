
public class Prueba 
{
	public static void main(String[] args)
	{
		//Creacion de la empresa
		Empresa e1 = new Empresa("R-Security", "Japan", "0513-359848");
		
		//Creacion de categorias de la empresa
		Categoria A = new Categoria("A", 300);
		Categoria B = new Categoria("B", 500);
		Categoria C = new Categoria("C", 800);
		
		//Creacion de empleados administrativos
		Administrativo a1 = new Administrativo("Kazuki Kasami", 36456826, "Thanatos", C, 7);
		Administrativo a2 = new Administrativo("Mikasa Ackerman", 31265489, "Survey Corps", A, 2);
		Administrativo a3 = new Administrativo("Tachibana Kanade", 39321568, "Angelic Howl", B, 6);
		
		//Creacion de empleados tecnicos
		Tecnico t1 = new Tecnico("Makina Irisu", 41358987, "Francotiradora", 105, "Master Guardian AWP Global Defense Academy");
		
		//Muestra de administrativos
		a1.Mostrar();
		a2.Mostrar();
		a3.Mostrar();
		
		//Muestra de tecnicos
		t1.Mostrar();
		
	}
}