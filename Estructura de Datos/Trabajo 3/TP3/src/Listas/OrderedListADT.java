package Listas;

public interface OrderedListADT<T> extends ListADT<T>{
    
    //Añade el elemento especificado a la lista, en la ubicación adecuada.
    public void add(T element);
    
}
