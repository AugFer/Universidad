package Listas;

public interface IndexedListADT<T> extends ListADT<T>{
    
    //Inserta el elemento especificado en el índice especificado.
    public void add(int index, T element);
    
    //Configura el elemento situado en el índice especificado.
    public void set(int index, T element);
    
    //Añade el elemento especificado al final de la lista.
    public void add(T element);
    
    //Devuelve una referencia al elemento situado en el índice especificado.
    public T get(int index);
    
    //Devuelve el índice del elemento especificado.
    public int indexOf(T element);
    
    //Elimina y devuelve el elemento correspondiente al índice especificado.
    public T remove(int index);
    
}
