package TP5;

import java.util.Iterator;
import java.util.NoSuchElementException;

public class ArbolBinarioEnlazadoDeBusqueda<T> extends ArbolBinarioEnlazado<T> implements BinarySearchTreeADT<T>{
	
	public ArbolBinarioEnlazadoDeBusqueda(){
		super();
	}
	
	public ArbolBinarioEnlazadoDeBusqueda(T element){
		super(element);
	}
	
	public void addElement (T element){
		BinaryTreeNode<T> temp = new BinaryTreeNode<T>(element);
	    Comparable<T> compElement = (Comparable<T>)element;
	    if(isEmpty()){
	    	root = temp;
	    }
	    else{
	    	BinaryTreeNode<T> current = root;
	        boolean added = false;
	        while(!added){
	        	if(compElement.compareTo(current.getElement())<0){
	        		if(current.getLeft()==null){
	        			current.setLeft(temp);
	                    added = true;
	                }
	                else{
	                	current = current.getLeft();
	                }
	            }
	            else{
	            	if(current.getRight()==null){
	            		current.setRight(temp);
	            		added = true;
	                }
	                else{
	                	current = current.getRight();
	                }
	            }
	        }
	    }
	    count++;
	}
    
	public T removeElement(T element){
		T result=null;
		if(!isEmpty()){
			if(((Comparable)element).equals(root.getElement())){
				result=root.getElement();
				root=replacement(root);
				count--;
			}
			else{
				BinaryTreeNode<T> current, parent=root;
				boolean found=false;
				if(((Comparable)element).compareTo(root.getElement())<0){
					current=root.getLeft();
				}
				else{
					current=root.getRight();
				}
				while(current!=null && !found){
					if(element.equals(current.getElement())){
						found=true;
						count--;
						result=current.getElement();
						if(current==parent.getLeft()){
							parent.setLeft(replacement(current));
						}
						else{
							parent.setRight(replacement(current));
						}
					}
					else{
						parent=current;
						if(((Comparable)element).compareTo(current.getElement())<0){
							current=current.getLeft();
						}
						else{
							current=current.getRight();
						}
					}
				}
				if(!found){
					return null;
				}
			}
			
		}
		return result;
	}
		
	protected BinaryTreeNode<T> replacement(BinaryTreeNode<T> node){
		BinaryTreeNode<T> result = null;
		if((node.getLeft()==null) && (node.getRight()==null)){
			result=null;
		}
		else{
			if((node.getLeft()!=null) && (node.getRight()==null)){
				result=node.getLeft();
			}
			else{
				if((node.getLeft()==null) && (node.getRight()!=null)){
					result=node.getRight();
				}
				else{
					BinaryTreeNode<T> current = node.getRight();
					BinaryTreeNode<T> parent = node;
					while(current.getLeft()!=null){
						parent=current;
						current=current.getLeft();
					}
					if(node.getRight()==current){
						current.setLeft(node.getLeft());
					}
					else{
						parent.setLeft(current.getRight());
						current.setRight(node.getRight());
						current.setLeft(node.getLeft());
					}
					result=current;
				}
			}
		}
		return result;
	}
		
    public void removeAllOccurrences(T element) throws NoSuchElementException{
    	removeElement(element);
    	try{
    		while(contains((T)element)){
    			removeElement(element);
    		}
    	}catch(Exception ElementNotFoundException){}
    }
      
    public T removeMin(){
    	BinaryTreeNode<T> actual = root;
    	while(actual.getLeft()!=null){
    		actual=actual.getLeft();
    		
    	}
    	removeElement(actual.getElement());
        return (actual.getElement());
   }
    
    public T removeMax(){
    	BinaryTreeNode<T> actual = root;
    	while(actual.getRight()!=null){
    		actual=actual.getRight();
    	}
    	removeElement(actual.getElement());
        return (actual.getElement());
   }
    
    public T findMin(){
    	BinaryTreeNode<T> actual = root;
    	while(actual.getLeft()!=null){
    		actual=actual.getLeft();
    	}
    	return (actual.getElement());
    }
    
    public T findMax(){
    	BinaryTreeNode<T> actual = root;
    	while(actual.getRight()!=null){
    		actual=actual.getRight();
    	}
    	return (actual.getElement());
    }
    
    public boolean esSemejanteA(ArbolBinarioEnlazadoDeBusqueda<T> arbol){
    	if(this.size()==arbol.size()){
    		boolean semejantes=true;
    		Iterator<T> iter = this.iteratorLevelOrder();
    		while(iter.hasNext() && semejantes==true){
    			if(!arbol.contains(iter.next())){
    				semejantes=false;
    			}
    		}
    		if(semejantes==true){
    			return true;
    		}
    		else{
    			return false;
    		}
    	}
    	else{
    		return false;
    	}
    }
    
    public boolean existeCamino(T valorA, T valorB){
    	BinaryTreeNode<T> actual=root;
    	boolean encontrado=false;
    	while(actual!=null && (actual.getElement()!=valorA && actual.getElement()!=valorB)){
    		if(((Comparable)actual.getElement()).compareTo(valorA)<0){
    			actual=actual.getRight();
    		}
    		else{
    			actual=actual.getLeft();
    		}
    	}
    	if(actual!=null && actual.getElement()==valorA){
    		return encontrado(actual, valorB);
    	}
    	if(actual!=null && actual.getElement()==valorB){
    		return encontrado(actual, valorA);
    	}	
    	else{
    		return encontrado;
    	}
    }
  
    public boolean encontrado(BinaryTreeNode<T> actual, T valor){
    	boolean encontrado=false;
    	
    	while(actual!=null && encontrado!=true){
    		if(((Comparable)actual.getElement()).compareTo(valor)<0){
    			actual=actual.getRight();
				if(actual!=null && actual.getElement()==valor){
					encontrado=true;
				}
			}
			else{
				actual=actual.getLeft();
				if(actual!=null && actual.getElement()==valor){
					encontrado=true;
				}
			}
		}
    	
    	
    	
    	
		return encontrado;
    }

    public boolean esAncestro(T valorA, T valorB){
    	BinaryTreeNode<T> actual=root;
    	boolean encontrado=false;
    	while(actual!=null && actual.getElement()!=valorA){
    		if(((Comparable)actual.getElement()).compareTo(valorA)<0){
    			actual=actual.getRight();
    		}
    		else{
    			actual=actual.getLeft();
    		}
    	}
    	if(actual!=null){
    		return encontrado(actual, valorB);
    	}
    	return encontrado;
    }
    
}