package Listas;

import java.util.Iterator;
import java.util.NoSuchElementException;

public class DoubleIterator<T> implements Iterator<T>{
    private DoubleNode<T> actual;
    
    public DoubleIterator(DoubleNode primero){
        actual = primero;
    }
    
     public boolean hasNext(){
        return (actual!=null);
    }
    
    public T next(){
        if(!hasNext()){
            throw new NoSuchElementException();
        }
        T reslut = actual.getElement();
        actual = actual.getNext();
        return reslut;
    }
    
    public void remove() throws UnsupportedOperationException{
        throw new UnsupportedOperationException();
    }
}