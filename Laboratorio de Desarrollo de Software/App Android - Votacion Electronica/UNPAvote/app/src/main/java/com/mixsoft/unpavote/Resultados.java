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

public class Resultados extends Base_toolbar
{
    private Button btn_resultados, btn_profesores, btn_auxiliares, btn_admin_y_apoyo, btn_alumnos;
    private String tipo_resultado;
    private ProgressDialog progressDialog;
    private SharedPreferences shared_resultados;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.resultados);
        crear(getString(R.string.res_toolbar_titulo));

        btn_resultados = (Button) findViewById(R.id.btn_resultados);
        btn_profesores = (Button) findViewById(R.id.btn_profesores);
        btn_auxiliares = (Button) findViewById(R.id.btn_auxiliares);
        btn_admin_y_apoyo = (Button) findViewById(R.id.btn_admin_y_apoyo);
        btn_alumnos = (Button) findViewById(R.id.btn_alumnos);

        String resultados = getIntent().getStringExtra("Resultados");
        shared_resultados = getSharedPreferences("resultados", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = shared_resultados.edit();
        editor.putString("resultados", resultados);
        editor.apply();

        Log.d("RESULTADOS", resultados);
        controlResultado(resultados);
        completarVistas(resultados);

        btn_profesores.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Intent intent = new Intent(Resultados.this, Resultados_grafico.class);
                intent.putExtra("Claustro", "Profesores");
                startActivity(intent);
            }
        });

        btn_auxiliares.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Intent intent = new Intent(Resultados.this, Resultados_grafico.class);
                intent.putExtra("Claustro", "Auxiliares");
                startActivity(intent);
            }
        });

        btn_admin_y_apoyo.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Intent intent = new Intent(Resultados.this, Resultados_grafico.class);
                intent.putExtra("Claustro", "Cuerpo AyA");
                startActivity(intent);
            }
        });

        btn_alumnos.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Intent intent = new Intent(Resultados.this, Resultados_grafico.class);
                intent.putExtra("Claustro", "Alumnos");
                startActivity(intent);
            }
        });
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
        RequestQueue rqt = Volley.newRequestQueue(Resultados.this);
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
                                            completarVistas(response);
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

    private void completarVistas(String resultados)
    {
        //Cargar datos
        JSONArray array;
        JSONObject object;
        String tipo_resultado = null, proceso_nombre = null, proceso_fecha_fin = null;

        try {
            array = new JSONArray(resultados);
            JSONArray tipo = array.getJSONArray(0);
            tipo_resultado = tipo.getString(0);//tipo de resultado Parcial o Final

            object = array.getJSONArray(1).getJSONObject(0);//Datos del proceso eleccionario
            proceso_nombre = object.getString("pro_nombre");
            SimpleDateFormat originalFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.US);
            SimpleDateFormat targetFormat = new SimpleDateFormat("dd/MM/yyyy HH:mm", Locale.US);
            Date date = originalFormat.parse(object.getString("pro_fecha_fin"));
            String formattedDate = targetFormat.format(date);
            proceso_fecha_fin="Cierre: "+formattedDate+"hs";

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
        tv_titulo.setText(proceso_nombre);
        tv_descripcion.setText("\n("+tipo_resultado+")\n"+proceso_fecha_fin);
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    @Override
    public void onResume()
    {
        super.onResume();
        shared_resultados = getSharedPreferences("resultados", Context.MODE_PRIVATE);
        String resultados = shared_resultados.getString("resultados","");
        controlResultado(resultados);
    }

}