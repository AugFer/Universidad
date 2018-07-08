package TP8;
import java.util.Iterator;

public interface ListADT<T> {
    //Elimina y devuelve el primer elemento de la lista.
    public T removeFirst();
    
    //Elimina y devuelve el último elemento de la lista.
    public T removeLast();
    
    //Elimina y devuelve en elemento especificado de la lista.
    public T remove(T element);
    
    //Devuelve una referencia al primer elemento de la lista.
    public T first();
    
    //Devuelve una referencia al ultimo elemento de la lista.
    public T last();
    
    //Devuelve true si esta lista contiene el elemento especificado.
    public boolean contains(T target);
    
    //Devuelve true si esta lista no contiene ningun elemento.
    public boolean isEmpty();
    
    //Devuelve el número de elementos de la lista.
    public int size();
    
    //Devuelve un iterador para los elementos de la lista.
    public Iterator<T> iterator();
    
    //Devuelve una representación de la lista en forma de cadena de caracteres.
    public String toString();
    
}
