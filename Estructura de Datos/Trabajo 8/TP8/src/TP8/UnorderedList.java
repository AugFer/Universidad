package TP8;

import java.util.Iterator;

public class UnorderedList<T> extends List<T> implements UnorderedListADT<T>{
    
    public UnorderedList(){
        super();
    }
    
    public void addToFront(T element){
        LinearNode<T> nodo = new LinearNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            nodo.setNext(primero);
            primero=nodo;
        }
        count++;
    }
    
    public void addToRear(T element){
        LinearNode<T> nodo = new LinearNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            ultimo.setNext(nodo);
            ultimo=nodo;
        }
        count++;
    }
    
    public void addAfter(T element, T target){
        if(isEmpty()){
            System.out.println("El elemento parametro no existe en la lista porque la lista está vacia.");
        }
        else{
            Comparable<T> targetComp = (Comparable<T>)target;
            LinearNode<T> nodo = new LinearNode<T>(element);
            LinearNode<T> actual = primero;
            boolean parametro = false;
            while(parametro==false && actual!=null){
                if(targetComp.compareTo((T)actual.getElement())==0){
                    parametro = true;
                }
                else{
                    actual = actual.getNext();
                }
            }
            if(actual==null){
                System.out.println("El elemento parametro no existe en la lista.");
            }
            else{
                if(ultimo.equals(actual)){
                    ultimo.setNext(nodo);
                    ultimo=nodo;
                }
                else{
                    nodo.setNext(actual.getNext());
                    actual.setNext(nodo);
                }
                count++;
            }
        }
    }
    
    public int estaOrdenada(){
        int result=0;
        boolean control=false, iguales=false;
        LinearNode anterior = primero;
        LinearNode actual = primero.getNext();
        Comparable<T> targetComp;
        while(control==false && actual!=null){
            targetComp = ((Comparable<T>) anterior.getElement());
            if(targetComp.compareTo((T)actual.getElement())==0){
                iguales=true;
            }
            if(targetComp.compareTo((T)actual.getElement())<0){
                if(result==2){
                    control=true;
               }
                iguales=false;
                result=1;
            }
            else{
                if(targetComp.compareTo((T)actual.getElement())>0){
                    if(result==1){
                        control=true;
                    }
                    iguales=false;
                    result=2;
                }
            }
            anterior = actual;
            actual = actual.getNext();
        }
        if(control==true){
            result=0;
        }
        if(iguales==true && result!=2){
            result=1;
        }
        return result;
    }
}