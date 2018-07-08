package tp2;

import java.util.Iterator;
import java.util.NoSuchElementException;

public class LinkedIterator<T> implements Iterator<T>{
    private int tamaño;
    private LinearNode<T> actual;
    
    public LinkedIterator(LinearNode collection, int count){
        actual = collection;
        tamaño = count;
    }
    
    public boolean hasNext(){
        return (actual!=null);
    }
    
    public T next(){
        if(!hasNext()){
            throw new NoSuchElementException();
        }
        T aux = actual.getElement();
        actual = actual.getNext();
        return aux;
    }
    
    public void remove() throws UnsupportedOperationException{
        throw new UnsupportedOperationException();
    }
    
    
    
}
