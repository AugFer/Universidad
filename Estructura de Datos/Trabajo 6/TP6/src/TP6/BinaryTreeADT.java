package TP6;
import java.util.Iterator;
import java.util.NoSuchElementException;


public interface BinaryTreeADT<T> {
    
    public void removeLeftSubTree();
    public void removeRightSubTree();
    public boolean isEmpty();
    public int size();
    public boolean contains(T target);
    public T find(T target) throws NoSuchElementException;
    public String toString();
    public Iterator<T> iteratorInOrder();
    public Iterator<T> iteratorPreOrder();
    public Iterator<T> iteratorPostOrder();
    public Iterator<T> iteratorLevelOrder();
}