package TP5;
public class LinearNode<T> {
    
    /**** Atributos ****/
    
    private T element;
    private LinearNode<T> next;
    
    /**** Constructores ****/
    
    public LinearNode(){
        this.element = null;
        this.next = null;
    }
    
    public LinearNode(T element){
        this.element = element;
        this.next = null;
    }
        
    /**** Getters y Setters ****/

    public T getElement() {
        return element;
    }

    public void setElement(T element) {
        this.element = element;
    }

    public LinearNode<T> getNext() {
        return next;
    }

    public void setNext(LinearNode<T> next) {
        this.next = next;
    }
}
