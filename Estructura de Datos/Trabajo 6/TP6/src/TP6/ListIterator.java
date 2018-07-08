package TP6;
import java.util.Iterator;
import java.util.NoSuchElementException;

public class ListIterator<T> implements Iterator<T>{
    private LinearNode<T> actual;
    
    public ListIterator(LinearNode primero){
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