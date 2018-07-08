package tp2;

public interface ADTPila<T> {
    
    public void push(T element);
    public T pop();
    public T peek();
    public boolean isEmpty();
    public int size();
    public String toString();
}