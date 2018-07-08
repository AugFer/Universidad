package TP5;
import java.util.NoSuchElementException;

public interface BinarySearchTreeADT<T> extends BinaryTreeADT<T>{
    
    public void addElement(T element);
    public T removeElement(T element);
    public void removeAllOccurrences(T element) throws NoSuchElementException;
    public T removeMin();
    public T removeMax();
    public T findMin();
    public T findMax();
}
