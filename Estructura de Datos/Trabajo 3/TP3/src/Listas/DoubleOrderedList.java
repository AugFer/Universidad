package Listas;

public class DoubleOrderedList<T> extends DoubleList<T> implements ListADT<T> {
    
    public DoubleOrderedList(){
        super();
    }
    
    public void add(T element){
        DoubleNode<T> nodo = new DoubleNode<T>(element);
        if(isEmpty()){
            primero=nodo;
            ultimo=nodo;
        }
        else{
            DoubleNode<T> actual = primero;
            boolean aux = false;
            while(aux==false && actual!=null){
                if((Integer)actual.getElement()>(Integer)element){
                    aux=true;
                }
                else{
                    actual = actual.getNext();
                }
            }
            if(aux==false){
                ultimo.setNext(nodo);
                nodo.setPrevious(ultimo);
                ultimo=nodo;
            }
            else{
                if(primero.equals(actual)){
                    primero.setPrevious(nodo);
                    nodo.setNext(primero);
                    primero=nodo;
                }
                else{
                    nodo.setNext(actual);
                    nodo.setPrevious(actual.getPrevious());
                    actual.getPrevious().setNext(nodo);
                    actual.setPrevious(nodo);
                }
            }
        }
        count++;
    }
    
    public void eliminarRepetidos(){
        DoubleNode<T> actual = primero;
        while(actual.getNext()!=null){
            if(actual.getElement()==actual.getNext().getElement()){
                this.remove((T)actual.getNext().getElement());
            }
            actual = actual.getNext();
        }
    }
}