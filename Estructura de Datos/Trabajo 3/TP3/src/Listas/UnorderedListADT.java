package Listas;

public interface UnorderedListADT<T> extends ListADT<T> {
    
    //Añade el elemento especificado al principio de la lista.
    public void addToFront(T element);
    
    //Añade el elemento especificado al final de la lista.
    public void addToRear(T element);
    
    //Añade el elemento especificado despues del elemento especificado.
    public void addAfter(T element, T target);
}