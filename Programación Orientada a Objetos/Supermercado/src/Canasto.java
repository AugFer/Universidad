import java.util.ArrayList;

public class Canasto {
	private ArrayList<Jabon> jabones = new ArrayList<Jabon>();
	
	public Canasto(){
	}
	
	public void agregarJabones(Jabon j){
		jabones.add(j);
	}
	
	public int cantidadJabones(){
		return jabones.size();
	}
}