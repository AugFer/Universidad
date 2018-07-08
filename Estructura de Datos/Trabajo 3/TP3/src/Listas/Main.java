package Listas;

import java.util.Iterator;

public class Main {
    public static void main(String[] args){
        /*
        System.out.println("Lista 1");
        UnorderedList<Integer> listaDesord1 = new UnorderedList<Integer>();
        Iterator<Integer> iter = listaDesord1.iterator();
        
        listaDesord1.addToFront(1);
        listaDesord1.addToFront(3);
        listaDesord1.addToFront(7);
        listaDesord1.addToFront(5);
        listaDesord1.addToFront(12);
        listaDesord1.addToFront(16);
        listaDesord1.addToFront(2);

        listaDesord1.addAfter(21, 9);
        listaDesord1.addAfter(13, 1);
        listaDesord1.addAfter(31, 16);
        
        iter = listaDesord1.iterator();
        while(iter.hasNext()){
            System.out.print(iter.next()+" | ");
        }
        System.out.println();
        
        System.out.println("Tamaño: "+listaDesord1.size());
        System.out.println("Primero: "+listaDesord1.first());
        System.out.println("Ultimo: "+listaDesord1.last());
        System.out.println("Remover: "+listaDesord1.removeFirst());
        System.out.println("Remover: "+listaDesord1.removeLast());
        System.out.println("Remover: "+listaDesord1.remove(3));
        
        iter = listaDesord1.iterator();
        while(iter.hasNext()){
            System.out.print(iter.next()+" | ");
        }
        System.out.println();
        
        System.out.println("Tamaño: "+listaDesord1.size());
        System.out.println("Primero: "+listaDesord1.first());
        System.out.println("Ultimo: "+listaDesord1.last());
        
        System.out.println("Lista 2");
        UnorderedList<Integer> listaDesord2 = new UnorderedList<Integer>();
        
        listaDesord2.addToFront(1);
        listaDesord2.addToFront(1);
        listaDesord2.addToFront(1);
        listaDesord2.addToFront(2);
        listaDesord2.addToFront(3);
        listaDesord2.addToFront(4);
        listaDesord2.addToFront(5);
        
        iter = listaDesord2.iterator();
        while(iter.hasNext()){
            System.out.print(iter.next()+" | ");
        }
        System.out.println();
        
        //Si todos los numeros son iguales la lista se toma como de menor a mayor (o se podria agregar el valor 3 a los resultados y que corresponda a este tipo de lista)
        System.out.println("Orden (desordenada 0, menor a mayor 1, mayor a menor 2): "+listaDesord2.estaOrdenada());
        */
//----------------------------------------------------------------------------//
        /*
        OrderedList<Integer> lista2 = new OrderedList<Integer>();
        Iterator<Integer> iter2 = lista2.iterator();
        
        lista2.add(1);
        lista2.add(1);
        lista2.add(3);
        lista2.add(12);
        lista2.add(7);
        lista2.add(15);
        lista2.add(4);
        lista2.add(4);
        lista2.add(4);
        lista2.add(12);
        lista2.add(4);
        lista2.add(4);
        lista2.add(3);
        lista2.add(15);
        
        System.out.println("Primero: "+lista2.first());
        System.out.println("Ultimo: "+lista2.last());
        
        iter2 = lista2.iterator();
        while(iter2.hasNext()){
            System.out.print(iter2.next()+" | ");
        }
        
        lista2.eliminarRepetidos();
        
        System.out.println();
        iter2 = lista2.iterator();
        while(iter2.hasNext()){
            System.out.print(iter2.next()+" | ");
        }
        */
//----------------------------------------------------------------------------//
        /*
        IndexList<Integer> lista3 = new IndexList<Integer>();
        Iterator<Integer> iter3 = lista3.iterator();
        
        lista3.add(7, 6);
        lista3.add(3, 5);
        lista3.add(2, 10);
        lista3.add(1, 22);
        lista3.add(3, 3);
        lista3.add(4, 4);
        lista3.add(5, 15);
        lista3.add(1, 9);

        System.out.println("Primero: "+lista3.first());
        System.out.println("Ultimo: "+lista3.last());
        
        iter3 = lista3.iterator();
        while(iter3.hasNext()){
            System.out.print(iter3.next()+" | ");
        }
        
        System.out.println();
        System.out.println("Elemento removido: "+lista3.remove(1));
        System.out.println("Elemento removido: "+lista3.remove(12));
        System.out.println("Elemento removido: "+lista3.remove(5));
        System.out.println("Elemento removido: "+lista3.remove(4));
        System.out.println("Elemento removido: "+lista3.remove(5));
        System.out.println("Cantidad de elementos: "+lista3.size());
        System.out.println("Primero: "+lista3.first());
        System.out.println("Ultimo: "+lista3.last());
        
        iter3 = lista3.iterator();
        while(iter3.hasNext()){
            System.out.print(iter3.next()+" | ");
        }
        
        System.out.println();
        IndexList<Integer> lista4 = new IndexList<Integer>();
        lista4.add(1, 2);
        lista4.add(3, 87);
        lista4.add(2, 10);
        lista4.add(6, 22);
        lista4.add(3, 5);
        
        iter3 = lista4.iterator();
        while(iter3.hasNext()){
            System.out.print(iter3.next()+" | ");
        }
        System.out.println();
        
        lista3.buscarCoincidencias(lista4);
        */
//----------------------------------------------------------------------------//
        /*
        DoubleOrderedList<Integer> lista5 = new DoubleOrderedList<Integer>();
        Iterator<Integer> iter4 = lista5.iterator();
        
        lista5.add(1);
        lista5.add(1);
        lista5.add(3);
        lista5.add(12);
        lista5.add(7);
        lista5.add(15);
        lista5.add(4);
        lista5.add(4);
        lista5.add(4);
        lista5.add(12);
        lista5.add(4);
        lista5.add(4);
        lista5.add(3);
        lista5.add(15);
        
        System.out.println("Primero: "+lista5.first());
        System.out.println("Ultimo: "+lista5.last());
        
        iter4 = lista5.iterator();
        while(iter4.hasNext()){
            System.out.print(iter4.next()+" | ");
        }
        
        lista5.eliminarRepetidos();
        
        System.out.println();
        iter4 = lista5.iterator();
        while(iter4.hasNext()){
            System.out.print(iter4.next()+" | ");
        }
        */
//----------------------------------------------------------------------------//
    }
}