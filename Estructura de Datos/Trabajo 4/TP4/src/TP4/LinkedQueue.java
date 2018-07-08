package TP4;

public class LinkedQueue<T> implements TADCola<T> {
    
    private LinearNode<T> front, rear;
    private int count;

    public LinkedQueue(){
        this.front = null;
        this.rear = null;
        count = 0;
    }
    
    public void enqueue(T element){
	LinearNode<T> node = new LinearNode<T>(element);
	if(isEmpty()){
            front = node;
            rear = node;
        }
        else{
            rear.setNext(node);
            rear = node;
        }
        count++;
    }
	
    public T dequeue(){
	if(isEmpty()){
            return null;
        }
        else{
            T result = front.getElement();
            front = front.getNext();
            count--;
            if(isEmpty()){
		rear = null;
            }
            return result;
	}
    }
    
    public T first(){
	return front.getElement();
    }
    
    public boolean isEmpty(){
	return (count == 0);
    }
    
    public int size(){
	return count;
    }
    
    public String toString(){
        if(!isEmpty()){
            String resultado = "";
            LinearNode<T> actual;
            actual = this.getFront();
            while(actual != null){
                resultado = resultado + actual.getElement().toString() + "\n";
                actual = actual.getNext();
            }
            return resultado;
        }
        return null;
    }
    
    public LinearNode<T> getFront(){
        return front;
    }
    public void setFront(LinearNode<T> front){
        this.front = front;
    }
    
    public LinearNode<T> getRear(){
        return rear;
    }
    
    public void setRear(LinearNode<T> rear){
        this.rear = rear;
    }
    
    public int getCount(){
        return count;
    }
    
    public void setCount(int count){
        this.count = count;
    }
}