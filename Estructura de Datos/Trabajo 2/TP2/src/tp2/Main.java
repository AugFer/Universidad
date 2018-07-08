package tp2;
import java.io.IOException;//excepciones de entrada y salida
import java.io.File;//asocia archivo fisico con uno logico
import java.io.FileReader;//acceder al contenido caracter por caracter
import java.io.BufferedReader;//permite extrar strings del achivo, en lugar de caracter por caracter (usa fileReader)
import java.util.Iterator;
import java.util.Scanner;


public class Main {

    public static void main(String[] args) {
        
    //Creacion
        ArraySet<Integer> array = new ArraySet<Integer>();
        ArraySet<Integer> array2 = new ArraySet<Integer>(10);
        
        
    //add
        
        array.add(1);
        array.add(2);
        array.add(3);
        array.add(4);
        array.add(5);
        array.add(6);
        array.add(7);
        array.add(8);
        array.add(9);
        array.add(10);
        
        array2.add(15);
        array2.add(13);
        array2.add(9);
        array2.add(7);
        array2.add(20);
        array2.add(5);
        array2.add(3);
        array2.add(1);
        array2.add(11);
        array2.add(16);
        
       /*
    //addAll
        array.addAll(array2);
        
    //removeRandom
        array.removeRandom();
    
    //remove
        array.remove(3);
    
    //union
        array.union(array2);
       */ 
    //Importar datos
        //array.importarDatos("C:\\Users\\Monica\\Desktop\\Uni\\Estructura de Datos\\Trabajo 2\\Datos.txt");
        
        //array2.exportarDatos("C:\\Users\\Monica\\Desktop\\Uni\\Estructura de Datos\\Trabajo 2\\DatosEXP.txt");
     
        //ArraySet<Integer> array3 = array.difference(array2);
        
        ArraySet<Integer> array3 = array.interseccion(array2);
        
        Iterator<Integer> iter = array3.iterator();
        while(iter.hasNext()){
            System.out.println(iter.next());
        }

    }
}