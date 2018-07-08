public class Empresa {
	private String nombre, direccion, telefono;
	
	public Empresa(String nom, String dir, String tel){
		setNombre(nom);
		setDireccion(dir);
		setTelefono(tel);
	}
	
	public void setNombre(String nom){
		nombre = nom;
	}
	public String getNombre(){
		return nombre;
	}
	
	public void setDireccion(String dir){
		direccion = dir;
	}
	public String getDireccion(){
		return direccion;
	}
	
	public void setTelefono(String tel){
		telefono = tel;
	}
	public String getTelefono(){
		return telefono;
	}
}