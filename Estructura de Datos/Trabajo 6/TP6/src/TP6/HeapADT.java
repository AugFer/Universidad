package TP6;

public interface HeapADT<T> extends BinaryTreeADT<T>{
	public void addElement(T element);
	public T removeMin();
	public T findMin();
}