package TP6;

public class PriorityQueue<T> extends Heap<PriorityQueueNode<T>>{
	
	public PriorityQueue(){
		super();
	}
	
	public void addElement(T elem, int prio){
		PriorityQueueNode<T> node = new PriorityQueueNode<T>(elem, prio);
		super.addElement(node);
	}
	
	public T removeNext(){
		PriorityQueueNode<T> temp = (PriorityQueueNode<T>)super.removeMin();
		return temp.getElement();
	}
}