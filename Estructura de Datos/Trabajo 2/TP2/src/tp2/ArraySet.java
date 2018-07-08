package tp2;

import java.util.Iterator;
import java.util.NoSuchElementException;
import java.util.Random;

import java.io.IOException;//excepciones de entrada y salida
import java.io.File;//asocia archivo fisico con uno logico
import java.io.FileReader;//acceder al contenido caracter por caracter
import java.io.BufferedReader;//permite extrar strings del achivo, en lugar de caracter por caracter (usa fileReader)
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.util.logging.Level;
import java.util.logging.Logger;

public class ArraySet<T> implements TADSet<T> {

	private static Random rand = new Random();
	
	private final int DEFAULT_CAPACITY = 100;
	private final int NOT_FOUND = -1;
	
	private int count;
	private T[] contents;
	
	
	private void expandCapacity(){
		// Crea un nuevo array para almacenar el contenido del conjunto, con
		// una capacidad igual al doble de la capacidad de la matriz anterior
		
		T[] larger = (T[])(new Object[contents.length*2]);
		for (int index=0; index < contents.length; index++)
			larger[index] = contents[index];
		contents = larger;
	}
	
	//Crea un conjunto vacio utlizandola capacidad predeterminda
	public ArraySet(){
	
   	   

		count = 0;
		contents = (T[])(new Object [DEFAULT_CAPACITY]);

	}
	
	//crea un conjunto vacio utilizando la capacidad especificada
	public ArraySet (int initialCapacity){
		count = 0;
		contents = (T[])(new Object [initialCapacity]);
	}
	
	public void add(T element) {
		// Añade el elemento especificado al conjunto, si es que ese elemento
		// no está ya presente. Expande la capacidad del array del conjunto 
		// en caso necesario
		if (!(contains(element)))
		{ if (size()== contents.length)
			expandCapacity();
		  
		  contents[count]=element;
		  count++;
		}
	}
			
    public void addAll (ArraySet<T> set)
    {

    //	 A�ade los elementos de un conjunto a otro
    	Iterator<T> scan = set.iterator();
    	while(scan.hasNext())
    		add(scan.next());
    }

    public T removeRandom(){
	// Elimina un elemento aleatorio del conjunto y lo devuelve.
	// Genera una excepci�n EmptySetException si el conjunto est� vac�o
	if (isEmpty())
            return null;
		
	int choice = rand.nextInt(count);
		
	T result = contents[choice];
		
	contents[choice] = contents[count-1]; //rellenar el hueco
	contents[count-1]=null;
	count--;
                
	return result;
    }

    public T remove (T element) throws NoSuchElementException
	{
		// Elimina el elemento especificado del conjunto y lo devuelve.
		// Genera EmptySetException si el conjunto est� vac�o y
		// NoSuchElementException si el elemento especificado 
		// no se encuentra en el conjunto
		int search = NOT_FOUND;
		
		if (isEmpty())
			return null;
                
		for (int index=0; index < count && search == NOT_FOUND; index++)
			if (contents[index].equals(element))
				search = index;
		
		if(search==NOT_FOUND)
			throw new NoSuchElementException();
		
		T result = contents[search];
		
		contents[search]=contents[count-1];
		contents[count-1]=null;
		count--;
				
		return result;
	}

	public TADSet<T> union(TADSet<T> set) {
		// Devuelve un nuevo conjunto que es la uni�n del conjunto actual
		// y el conjunto pasado como par�metro
		ArraySet both = new ArraySet();
		
		for (int index=0; index < count; index++)
                    both.add(contents[index]);
		
		Iterator<T> scan = set.iterator();
		while (scan.hasNext())
			both.add(scan.next());
		
		
		return both;
	}
	
	//	----------------------------------------------------------
	// Devuelve true si este conjunto contiene el elemento 
	// especificado
	//----------------------------------------------------------
        public boolean contains(T target) {
        	int search = NOT_FOUND;
        	
        	for (int index=0; index < count && search == NOT_FOUND; index++)
        		if (contents[index].equals(target))
        			search = index;
		return (search != NOT_FOUND);
	}

	public boolean equals(TADSet<T> set) throws NoSuchElementException {
		// Devuelve true si este conjunto contiene exactamente los mismos
		// elementos que el conjunto pasado como par�metro
		boolean result = false;
		ArraySet<T> temp1 = new ArraySet<T>();
		ArraySet<T> temp2 = new ArraySet<T>();
		T obj;
		if (size()==set.size())
		{
			temp1.addAll(this);
			temp2.addAll(set);
			
			Iterator<T> scan =set.iterator();
			while(scan.hasNext())
			{
				obj = scan.next();
				if (temp1.contains(obj))
				{
					temp1.remove(obj);
					temp2.remove(obj);
				}
			}
			result = (temp1.isEmpty() && temp2.isEmpty());
		}
				
		return result;
	}

	public boolean isEmpty() {
		// Devuelve True si este conjunto esta vac�o
		return (count ==0);
	}

	public int size() {
		// Devuelve el numero de elementos que el conjunto tiene actualmente
		return count;
	}

	public Iterator<T> iterator() {
		//Devuelve un iterador para los elementos que se encuentran
		// actualmente en el conjunto
		
		return new ArrayIterator<T> (contents, count);
 //Crear la clase ArrayIterator e implementar su comportamiento .Next() y .hasNext()                
	}

	public String toString(){
		 // Devuelve una representaci�n de este conjunto en forma de cade
		 // de caracteres
		 String result = "";
		 
		 for (int index=0; index < count; index++)
			 result = result +contents[index].toString() + "\n";
		 return result;
	 }

        
        public void importarDatos(String url_origen){
            File archivo = new File(url_origen);
            if(archivo.exists()){
                try{
                    BufferedReader buffer = new BufferedReader(new FileReader(archivo));
                    String texto = buffer.readLine();
                    for(int i=0; i<Integer.valueOf(texto); i++){
                        this.add((T)Integer.valueOf(buffer.readLine()));
                    }
                    /*
                    Iterator iter = this.iterator();
                    while(iter.hasNext()){
                        System.out.println(iter.next());
                    }
                    */
                    buffer.close();         
                }catch(IOException ex){
                    System.out.println(ex.getMessage());
                }
            }
            else{
                System.out.println("El archivo no existe.");
            }
        }
        
        
        public void exportarDatos(String url_destino){
            File archivo = new File(url_destino);
            try{
                BufferedWriter buffer = new BufferedWriter(new FileWriter(archivo));
                buffer.write(String.valueOf(this.size()));
                Iterator iter = this.iterator();
                while(iter.hasNext()){
                    buffer.newLine();
                    buffer.write(iter.next().toString());
                }
                buffer.close();
            }catch(IOException ex){
                System.out.println(ex.getMessage());
            }
        }
        //n2?
        public ArraySet<T> difference(ArraySet<T> conjunto2){
            ArraySet<T> result = new ArraySet<T>(this.size()+conjunto2.size());
            result.addAll(this);           
            result.addAll(conjunto2);
            
            Iterator<T> iter = conjunto2.iterator();
            while(iter.hasNext()){
                result.remove(iter.next());
            }
            return result;
        }
        //n2
        public ArraySet<T> interseccion(ArraySet<T> conjunto2){
            ArraySet<T> result = new ArraySet<T>(this.size());
            
            Iterator<T> iter = conjunto2.iterator();
            while(iter.hasNext()){
                T aux = iter.next();
                if(this.contains(aux)){
                    result.add(aux);
                }
            }
            return result;
        }
        
}
