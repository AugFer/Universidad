package TP6;
public class BinaryTreeNode<T> {  
    private T element;
    private BinaryTreeNode<T> left, right;
    
    public BinaryTreeNode(){
        this.element = null;
        this.left = null;
        this.right = null;
    }
    
    public BinaryTreeNode(T element){
        this.element = element;
        this.left = null;
        this.right = null;
    }
    
    public int numChildren(){
        int children = 0;
        if(left!=null){
            children = 1 + left.numChildren();
        }
        if(right!=null){
            children = children + 1 + right.numChildren();
        }
        return children;
    }
    
    public void setElement(T element) {
        this.element = element;
    }
    
    public void setLeft(BinaryTreeNode<T> left) {
        this.left = left;
    }

    public void setRight(BinaryTreeNode<T> right) {
        this.right = right;
    }
        
    public T getElement() {
        return element;
    }

    public BinaryTreeNode<T> getLeft() {
        return left;
    }

    public BinaryTreeNode<T> getRight() {
        return right;
    }   
}