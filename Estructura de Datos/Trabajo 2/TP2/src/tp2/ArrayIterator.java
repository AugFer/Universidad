package tp2;

import java.util.*;

public class ArrayIterator<T> implements Iterator<T>{
    private int size, current;
    private T[] items;
    
    public ArrayIterator(T[] contents, int count){
        items = contents;
        size = count;
        current = 0;
    }
    
    public boolean hasNext(){
        return (current < size);
    }
    
    public T next(){
        if(!hasNext()){
            throw new NoSuchElementException();
        }
        current++;
        return items[current-1];
    }
    
    public void remove() throws UnsupportedOperationException{
        throw new UnsupportedOperationException();
    }
}