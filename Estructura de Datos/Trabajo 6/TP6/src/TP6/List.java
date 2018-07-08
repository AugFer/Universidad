package TP6;
import java.util.Iterator;

public class List<T> implements ListADT<T>{
    protected LinearNode<T> primero, ultimo;
    protected int count;
    
    public List(){
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
                LinearNode<T> anterior = primero;
                while(anterior.getNext()!=ultimo){
                    anterior = anterior.getNext();
                }
                ultimo = anterior;
                ultimo.setNext(null);
            }
            count--;
            return aux;
        }
    }
    
    public T remove(T element) {
        if(isEmpty()){
            return null;
        }
        else{
            Comparable<T> elementComp = ((Comparable<T>)element);
            if(count==1 && elementComp.compareTo((T)primero.getElement())==0){
                primero = null;
                ultimo = null;
            }
            else{
                if(elementComp.compareTo((T)primero.getElement())==0){
                    primero = primero.getNext();
                }
                else{
                    LinearNode<T> anterior = primero;
                    LinearNode<T> actual = primero.getNext();
                    boolean buscado = false;
                    while(buscado==false && actual!=null){
                        if(elementComp.compareTo((T)actual.getElement())==0){
                            buscado = true;
                            if(ultimo.equals(actual)){
                                ultimo=anterior;
                            }
                        }
                        else{
                            anterior = actual;
                            actual = actual.getNext();
                        }
                    }
                    if(buscado==false){
                        return null;
                    }
                    else{
                        anterior.setNext(actual.getNext());
                    }
                }
            }
            count--;
            return element;
        }
    }
    
    public boolean contains(T target){
        Comparable<T> targetComp = (Comparable<T>)target;
        LinearNode<T> actual = primero;
        boolean buscar=false;
        while(buscar==false && actual!=null){
            if(targetComp.compareTo((T)actual.getElement())==0){
                buscar=true;
            }
            else{
                actual = actual.getNext();
            }
        }
        return (buscar!=false);
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

    public boolean isEmpty(){
        return (count==0);
    }
    
    public int size(){
        return count;
    }
    
    public Iterator<T> iterator(){
        return new ListIterator<T> (primero);
    }
    
//no lo entiendo    
    public String toString(){
        return null;
    }
}
