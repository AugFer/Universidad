package Listas;

import java.util.Iterator;

public class IndexList<T> extends List<T> implements ListADT<T>{
    
    public IndexList(){
        super();
    }
    
    public void add(int index, T element){
        LinearNode<T> nodo = new LinearNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            if(index==1){
                nodo.setNext(primero);
                primero=nodo;
            }
            else{
                if(index>count){
                    ultimo.setNext(nodo);
                    ultimo = nodo;
                }
                else{
                    LinearNode<T> actual = primero;
                    for(int i=2; i<index; i++){
                        actual = actual.getNext();
                    }
                    nodo.setNext(actual.getNext());
                    actual.setNext(nodo);
                }
            }
        }
        count++;
    }
    
    public void set(int index, T element){
        if(isEmpty()){
            System.out.println("No se puede editar esa posicion porque la lista esta vacia.");
        }
        else{
            if(index>count){
                    System.out.println("No se puede editar esa posicion porque la excede a la maxima de la lista.");
                }
            else{
                LinearNode<T> actual = primero;
                for(int i=1; i<index; i++){
                    actual = actual.getNext();
                }
                actual.setElement(element);
            }
        }
    }
    
    public void add(T element){
        LinearNode<T> nodo = new LinearNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            ultimo.setNext(nodo);
            ultimo = nodo;
        }
        count++;
    }
    
    public T get(int index){
        LinearNode<T> actual = primero;
        T aux = null;
        for(int i=1; i<index; i++){
            actual = actual.getNext();
        }
        aux = actual.getElement();
        return aux;
    }
    
    public int indexOf(T element){
        if(isEmpty()){
            System.out.println("El elemento no está en la lista.");
        }
        else{
            Comparable<T> elementComp = (Comparable<T>)element;
            LinearNode<T> actual = primero;
            boolean buscado = false;
            int index=1;
            while(buscado==false && actual!=null){
                if(elementComp.compareTo((T)actual.getElement())==0){
                    buscado=true;
                }
                else{
                    actual = actual.getNext();
                    index++;
                }
            }
            if(buscado==false){
                System.out.println("El elemento no está en la lista.");
            }
            else{
                return index;
            }
        }
        return -1;
    }
    
    public T remove(int index){
        if(isEmpty()){
            System.out.println("No se puede remover el elemento del indice indicado porque la lista está vacia.");
        }
        else{
            if(index>count){
                System.out.println("No se puede remover el elemento del indice indicado porque excede a la lista.");
            }
            else{
                T aux;
                if(index==1){
                    aux = primero.getElement();
                    primero = primero.getNext();
                }
                else{
                    LinearNode<T> anterior = primero;
                    LinearNode<T> actual = primero.getNext();
                    for(int i=2; i<index; i++){
                        anterior = actual;
                        actual = actual.getNext();
                    }
                    if(ultimo.getElement()==actual.getElement()){
                        aux = actual.getElement();
                        anterior.setNext(null);
                        ultimo = anterior;
                    }
                    else{
                        aux = actual.getElement();
                        anterior.setNext(actual.getNext());
                    }
                }
                count--;
                return aux;
            }
        }
        return null;
    }
    
    //El enunciado pedia que devuelva numeros, pero que se yo, no me gusta eso de devolver -1 o posiciones asi al aire
    //porque me pierde ver numeros sueltos en la consola. De todas formas es facilmente modificable.
    public void buscarCoincidencias(IndexList lista){
        Iterator<T> iter;
        int index = 5;
        boolean encontrado = false;
        T target, aux;
        for(int i=1; i<=this.size(); i++){
            target = this.get(i);
            iter = lista.iterator();
            while(iter.hasNext() && encontrado==false){
                aux = iter.next();
                if(target==aux){
                    System.out.println("El elemento "+target+" de la lista, se encuentra en la posicion "+index+" de la segunda lista.");
                    encontrado = true;
                }
                else{
                    index++;
                }
            }
            if(encontrado==false){
                System.out.println("El elemento "+target+" de la lista, no se encuentra en la segunda lista.");
            }
            encontrado=false;
            index=1;
        }
    }
}