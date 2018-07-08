package Listas;

public class OrderedList<T> extends List<T> implements OrderedListADT<T>{
    
    public OrderedList(){
        super();
    }
    
    public void add(T element){
        LinearNode<T> nodo = new LinearNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            Comparable<T> elementComp = (Comparable<T>)element;
            LinearNode<T> anterior = null;
            LinearNode<T> actual = primero;
            boolean aux = false;
            while(aux==false && actual!=null){
                if(elementComp.compareTo((T)actual.getElement())<0){
                    aux=true;
                }
                else{
                    anterior = actual;
                    actual = actual.getNext();
                }
            }
            if(aux==false){
                ultimo.setNext(nodo);
                ultimo=nodo;
            }
            else{
                if(primero.equals(actual)){
                    nodo.setNext(primero);
                    primero=nodo;
                }
                else{
                    nodo.setNext(actual);
                    anterior.setNext(nodo);
                }
            }
        }
        count++;
    }
    
    public void eliminarRepetidos(){
        LinearNode<T> actual = primero;
        Comparable<T> targetComp;
        while(actual.getNext()!=null){
            targetComp = ((Comparable<T>) actual.getElement());
            if(targetComp.compareTo((T)actual.getNext().getElement())==0){
                this.remove((T)actual.getNext().getElement());
            }
            actual = actual.getNext();
        }
    }
}