package tp2;

public class LinkedStack<T> implements ADTPila<T> {
    private LinearNode<T> top;
    private int count;
    
    public LinkedStack(){
        top=null;
        count=0;
    }
    
    public void push(T element){
        LinearNode<T> node = new LinearNode<T>(element);	
	node.setNext(top);
	top = node;
	count++;
    }
	
    public T pop(){
	if(isEmpty()){
            return null;
        }
        else{
            T result = top.getElement();
            top = top.getNext();
            count--;
            return result;
        }
    }
	
    public T peek(){
	return top.getElement();
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
            actual = this.getTop();
            while(actual != null){
                resultado = resultado + actual.getElement().toString()  + "\n";
                actual = actual.getNext();
            }
            return resultado;
        }
	return null;
    }
    
    public LinearNode<T> getTop(){
	return top;
    }
    
    public void setTop(LinearNode<T> top){
	this.top = top;
    }
    
    public int getCount(){
        return count;
    }
    
    public void setCount(int count){
	this.count = count;
    }
}