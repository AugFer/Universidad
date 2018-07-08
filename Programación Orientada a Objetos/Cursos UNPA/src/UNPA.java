import java.util.ArrayList;
import java.util.Iterator;

public class UNPA {
	private ArrayList<Curso> cursos = new ArrayList<Curso>();
	
	
	public void agregarCurso(Curso c) {
		cursos.add(c);
		System.out.println("El curso "+c.getNombre()+" ah sido agregado a la oferta de cursos academicos.");
	}
	
	public void eliminarCurso(Curso c) {
		if (cursos.contains(c) == true) {
			cursos.remove(cursos.indexOf(c));
			System.out.println("El curso "+c.getNombre()+" ah sido eliminado de la oferta academica.");
		}
		else {
			System.out.println("El curso "+c.getNombre()+" no se encuentra dentro de la oferta academica.");
		}
	}
	
	public void ofrecimientoCursos() {
		System.out.println("Actualmente la UNPA-UACO ofrece los siguientes cursos:");
		Iterator<Curso> iter = cursos.iterator();
		while (iter.hasNext() == true) {
			Curso c = iter.next();
			System.out.println(" - "+c.getNombre());
		}
	}
		
}