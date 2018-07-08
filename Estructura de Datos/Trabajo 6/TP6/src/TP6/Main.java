package TP6;

import java.util.Iterator;

public class Main {

	public static void main(String[] args) {
		
		Heap<Integer> h1 = new Heap<Integer>();
		
		UnorderedList<Integer> l1 = new UnorderedList<Integer>();
		l1.addToFront(2);
		l1.addToFront(22);
		l1.addToFront(52);
		l1.addToFront(128);
		l1.addToFront(1);
		l1.addToFront(333);
		l1.addToFront(78);
		l1.addToFront(99);
		
		Iterator<Integer> iter;
		iter = l1.iterator();
    	System.out.println("Lista desordenada:");
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
		
    	h1.heapSort(l1);
    	
    	System.out.println();
		iter = l1.iterator();
    	System.out.println("Lista ordenada (HeapSort):");
    	while(iter.hasNext()){
    		System.out.print(iter.next()+" | ");
    	}
  
/*		
		PriorityQueue<Integer> pq1 = new PriorityQueue<Integer>();
    	pq1.addElement(3, 1);
    	pq1.addElement(15, 3);
    	pq1.addElement(44, 6);
    	pq1.addElement(143, 2);
    	pq1.addElement(1, 10);
    	pq1.addElement(99, 4);
    	pq1.addElement(67, 5);
*/    	
	}
}