package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.TypedArray;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.github.mikephil.charting.charts.PieChart;
import com.github.mikephil.charting.components.Description;
import com.github.mikephil.charting.components.Legend;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.PieData;
import com.github.mikephil.charting.data.PieDataSet;
import com.github.mikephil.charting.data.PieEntry;
import com.github.mikephil.charting.formatter.IValueFormatter;
import com.github.mikephil.charting.utils.ViewPortHandler;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Resultados_grafico extends Base_toolbar
{
    private Button btn_resultados;
    private String tipo_resultado, claustro;
    private ProgressDialog progressDialog;
    private SharedPreferences shared_resultados;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.resultados_grafico);
        crear(getString(R.string.res_toolbar_titulo));

        btn_resultados = (Button) findViewById(R.id.btn_resultados);
        shared_resultados = getSharedPreferences("resultados", Context.MODE_PRIVATE);
        String resultados = shared_resultados.getString("resultados","");
        claustro = getIntent().getStringExtra("Claustro");

        controlResultado(resultados);
        generarGrafico(resultados);
    }

    private void controlResultado(String resultados)
    {
        JSONArray array;
        try {
            array = new JSONArray(resultados);
            tipo_resultado = array.getJSONArray(0).getString(0);
            if(tipo_resultado.equals("Parcial")){
                btn_resultados.setText(getString(R.string.res_btn_resultados_actualizar));
                btn_resultados.setOnClickListener(new View.OnClickListener()
                {
                    @Override
                    public void onClick(View v)
                    {
                        actualizarResultados();
                    }
                });
            }
            if(tipo_resultado.equals("Final")){
                btn_resultados.setText(getString(R.string.res_btn_resultados_plazas));
                btn_resultados.setOnClickListener(new View.OnClickListener()
                {
                    @Override
                    public void onClick(View v)
                    {
                        startActivity(new Intent(getApplicationContext(),Resultados_plazas.class));
                    }
                });
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void actualizarResultados()
    {
        RequestQueue rqt = Volley.newRequestQueue(Resultados_grafico.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_res);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            String respuesta;
                            JSONArray array = new JSONArray(response);
                            if(array.length()==1 || array.length()==2){ //Si el array devuelto tiene 1 o 2 elementos es porque algo fue mal
                                respuesta = array.getString(0);
                            }
                            else{
                                JSONArray subarray = array.getJSONArray(0);
                                respuesta = subarray.getString(0);
                            }

                            //Declaraciones generales de un mensaje emergente que se completara segun corresponda en los IF siguientes
                            Toast toast = Toast.makeText(getApplicationContext(), "", Toast.LENGTH_LONG);
                            TextView v = (TextView) toast.getView().findViewById(android.R.id.message);
                            if( v != null) v.setGravity(Gravity.CENTER);

                            if (respuesta.equals("Error de conexion")) { //Error en una consulta del lado del servidor
                                toast.setText("Error en la recuperación de información");
                                toast.show();
                            }
                            else {
                                if (respuesta.equals("No hay ningun acto eleccionario")) { //Si no hay un acto cargado
                                    toast.setText("No hay ningún acto eleccionario programado");
                                    toast.show();
                                }
                                else {
                                    if (respuesta.equals("El acto eleccionario aun no ha comenzado")) { //Si hay acto pero aun no comenzó
                                        toast.setText("El acto eleccionario aún no ha comenzado.\nIncio: "+array.getString(1));
                                        toast.show();
                                    }
                                    else {
                                        if (respuesta.equals("El acto eleccionario ya ha finalizado")) { //Si hay acto pero ya finalizó
                                            toast.setText("El acto eleccionario ya ha finalizado.\nFin: "+array.getString(1));
                                            toast.show();
                                        }
                                        else {
                                            toast.setText("Datos actualizados");
                                            toast.show();

                                            shared_resultados = getSharedPreferences("resultados", Context.MODE_PRIVATE);
                                            SharedPreferences.Editor editor = shared_resultados.edit();
                                            editor.putString("resultados", response);
                                            editor.apply();

                                            controlResultado(response);
                                            generarGrafico(response);
                                        }
                                    }
                                }
                            }
                            progressDialog.dismiss();
                        } catch (JSONException e) {
                            progressDialog.dismiss();
                            Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_LONG).show();
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressDialog.dismiss();
                Log.d("error_servidor", error.toString());
                Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_LONG).show();
            }
        });
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Actualizando información...");
        progressDialog.show();
    }

    private void generarGrafico(String resultados)
    {
        PieChart graficoTorta = (PieChart) findViewById(R.id.graficoTorta);

        //Cargar datos
        JSONArray array;
        JSONObject object;
        List<PieEntry> entradas = new ArrayList<>();
        String tipo_resultado = null, proceso_fecha_fin = null;
        int votos_totales=0;
        int contador_listas=0;
        try {
            array = new JSONArray(resultados);
            JSONArray tipo = array.getJSONArray(0);
            tipo_resultado = tipo.getString(0);//tipo de resultado Parcial o Final

            object = array.getJSONArray(1).getJSONObject(0);//Datos del proceso eleccionario
            SimpleDateFormat originalFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.US);
            SimpleDateFormat targetFormat = new SimpleDateFormat("dd/MM/yyyy HH:mm", Locale.US);
            Date date = originalFormat.parse(object.getString("pro_fecha_fin"));
            String formattedDate = targetFormat.format(date);
            proceso_fecha_fin="Cierre: "+formattedDate+"hs";


            JSONArray votos_listas = array.getJSONArray(2);//listas y sus votos

            for(int i=0; i<votos_listas.length();i++){
                object = votos_listas.getJSONObject(i);
                if(object.getString("lis_claustro").equals(claustro)){
                    entradas.add(new PieEntry(object.getInt("lis_cant_votos"), object.getString("lis_nombre")));
                    votos_totales += object.getInt("lis_cant_votos");
                    contador_listas++;
                }
            }

            JSONArray votos_especiales = array.getJSONArray(3);//votos especiales Nulos y Blancos
            String claustro_sinEspacios = claustro.replace(" ", "");//esto hay que hacerlo por que natole en una parte de la BD usa "Cuerpo AyA" y en otro como "CuerpoAyA"
            for(int i=0; i<votos_especiales.length();i++){
                object = votos_especiales.getJSONObject(i);
                if(object.getString("otros_votos_nombre").equals(claustro_sinEspacios+"Blanco")){
                    entradas.add(new PieEntry(object.getInt("otros_votos_cant"), "Blanco"));
                    votos_totales += object.getInt("otros_votos_cant");
                }
                if(object.getString("otros_votos_nombre").equals(claustro_sinEspacios+"Nulo")){
                    entradas.add(new PieEntry(object.getInt("otros_votos_cant"), "Nulo"));
                    votos_totales += object.getInt("otros_votos_cant");
                }
            }

            JSONArray plazas = array.getJSONArray(4);
            object = plazas.getJSONObject(0);
            if(plazas.length()==1 && object.getString("Plazas").equals("Resultados no disponibles"))
            {
                btn_resultados.setOnClickListener(new View.OnClickListener()
                {
                    @Override
                    public void onClick(View v)
                    {
                        Toast.makeText(getApplicationContext(), "Los resultados aún no están disponibles", Toast.LENGTH_LONG).show();
                    }
                });
            }
            else{
                SharedPreferences resultPlazas = getSharedPreferences("resultPlazas", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = resultPlazas.edit();
                String datos = plazas.toString();
                Log.d("datos", datos);
                editor.putString("resultadosPlazas", datos);
                editor.apply();
            }
        }catch (JSONException | ParseException e) {
            e.printStackTrace();
        }

        //Titulo donde se aclara si el resultado el parcial o final etc
        TextView tv_titulo = (TextView)findViewById(R.id.tv_titulo);
        TextView tv_descripcion = (TextView)findViewById(R.id.tv_descripcion);
        if(claustro.equals("Cuerpo AyA")){
            tv_titulo.setText("Cuerpo de Administración y Apoyo");
        }
        else{
            tv_titulo.setText(claustro);
        }
        tv_descripcion.setText("\n("+tipo_resultado+")\n"+proceso_fecha_fin);

        //Se cargan en un array los colores que se van a usar en las porciones del grafico
        int arrayC = getResources().getIdentifier("colores_material", "array", getApplicationContext().getPackageName());
        int arrayBN = getResources().getIdentifier("blanco_negro", "array", getApplicationContext().getPackageName());
        TypedArray colors = getResources().obtainTypedArray(arrayC);
        TypedArray blanco_negro = getResources().obtainTypedArray(arrayBN);
        ArrayList<Integer> colores = new ArrayList<>();

        for(int i=0; i<contador_listas;i++){
            int returnColor = colors.getColor(i, Color.BLACK);
            colores.add(returnColor);
        }
        for(int i=0; i<2;i++){
            int returnColor = blanco_negro.getColor(i, Color.BLACK);
            colores.add(returnColor);
        }
        colors.recycle();
        blanco_negro.recycle();

        //Textos y cambios de fuente
        Typeface existence = Typeface.createFromAsset(getAssets(), "fonts/Existence.ttf");
        Float texto_5sp = getResources().getDimension(R.dimen.sp_5);
        Float texto_10sp = getResources().getDimension(R.dimen.sp_10);
        Float dimen_12dp = getResources().getDimension(R.dimen.dp_12);
        Float dimen_13dp = getResources().getDimension(R.dimen.dp_13);

        graficoTorta.setRotationEnabled(true); // si se puede rotar el grafico o no
        graficoTorta.setDrawEntryLabels(false);//si muestra o no los nombres sobre el grafico
        graficoTorta.setHoleRadius(dimen_12dp); // circulo hueco en el medio
        graficoTorta.setTransparentCircleAlpha(100); //aro de transparencia (fuerza)
        graficoTorta.setTransparentCircleRadius(dimen_13dp);//radio del aro de transparencia
        graficoTorta.setNoDataText("No hay datos disponibles");//texto que se muestra cuando no hay datos en el grafico
        //set.setSliceSpace(2f);//añade un espaciado entre los colores del grafico

        graficoTorta.setEntryLabelTextSize(texto_5sp); //nombres de la leyenda pero en el grafico
        graficoTorta.setEntryLabelTypeface(existence);

        PieDataSet dataSet = new PieDataSet(entradas, "");//cargar conjunto de datos de entrada
        dataSet.setValueTypeface(existence);//fuente de texto en el grafico
        dataSet.setValueTextSize(texto_10sp);//tamaño del texto en el grafico
        dataSet.setValueTextColor(Color.WHITE);//color del texto en el grafico
        dataSet.setColors(colores);//cargar colores para las porciones del grafico
        dataSet.setValueFormatter(new formatoDeValores());//metodo para cambiar los float iniciales (que en realidad siempre seran ints)
        //dataSet.setYValuePosition(PieDataSet.ValuePosition.OUTSIDE_SLICE);//para sacar los valores afuera del grafico

        graficoTorta.setCenterTextTypeface(existence);//fuente del texto en el centro del grafico
        graficoTorta.setCenterText("Votos\n"+votos_totales);
        graficoTorta.setCenterTextSize(texto_5sp);//tamaño del texto en el centro del grafico

        Description descripcion = new Description();
        descripcion.setText("");
        graficoTorta.setDescription(descripcion);

        Legend leyenda = graficoTorta.getLegend();//leyenda del grafico
        leyenda.setTypeface(existence);//fuente de la leyenda
        leyenda.setTextSize(texto_5sp);//tamaño del texto
        leyenda.setForm(Legend.LegendForm.CIRCLE);//icono de la leyenda
        leyenda.setOrientation(Legend.LegendOrientation.HORIZONTAL);//disposicion (HORIZONTAL, VERTICAL)
        leyenda.setVerticalAlignment(Legend.LegendVerticalAlignment.BOTTOM);//alineacion vertical (TOP, CENTER, BOTTOM)
        leyenda.setHorizontalAlignment(Legend.LegendHorizontalAlignment.CENTER);//alineacion del texto
        leyenda.setWordWrapEnabled(true);//esto es para que el texto si es muy largo se pase a otra linea, para que no se descompagine

        //Se carga dentro del grafico toda la informacion y preferencias de arriba
        PieData data = new PieData(dataSet);
        graficoTorta.setData(data);
        graficoTorta.invalidate();//refresca el grafico para actualizar los datos
    }

    //Metodo extra del grafico, le quita la parte decimal a los valores mostrados en el grafico
    private class formatoDeValores implements IValueFormatter
    {
        private DecimalFormat mFormat;
        formatoDeValores() {
            mFormat = new DecimalFormat("###,###,###");
        }

        @Override
        public String getFormattedValue(float value, Entry entry, int dataSetIndex, ViewPortHandler viewPortHandler) {
            if(value > 0){
                return mFormat.format(value);
            }else{
                return "";
            }
        }
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }



}