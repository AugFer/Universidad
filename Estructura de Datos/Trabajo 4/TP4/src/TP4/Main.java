package TP4;
import java.util.Random;
        
public class Main {
    static int comparaciones=0;
    
    public static boolean busquedaLineal(int[] vector, int valorBuscado){
        int index = 0;
        boolean encontrado = false;
        while(!encontrado && index < vector.length){
            if(vector[index] == valorBuscado){
                encontrado = true;
            }
            comparaciones++;
            index++;
        }
        return encontrado;
    }
    public static boolean busquedaBinaria(int[] data, int min, int max, int target){
        boolean encontrado = false;
        int centro = (min+max)/2;
        comparaciones++;
        if(data[centro] == target){
            encontrado = true;
        }
        else{
            if(data[centro] > target){
                if(min <= centro-1){
                    encontrado = busquedaBinaria(data, min, centro-1, target);
                }
            }
            else{
                if(centro+1 <= max){
                    encontrado = busquedaBinaria(data, centro+1, max, target);
                }
            }
        }
        return encontrado; 
    }
    public static boolean busquedaPorInterpolacion(int[] vector, int valorBuscado, int inicio, int fin){
    	boolean encontrado=false;
    	if(inicio == fin || vector[inicio] == vector[fin]){
    		return encontrado;
    	}
    	int centro = inicio + ((fin - inicio)/(vector[fin] - vector[inicio])) * (valorBuscado - vector[inicio]);
    	centro = Math.abs(centro);
    	comparaciones++;
    	if(centro>fin){
    		return encontrado;
    	}
    	
    	if(vector[centro] == valorBuscado || vector[inicio] == valorBuscado || vector[fin] == valorBuscado){
    		encontrado=true;
    		return encontrado;
    	}
    	else{
    		if(vector[centro] < valorBuscado){
    			encontrado = busquedaPorInterpolacion(vector, valorBuscado, centro + 1, fin);
    		}
    		else{
    			if(centro-1>=inicio){
    				encontrado = busquedaPorInterpolacion(vector, valorBuscado, inicio, centro - 1);
    			}
    		}
    	}
    	return encontrado;
    }
    
    public static void ordenamientoPorSeleccion(int[] vector){
        int min, temp;
        for(int i=0; i<vector.length-1; i++){
            min = i;
            for(int scan = i+1; scan<vector.length; scan++){
                if(vector[scan]<vector[min]){
                    min = scan;
                    comparaciones++;
                }
                else{
                    comparaciones++;
                }
            }
            temp = vector[min];
            vector[min] = vector[i];
            vector[i] = temp;
        }
    }
    public static void ordenamientoPorInsercion(int[] vector){
        for(int i=1; i<vector.length; i++){
            int temp = vector[i];
            int pos = i;
            while(pos>0 && vector[pos-1]>temp){
                comparaciones++;
                vector[pos]=vector[pos-1];
                pos--;
            }
            vector[pos] = temp;
        }
    }
    public static void ordenamientoPorBurbuja(int [] vector){
        int pos, scan, temp;
        for(pos = vector.length-1; pos >=0; pos--){
            for(scan=0; scan <= pos-1; scan++){
                if(vector[scan]>vector[scan+1]){
                    temp = vector[scan];
                    vector[scan] = vector[scan+1];
                    vector[scan+1] = temp;
                }
                comparaciones++;
            }
        }
    }
    public static void ordenamientoShaker(int[] vector){
        int N = vector.length, limInferior=0, temp;
        int limSuperior = N-1;
        while(limInferior <= limSuperior){
            for(int j=limInferior; j<limSuperior;j++){
                if(vector[j]>vector[j+1]){
                    temp = vector[j];
                    vector[j] = vector[j+1];
                    vector[j+1] = temp;
                }
                comparaciones++;
            }
            limSuperior--;
            for(int j=limSuperior; j>limInferior; j--){
                if(vector[j]<vector[j-1]){
                    temp = vector[j];
                    vector[j] = vector[j-1];
                    vector[j-1] = temp;
                }
                comparaciones++;
            }
            limInferior++;
        }
    }
    public static void ordenamientoShell(int[] vector){
        int interval = vector.length/2;
        while(interval>0){
            for(int i=interval; i<vector.length; i++){
                int j=i-interval;
                while(j>=0){
                    if((vector[j]<=vector[j+interval])){
                        j=0;
                    }
                    else{
                        int temp = vector[j];
                        vector[j] = vector[j+interval];
                        vector[j+interval] = temp;
                    }
                    comparaciones++;
                    j-=interval;
                }
            }
            interval/=2;
        }
    }
    public static void ordenamientoQuick(int[] vector, int min, int max){
        int indexOfPartition;
        if(max - min > 0){
            indexOfPartition = findPartition(vector, min, max);
            ordenamientoQuick(vector, min, indexOfPartition-1);
            ordenamientoQuick(vector, indexOfPartition+1, max);
        }
    }
    private static int findPartition (int[] vector, int min, int max){
        int left, right, temp, partitionElement;
        partitionElement = vector[min];
        left=min;
        right=max;
        while(left < right){
            while((vector[left] <= partitionElement) && (left < right)){
                left++;
            }
            while(vector[right] > partitionElement){
                right--;
            }
            comparaciones++;
            if(left < right){
                temp = vector[left];
                vector[left] = vector[right];
                vector[right] = temp;
            }
        }
        temp = vector[min];
        vector[min] = vector[right];
        vector[right] = temp;
        return right;
    }
    public static void ordenamientoMerge(int[] vector, int min, int max){
        int[] temp;
        int index1, left, right;
        if(min==max){
            return;
        }
        int size = max - min + 1;
        int pivot = (min + max) / 2;
        temp = new int[size];
        ordenamientoMerge(vector, min, pivot);
        ordenamientoMerge(vector, pivot + 1, max);
        for(index1 = 0; index1 < size; index1++)
            temp[index1] = vector[min+index1];
        left=0;
        right=pivot-min+1;
        for(index1=0; index1<size; index1++)
            {
        	if(right<=max-min)
        		if(left<=pivot-min){
                	comparaciones++;
                	if(temp[left]>temp[right])
                		vector[index1+min]=temp[right++];
                	else
                		vector[index1+min]=temp[left++];
                }
                else
                	vector[index1+min]=temp[right++];
            else
            	vector[index1+min]=temp[left++];
        }
    }
    public static void ordenamientoRadix(int[] vector){
        String temp;
        Integer numObj;
        int digit, num;
        LinkedQueue<Integer>[] digitQueues = (LinkedQueue<Integer>[]) (new LinkedQueue[10]);
        
        for(int digitVal = 0; digitVal <=9; digitVal++){
            digitQueues[digitVal] = new LinkedQueue<Integer>();
        }
        for(int position=0; position<=3; position++){
            for(int scan=0; scan<vector.length; scan++){
                temp = String.valueOf(vector[scan]);
                digit = Character.digit(temp.charAt(3-position), 10);
                digitQueues[digit].enqueue(new Integer(vector[scan]));
            }
            num = 0;
            for(int digitVal = 0; digitVal <=9; digitVal++){
                while(!(digitQueues[digitVal].isEmpty())){
                	comparaciones++;
                    numObj = digitQueues[digitVal].dequeue();
                    vector[num] = numObj.intValue();
                    num++;
                }
            }
        }      
    }
    public static void ordenamientoBin(int[] vector){
        int maxVal = valorMax(vector);
        int [] bucket=new int[maxVal+1];
        for (int i=0; i<bucket.length; i++) {
            bucket[i]=0;
        }
        for (int i=0; i<vector.length; i++) {
            bucket[vector[i]]++;
        }
        int outPos=0;
        for (int i=0; i<bucket.length; i++) {
            for (int j=0; j<bucket[i]; j++) {
            	comparaciones++;
                vector[outPos++]=i;
            }
        }
    }
    private static int valorMax(int[] vector){
        int valorMax = 0;
        for (int i = 0; i < vector.length; i++){
            if (vector[i] > valorMax){
                valorMax = vector[i];
            }
        }
        return valorMax;
    }
    
    
    
    public static int[] arrayAleatorio(int desde, int hasta, int tam) {
        int[] numeros = new int[tam];
        Random rnd = new Random();
        int n;
        for (int i = 0; i < numeros.length; i++) {
            do{
                n = rnd.nextInt(hasta - desde + 1) + desde;
            }while(comprobar(numeros, i, n));
            numeros[i] = n;
        }
        return numeros;
    }
    public static boolean comprobar(int[] numeros, int indice, int valor) {
        for (int i = 0; i < indice; i++) {
            if (numeros[i] == valor) {
                return true;
            }
        }
        return false;
    }
    
    
    
    public static void main(String[] args){
// Vector fijo
/*
    	int[] vector = {3,8,12,34,54,84,91,110};
        int valorBuscado=54;

*/
// Vector aleatorio y ordenado
/*
    	int n=100;
        int[] vector = new int[n];
        vector = arrayAleatorio(1, n, vector.length);
        ordenamientoBin(vector);
        Random rnd = new Random();
        //int valorBuscado = rnd.nextInt(n-1+1)+1;//valor que se encuentra en el vector
        int valorBuscado =  -1; //valor que NO se encuentra en el vector
        System.out.println("Valor buscado: "+valorBuscado);
*/
//Busquedas
/*
        comparaciones=0;
        System.out.println("Busqueda Lineal");
        System.out.println(busquedaLineal(vector, valorBuscado));
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
        System.out.println("-----------------------------------------");
        System.out.println("Busqueda Binaria");
        System.out.println(busquedaBinaria(vector, 0, vector.length-1, valorBuscado));
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
        System.out.println("-----------------------------------------");
        System.out.println("Busqueda por interpolacion");
        System.out.println(busquedaPorInterpolacion(vector, valorBuscado, 0, vector.length-1));
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
//Ordenamientos
/*
        int[] vector = new int[10];
        vector = arrayAleatorio(1, 10, vector.length);
        int valorBuscado = 10;
        
        for (int i=0; i<vector.length; i++){
            System.out.print(vector[i]+", ");
        }
        System.out.println();
*/
/*
        int[] vector2={3, 8, 12, 34, 54, 84, 91, 110};
        //desordena los elementos del vector
        int m = vector2.length-1;
        for (int i=m; i>1; i--){ 
            int aleat = (int) Math.floor(i*Math.random()); 
            int temp = vector2[i]; 
            vector2[i] = vector2[aleat]; 
            vector2[aleat] = temp; 
        }
        
        for (int i=0; i<vector2.length; i++){
            System.out.print(vector2[i]+", ");
        }
        System.out.println();
*/ 
/*
        int[] vector2Desordenado = {54, 8, 110, 91, 12, 3, 84, 34};
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
*/        
        
        int[] vector2Desordenado = {90, 8, 7, 56, 123, 235, 9, 1, 653};
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();

/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento por Selección");
        ordenamientoPorSeleccion(vector2Desordenado);  
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento por Inserción");
        ordenamientoPorInsercion(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento por Burbuja");
        ordenamientoPorBurbuja(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/

        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Shell");
        ordenamientoShell(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;

/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Shaker");
        ordenamientoShaker(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Quick");
        ordenamientoQuick(vector2Desordenado, 0, vector2Desordenado.length-1);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Merge");
        ordenamientoMerge(vector2Desordenado, 0, vector2Desordenado.length-1);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Radix");
        ordenamientoRadix(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
/*
        System.out.println("-----------------------------------------");
        System.out.println("Ordenamiento Bin");
        ordenamientoBin(vector2Desordenado);
        for (int i=0; i<vector2Desordenado.length; i++){
            System.out.print(vector2Desordenado[i]+", ");
        }
        System.out.println();
        System.out.println("Comparaciones: "+comparaciones);
        comparaciones=0;
*/
    }
}