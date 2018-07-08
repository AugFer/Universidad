package Listas;

import java.util.Iterator;

public class DoubleList<T> implements ListADT<T> {
    protected DoubleNode<T> primero, ultimo;
    protected int count;
    
     public DoubleList(){
        primero = null;
        ultimo = null;
        count=0;
    }
    
    public T removeFirst(){
        if(isEmpty()){
            return null;
        }
        else{
            T aux = primero.getElement();
            if(count==1){
                primero = null;
                ultimo = null;
            }
            else{
                primero.getNext().setPrevious(null);
                primero = primero.getNext();
            }
            count--;
            return aux;
        }
    }
    
    public T removeLast(){
        if(isEmpty()){
            return null;
        }
        else{
            T aux = ultimo.getElement();
            if(count==1){
                primero = null;
                ultimo = null;
            }
            else{
                ultimo.getPrevious().setNext(null);
                ultimo = ultimo.getPrevious();
            }
            count--;
            return aux;
        }
    }
    
    public T remove(T element){
        if(isEmpty()){
            return null;
        } 
        else{
            if(count==1 && primero.getElement()==element){
                primero = null;
                ultimo = null;
            }
            else{
                if(primero.getElement()==element){
                    primero.getNext().setPrevious(null);
                    primero = primero.getNext();
                }
                else{
                    DoubleNode<T> actual = primero;
                    boolean buscado = false;
                    while(buscado==false && actual!=null){
                        if(actual.getElement()==element){
                            buscado = true;
                            if(ultimo.equals(actual)){
                                ultimo.getPrevious().setNext(null);
                                ultimo = ultimo.getPrevious();
                            }
                        }
                        else{
                            actual = actual.getNext();
                        }
                    }
                    if(buscado==false){
                        return null;
                    }
                    else{
                        actual.getPrevious().setNext(actual.getNext());
                        actual.getNext().setPrevious(actual.getPrevious());
                    }
                }
            }
            count--;
            return element;
        }
    }
    
    public T first(){
        if(isEmpty()){
            return null;
        }
        else{
            return primero.getElement();
        }
    }
    
    public T last(){
        if(isEmpty()){
            return null;
        }
        else{
            return ultimo.getElement();
        }
    }
    
    public boolean contains(T target){
        DoubleNode<T> actual = primero;
        boolean buscar=false;
        while(buscar==false && actual!=null){
            if(actual.getElement()==target){
                buscar=true;
            }
            else{
                actual = actual.getNext();
            }
        }
        return (buscar!=false);
    }
    
    public boolean isEmpty(){
        return (count==0);
    }
    
    public int size(){
        return count;
    }
    
    public Iterator<T> iterator(){
        return new DoubleIterator<T> (primero);
    }
    
    //No entiendo
    public String toString(){
        return null;
    }
}