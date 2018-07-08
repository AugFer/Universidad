package TP8;

import java.util.Iterator;

public class Grafo {
	private UnorderedList<nodoVertice> vertices;
	
		
	public Grafo(){
		vertices = new UnorderedList<nodoVertice>();
	}
	
	public void addVertice(String n){
		nodoVertice nodo = new nodoVertice(n);
		vertices.addToRear(nodo);
	}
	
	public void eliminarVertice(String n){
		Iterator<nodoVertice> iter = vertices.iterator();
		nodoVertice actual;
		boolean encontrado=false;
		
		while(iter.hasNext() && !encontrado){
			actual=iter.next();
			if(actual.getNombre().equals(n)){
				encontrado=true;
			}
			Iterator<nodoVertice> iter2 = vertices.iterator();
			nodoVertice actual2;
			while(iter2.hasNext()){
				actual2=iter2.next();
				actual2.eliminarAdyacente(actual);
			}
			vertices.remove(actual);
		}
	}
	
	public void eliminarArista(String n1, String n2){
		Iterator<nodoVertice> iter = vertices.iterator();
		nodoVertice actual = vertices.first();
		nodoVertice nodo1 = null;
		nodoVertice nodo2 = null;
		boolean encontrado1=false, encontrado2=false;
		
		while(iter.hasNext() && (!encontrado1 || !encontrado2)){
			actual=iter.next();
			if(actual.getNombre().equals(n1)){
				nodo1=actual;
				encontrado1=true;
			}
			if(actual.getNombre().equals(n2)){
				nodo2=actual;
				encontrado2=true;
			}
		}
		if(encontrado1==true && encontrado2==true){
			nodo1.eliminarAdyacente(nodo2);
			nodo2.eliminarAdyacente(nodo1);
		}
	}
	
	public void addArista(String n1, String n2){
		Iterator<nodoVertice> iter = vertices.iterator();
		nodoVertice actual = vertices.first();
		nodoVertice nodo1 = null;
		nodoVertice nodo2 = null;
		boolean encontrado1=false, encontrado2=false;
		
		while(iter.hasNext() && (!encontrado1 || !encontrado2)){
			actual=iter.next();
			if(actual.getNombre().equals(n1)){
				nodo1=actual;
				encontrado1=true;
			}
			if(actual.getNombre().equals(n2)){
				nodo2=actual;
				encontrado2=true;
			}
		}
		if(encontrado1==true && encontrado2==true){
			nodo1.addAyacente(nodo2);
			nodo2.addAyacente(nodo1);
		}
		else{
			System.out.println("La arista no puede crearse porque uno de los vertices especificados no existe en el grafo.");
		}
	}
	
	public void adyacentesA(String nom){
		Iterator<nodoVertice> iter = vertices.iterator();
		boolean encontrado = false;
		nodoVertice actual = null;
		while(iter.hasNext() && !encontrado){
			actual=iter.next();
			if(actual.getNombre().equals(nom)){
				encontrado=true;
				actual.verAdyacentes();
				System.out.println();
			}
		}
		if(encontrado==false){
			System.out.println("El vertice ingresado no existe en el grafo.");
		}
	}
	
	public int size(){
		return (vertices.size());
	}
	
	public boolean isEmpty(){
		return (vertices.size()==0);
	}
	
	public void inaccesibles(){
		Iterator<nodoVertice> iter = vertices.iterator();
		nodoVertice actual = null;
		boolean existen=false;
		System.out.print("Vertices inaccesibles: ");
		while(iter.hasNext()){
			actual=iter.next();
			if(actual.inaccesible()){
				existen=true;
				System.out.print(actual.getNombre()+" , ");
			}
		}
		if(!existen){
			System.out.print("no existen vertices inaccesibles.");
		}
	}
	
}