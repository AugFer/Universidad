package TP2;
import java.util.Iterator;
import java.util.NoSuchElementException;

public interface TADSet<T> {
    //A�ade un elemento a este conjunto, ignorando los duplicados
    public void add (T element);
    
    // A�ade los elementos de un conjunto a otro
    public void addAll (TADSet<T> set);
    
    //Elimina y devuelve un elemento aleatorio de este conjunto
    public T removeRandom();
    
    //Elimina y deveulve un elemento especificado del conjunto.
    public T remove (T element)throws NoSuchElementException;
    
    //Devuelve la union de este conjunto y del par�metro
    public TADSet<T> union (TADSet<T> set);
    
    // Devuelve true si este conjunto contiene el par�metro
    public boolean contains (T target);
    
    // Devuelve true si este conjunto y el par�metro contienen
    // exactamente los mismos elementos
    public boolean equals (TADSet<T> set)throws NoSuchElementException;
    
    // Devuelve true si este conjunto no contiene ning�n elemento
    public boolean isEmpty();
    
    // Devuelve el n�mero de elementos del conjunto
    public int size();
    
    //Devuelve un iterator para los elementos de este conjunto
    public Iterator<T> iterator();
    
    //Devuelve una representaci�n de este conjunto en forma de 
    // cadena de caracteres
    public String toString();
}