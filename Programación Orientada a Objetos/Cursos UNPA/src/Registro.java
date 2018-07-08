public class Registro {
	private String condicion;
	private Alumno alum;
	private Curso cur;
	
	
	public Registro(Alumno a, Curso c, String cond) {
		condicion = cond;
		alum = a;
		cur = c;
	}
	
	public void condicionAlumno() {
		if(condicion == "aprobado") {
			System.out.println("El alumno "+alum.getNombre()+" aprobó el curso "+cur.getNombre()+".");
		}
		else {
			System.out.println("El alumno "+alum.getNombre()+" no aprobó el curso "+cur.getNombre()+".");
		}
	}
	
}