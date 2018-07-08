package TP6;

public class HeapNode<T> extends BinaryTreeNode<T>{
	private HeapNode<T> parent;
	public HeapNode(T element){
		super(element);
		parent=null;
	}
	public HeapNode<T> getParent() {
		return parent;
	}
	public void setParent(HeapNode<T> parent) {
		this.parent = parent;
	}
}