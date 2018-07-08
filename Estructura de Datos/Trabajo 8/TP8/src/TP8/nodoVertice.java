package TP8;

import java.util.Iterator;

public class nodoVertice<String> implements Comparable<nodoVertice<String>>{
	private String nombre;
	private UnorderedList<nodoVertice> adyacentes;
	
	public nodoVertice(String n){
		setNombre(n);
		adyacentes = new UnorderedList<nodoVertice>();
	}
	
	public void addAyacente(nodoVertice n){
		Iterator<nodoVertice> iter = adyacentes.iterator();
		boolean encontrado=false;
		while(iter.hasNext() && !encontrado){
			if(iter.next().equals(n)){
				encontrado=true;
			}
		}
		if(encontrado==false){
			adyacentes.addToRear(n);
		}
		
	}
	
	public void eliminarAdyacente(nodoVertice n){
		Iterator<nodoVertice> iter = adyacentes.iterator();
		boolean encontrado=false;
		while(iter.hasNext() && !encontrado){
			if(iter.next().equals(n)){
				encontrado=true;
				adyacentes.remove(n);
			}
		}
	}
	
	public void verAdyacentes(){
		Iterator<nodoVertice> iter = adyacentes.iterator();
		System.out.print("Adyacentes de '"+this.getNombre()+"': ");
		while(iter.hasNext()){
			System.out.print(iter.next().getNombre()+" , ");
		}
	}
	
	public boolean inaccesible(){
		return(this.adyacentes.size()==0);
	}
	
	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public int compareTo(nodoVertice<String> nodo) {
		if(this.getNombre().equals(nodo.getNombre())){
			return 0;
		}
		else{
			return -1;
		}
	}

	public UnorderedList<nodoVertice> getAdyacentes() {
		return adyacentes;
	}
}