package TP6;

public class Heap<T> extends ArbolBinarioEnlazado<T> implements HeapADT<T> {
	public HeapNode<T> lastNode;
	
	public Heap(){
		super();
	}
	
 	public void addElement(T element){
		HeapNode<T> node = new HeapNode<T>(element);
		if(root==null){
			root=node;
		}
		else{
			HeapNode<T> next_parent = getNextParentAdd();
			if(next_parent.getLeft() == null)
				next_parent.setLeft(node);
			else
				next_parent.setRight(node);
			node.setParent(next_parent);
		}
		lastNode = node;
		count++;
		if(count>1){
			heapifyAdd();
		}
		
	}
	
	private HeapNode<T> getNextParentAdd(){
		HeapNode<T> result = lastNode;
		while((result!=root) && (result.getParent().getLeft()!=result)){
			result = result.getParent();
		}
		if(result!=root)
			if(result.getParent().getRight()==null)
				result = result.getParent();
			else{
				result = (HeapNode<T>) result.getParent().getRight();
				while(result.getLeft()!=null)
					result = (HeapNode<T>) result.getLeft();
			}
		else{
			while(result.getLeft()!=null){
				result = (HeapNode<T>)result.getLeft();
			}
		}
		return result;
	}
	
	private void heapifyAdd(){
		T temp;
		HeapNode<T> next = lastNode;
		while((next!=root) && (((Comparable)next.getElement()).compareTo(next.getParent().getElement())<0)){
			temp=next.getElement();
			next.setElement(next.getParent().getElement());
			next.getParent().setElement(temp);
			next=next.getParent();
		}
	}
	
	public T findMin(){
		return root.getElement();
	}
	
	public T removeMin(){
		if(isEmpty()){
			return null;
		}
		T minElement = root.getElement();
		if(count==1){
			root = null;
			lastNode = null;
		}
		else{
			HeapNode<T> next_last = getNewLastNode();
			if(lastNode.getParent().getLeft() == lastNode){
				lastNode.getParent().setLeft(null);
			}
			else{
				lastNode.getParent().setRight(null);
			}
			root.setElement(lastNode.getElement());
			lastNode = next_last;
			heapifyRemove();
		}
		count--;
		return minElement;
	}
	
	private HeapNode<T> getNewLastNode(){
		HeapNode<T> result = lastNode;
		while((result!=root) && (result.getParent().getLeft() == result)){
			result = result.getParent();
		}
		if(result != root){
			result = (HeapNode<T>) result.getParent().getLeft();
		}
		while(result.getRight()!=null){
			result = (HeapNode<T>) result.getRight();
		}
		return result;
	}
	
	private void heapifyRemove(){
		T temp;
		HeapNode<T> node = (HeapNode<T>) root;
		HeapNode<T> left = (HeapNode<T>) node.getLeft();
		HeapNode<T> right = (HeapNode<T>) node.getRight();
		HeapNode<T> next;
		
		if((left==null) && (right==null))
			next = null;
		else if(left == null)
			next = right;
		else if(right == null)
			next = left;
		else if(((Comparable)left.getElement()).compareTo(right.getElement())<0)
			next = left;
		else
			next = right;
		
		while((next!=null) && (((Comparable)next.getElement()).compareTo(node.getElement())<0)){
			temp = node.getElement();
			node.setElement(next.getElement());
			next.setElement(temp);
			node = next;
			left = (HeapNode<T>) node.getLeft();
			right = (HeapNode<T>) node.getRight();
			if((left==null) && (right==null))
				next = null;
			else if(left == null)
				next = right;
			else if(right == null)
				next = left;
			else if(((Comparable)left.getElement()).compareTo(right.getElement())<0)
				next = left;
			else
				next = right;
		}
	}
	
	
	public UnorderedList<T> heapSort(UnorderedList<T> lista){
		while(!lista.isEmpty()){
		    this.addElement(lista.first());
		    lista.removeFirst();
		}
		while(!this.isEmpty()){
			lista.addToRear(this.removeMin());
		}
		return lista;
	}
	

}