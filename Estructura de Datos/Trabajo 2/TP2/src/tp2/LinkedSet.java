package tp2;

import java.util.Iterator;
import java.util.NoSuchElementException;
import java.util.Random;

public class LinkedSet<T> implements TADSet<T>{
    
    private int count;
    private LinearNode<T> contents;
    private static Random rand = new Random();
    private final int NOT_FOUND = -1;
   
    public LinkedSet(){
        count = 0;
        contents = null;
    }
    
    public void add(T element){
        if(!contains(element)){
            LinearNode<T> node = new LinearNode<T> (element);
            node.setNext(contents);
            contents = node;
            count++;
        }
    }
    
    public void addAll(TADSet<T> set){
        Iterator<T> iter = set.iterator();
    	while(iter.hasNext()){
            add(iter.next());
        }
    }
    
    public T removeRandom(){
        LinearNode<T> previous, current;
        T result = null;
        if(isEmpty()){
            return null;
        }
        int choice = rand.nextInt(count);
        if(choice == 1){
            result = contents.getElement();
            contents = contents.getNext();
        }
        else{
            previous = contents;
            for(int skip=2; skip<choice; skip++){
                previous = previous.getNext();
            }
            current = previous.getNext();
            result = current.getElement();
            previous.setNext(current.getNext());
        }
        count--;
        return result;
    }
    
    public T remove(T element) throws NoSuchElementException{
        boolean found = false;
        LinearNode<T> previous, current;
        T result = null;
        if(isEmpty()){
            return null;
        }
        if(contents.getElement().equals(element)){
            result = contents.getElement();
            contents = contents.getNext();
        }
        else{
            previous = contents;
            current = contents.getNext();
            for(int look=1; look<count; look++){
                if(current.getElement().equals(element)){
                    found = true;
                }
                else{
                    previous = current;
                    current = current.getNext();
                }
            }
            if(!found){
                throw new NoSuchElementException();
            }
            result = current.getElement();
            previous.setNext(current.getNext());
        }
        count--;
        return result;
    }
    
//Creo, no estoy seguro de que funcione. .. .
    public TADSet<T> union(TADSet<T> set){
        LinkedSet<T> both = new LinkedSet<T>();
	if(!isEmpty()){
            both.addAll(this);
        }
	Iterator<T> iter = set.iterator();
        while (iter.hasNext())
        	both.add(iter.next());		
	return both;
    }
    
    public boolean contains(T element){
        boolean buscado = false;
        LinearNode<T> actual;
        actual = contents;
        while(actual != null && buscado == false){
           if(element.equals(actual.getElement())){
        	buscado = true;
           }
           else{
               actual = actual.getNext();
           }
        }	
         return buscado;
    }
    
    public boolean equals(TADSet<T> set){
        boolean result = false;
	if(this.size()==set.size()){
            LinkedSet<T> temp1 = new LinkedSet<T>();
            LinkedSet<T> temp2 = new LinkedSet<T>();
            T obj;
            temp1.addAll(this);
            temp2.addAll(set);
            Iterator<T> scan = set.iterator();
            while(scan.hasNext()){
                obj = scan.next();
                if(temp1.contains(obj)){
                    temp1.remove(obj);
                    temp2.remove(obj);
                }
            }
            result=(temp1.isEmpty() && temp2.isEmpty());
	}
	return result;
    }
    
    public boolean isEmpty(){
        return (count==0);
    }
    
    public int size(){
        return count;
    }
    
    public Iterator<T> iterator(){
        return new LinkedIterator<T>(contents, count);
    }
    
//No lo entiendo
    public String toString(){
        String resultado = "";
	LinearNode<T> actual, anterior;
	actual = contents;
	if(!isEmpty()){
            while(actual != null){
		resultado = resultado + actual.getElement().toString()  + "\n";
		anterior = actual;
		actual = actual.getNext();
            }
	return resultado;
	}
	return null;
    }
    
}
