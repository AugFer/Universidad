package TP5;

import java.util.Iterator;
import java.util.NoSuchElementException;

public class ArbolBinarioEnlazado<T> implements BinaryTreeADT<T>{
    protected int count;
    protected BinaryTreeNode<T> root;
    
    public ArbolBinarioEnlazado(){
        root = null;
        count = 0;
    }
    
    public ArbolBinarioEnlazado(T element){
        root = new  BinaryTreeNode<T>(element);
        count = 1;
    }
    
    public ArbolBinarioEnlazado(T element, ArbolBinarioEnlazado<T> leftSubTree, ArbolBinarioEnlazado<T> rightSubTree){
        root = new  BinaryTreeNode<T>(element);
        count = 1;
        if(leftSubTree != null){
            root.setLeft(leftSubTree.root);
            count = count + leftSubTree.size();
        }
        if(rightSubTree != null){
            root.setRight(rightSubTree.root);
            count = count + rightSubTree.size();
        }
    }
    
    public void removeLeftSubTree(){
        if(root.getLeft()!=null){
            count = count - root.getLeft().numChildren() -1;
            root.setLeft(null);
        }
    }
    
    public void removeRightSubTree(){
        if(root.getRight()!=null){
            count = count - root.getRight().numChildren() -1;
            root.setRight(null);
        }
    }
    
    public boolean isEmpty(){
        return (count==0);
    }
    
    public int size(){
        return count;
    }
    
    public boolean contains(T target){
        try{
            find(target);
        }catch (NoSuchElementException ex){return false;}
        return true;
    }
    
    public T find(T target) throws NoSuchElementException{
        BinaryTreeNode<T> current = findAgain(target, root);
        if(current == null){
            throw new NoSuchElementException("BinaryTree");
        }
        return (current.getElement());
    }
    
    private BinaryTreeNode<T> findAgain(T target, BinaryTreeNode<T> next){
        if(next == null){
            return null;
        }
        if(next.getElement().equals(target)){
            return next;
        }
        
        BinaryTreeNode<T> temp = findAgain(target, next.getLeft());
        if(temp == null){
            temp = findAgain(target, next.getRight());
        }
        return temp;
    }
    
    public Iterator<T> iteratorInOrder(){
        UnorderedList<T> tempList = new UnorderedList<T>();
        inOrder(root, tempList);
        return tempList.iterator();
    }
    protected void inOrder(BinaryTreeNode<T> node, UnorderedList<T> tempList){
        if(node!=null){
            inOrder(node.getLeft(), tempList);
            tempList.addToRear(node.getElement());
            inOrder(node.getRight(), tempList);
        }
    }
       
    public Iterator<T> iteratorPreOrder(){
        UnorderedList<T> tempList = new UnorderedList<T>();
        preOrder(root, tempList);
        return tempList.iterator();
    }
    protected void preOrder(BinaryTreeNode<T> node, UnorderedList<T> tempList){
        if(node!=null){
            tempList.addToRear(node.getElement());
            preOrder(node.getLeft(), tempList);
            preOrder(node.getRight(), tempList);
        }
    }
    
    public Iterator<T> iteratorPostOrder(){
        UnorderedList<T> tempList = new UnorderedList<T>();
        postOrder(root, tempList);
        return tempList.iterator();
    }
    protected void postOrder(BinaryTreeNode<T> node, UnorderedList<T> tempList){
        if(node!=null){
            postOrder(node.getLeft(), tempList);
            postOrder(node.getRight(), tempList);
            tempList.addToRear(node.getElement());
        }
    }
    
    public Iterator<T> iteratorLevelOrder(){
    	UnorderedList<BinaryTreeNode<T>> tempList = new UnorderedList<BinaryTreeNode<T>>();
    	UnorderedList<T> tempList2 = new UnorderedList<T>();
    	tempList.addToRear(root);
    	while(!tempList.isEmpty()){
    		BinaryTreeNode<T> nodo = tempList.removeFirst();
    		tempList2.addToRear(nodo.getElement());
    		if(nodo.getLeft() != null){
    			tempList.addToRear(nodo.getLeft());
    		}
    		if (nodo.getRight() != null){
    			tempList.addToRear(nodo.getRight());
    		}
    	}
    	return tempList2.iterator();
    }
    
}