package TP6;

public class PriorityQueueNode<T> implements Comparable<PriorityQueueNode<T>>{
	private static int nextOrder = 0;
	private int priority;
	private int order;
	private T element;
	
	public PriorityQueueNode(T elem, int prio){
		element = elem;
		priority = prio;
		order = nextOrder;
		nextOrder++;
	}
	
	public T getElement(){
		return element;
	}
	
	public int getPriority(){
		return priority;
	}
	
	public int getOrder(){
		return order;
	}
	
	public int compareTo(PriorityQueueNode<T> node){
		int result;
		PriorityQueueNode<T> temp = node;
		if(priority>temp.getPriority())
			result=1;
		else if(priority<temp.getPriority())
			result=-1;
		else if(order>temp.getOrder())
			result=1;
		else
			result=-1;
		return result;
	}
}