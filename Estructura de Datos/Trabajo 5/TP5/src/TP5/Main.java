package TP5;
import java.util.Iterator;


public class Main{
    public static void main(String[] args) {
    	ArbolBinarioEnlazadoDeBusqueda<Integer> a1 = new ArbolBinarioEnlazadoDeBusqueda<Integer>(5);
    	a1.addElement(7);
    	a1.addElement(3);
    	a1.addElement(-2);
    	a1.addElement(1);
    	a1.addElement(8);
    	a1.addElement(4);
    	a1.addElement(6);
    
/*    
    	Iterator<Integer> iter;
    
    	System.out.println("Recorrido Level Order");
    	iter = a1.iteratorLevelOrder();
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
    	System.out.println();    
    	System.out.println("Recorrido In Order");
    	iter = a1.iteratorInOrder();
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
    	System.out.println();   
    	System.out.println("Recorrido Pre Order");
    	iter = a1.iteratorPreOrder();
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
    	System.out.println();
    	System.out.println("Recorrido Post Order");
    	iter = a1.iteratorPostOrder();
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
    	System.out.println();
*/
/*
    	ArbolBinarioEnlazadoDeBusqueda<Integer> a2 = new ArbolBinarioEnlazadoDeBusqueda<Integer>(5);
    	a2.addElement(7);
    	a2.addElement(3);
    	a2.addElement(4);
    	a2.addElement(6);
    	a2.addElement(8);
    	a2.addElement(-2);
    	a2.addElement(1);
    	
    	System.out.println("¿A y B son semejantes?: "+a1.esSemejanteA(a2));
*/    	
    	int valorA=1;
    	int valorB=5;
    	System.out.println("¿Existe un camino entre "+valorA+" y "+valorB+"?: "+a1.existeCamino(valorA, valorB));
    	
    	System.out.println("¿"+valorA+" es ancestro de "+valorB+"?: "+a1.esAncestro(valorA, valorB));
    		
    }
}