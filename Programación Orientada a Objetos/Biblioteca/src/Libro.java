public class Libro {
	private String titulo, isbn;
	private Editorial editora;
	private Autor autor;
	
	
	public void setTitulo(String t) {
		titulo = t;
	}
	public String getTitulo() {
		return titulo;
	}
	
	public void setISBN(String i) {
		isbn = i;
	}
	public String getISBN() {
		return isbn;
	}
	
	public void setEditora(Editorial e) {
		editora = e;
	}
	public Editorial getEditora() {
		return editora;
	}
	
	public void setAutor(Autor a) {
		autor = a;
	}
	public Autor getAutor() {
		return autor;
	}
	
	
	public Libro(String i, String tit, Editorial e, Autor a) {
		setISBN(i);
		setTitulo(tit);
		setEditora(e);
		setAutor(a);
	}
	
	
	public void mostrerLibro(Libro l) {
		System.out.println("Numero ISBN: "+l.getISBN());
		System.out.println("Titulo: "+l.getTitulo());
		Autor a = l.getAutor();
		System.out.println("Autor: "+a.getNombre());
		Editorial e = l.getEditora();
		System.out.println("Editorial: "+e.getNombre());
	}
	
}