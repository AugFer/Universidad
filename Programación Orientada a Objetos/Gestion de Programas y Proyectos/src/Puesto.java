public class Puesto {
	private Persona persona;
	private String puesto;
	
	public Puesto(String pues, Persona per){
		setPuesto(pues);
		setPersona(per);
	}
	
	public void setPuesto(String pues){
		puesto = pues;
	}
	public String getPuesto(){
		return puesto;
	}
	
	public void setPersona(Persona per){
		persona = per;
	}
	public Persona getPersona(){
		return persona;
	}
}