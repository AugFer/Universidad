package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
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
import org.json.JSONArray;
import org.json.JSONException;
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class MenuPrincipal extends Base_toolbar
{
    private static final int TIME_INTERVAL = 2000; //Milisegundos entre los dos toques del boton atras
    private long mBackPressed;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.menu_principal);
        crear(getString(R.string.menu_toolbar_titulo));

        Button btn_usuario = (Button)findViewById(R.id.btn_usuario);
        Button btn_votacion = (Button)findViewById(R.id.btn_votacion);
        Button btn_comprobante = (Button)findViewById(R.id.btn_comprobante);
        Button btn_resultados = (Button)findViewById(R.id.btn_resultados);

        btn_usuario.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                startActivity(new Intent(getApplicationContext(),Usuario.class));
            }
        });

        btn_votacion.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                obtenerInfoElecciones();
            }
        });

        btn_resultados.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                obtenerResultados();
            }
        });

        btn_comprobante.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                obtenerComprobante();
            }
        });

    }

    private void obtenerInfoElecciones()
    {
        RequestQueue rqt = Volley.newRequestQueue(MenuPrincipal.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_vot);

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
                                            //Se actualizan por las dudas los valores de voto y pin en el shared del usuario
                                            SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                                            SharedPreferences.Editor editor = datosUsuario.edit();
                                            JSONArray subarray = array.getJSONArray(0);
                                            String datos = subarray.getString(0);
                                            editor.putString("voto", datos);
                                            datos = subarray.getString(1);
                                            editor.putString("pin", datos);
                                            editor.apply();

                                            //Se crea un shared con la info del acto eleccionario y las listas
                                            subarray = array.getJSONArray(1);
                                            datos = subarray.toString();
                                            SharedPreferences actoEleccionario = getSharedPreferences("actoEleccionario", Context.MODE_PRIVATE);
                                            editor = actoEleccionario.edit();
                                            editor.putString("actoYListas", datos);
                                            editor.apply();

                                            //Se crea un shared con los datos de los candidatos
                                            subarray = array.getJSONArray(2);
                                            datos = subarray.toString();
                                            SharedPreferences listadoCandidatos = getSharedPreferences("listadoCandidatos", Context.MODE_PRIVATE);
                                            editor = listadoCandidatos.edit();
                                            editor.putString("Candidatos", datos);
                                            editor.apply();

                                            startActivity(new Intent(getApplicationContext(),Votacion.class));
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
                Log.d("error_servidor", error.toString());
                progressDialog.dismiss();
                Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams()  {
                Map<String, String> parametros = new HashMap<>();
                //Se carga el shared de datos del usuario y se sacan valores para enviar en la solicitud
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                parametros.put("ele_claustro", datosUsuario.getString("claustro",""));
                parametros.put("ele_legajo", datosUsuario.getString("legajo",""));
                return parametros;
            }
        };
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Descargando información");
        progressDialog.show();
    }

    private void obtenerComprobante()
    {
        RequestQueue rqt = Volley.newRequestQueue(MenuPrincipal.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_comp);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray array = new JSONArray(response);
                            String respuesta = array.getString(0);

                            Toast toast = Toast.makeText(getApplicationContext(), "", Toast.LENGTH_LONG);
                            TextView v = (TextView) toast.getView().findViewById(android.R.id.message);
                            if( v != null) v.setGravity(Gravity.CENTER);

                            if (respuesta.equals("Error de conexion")) { //Error en una consulta del lado del servidor
                                toast.setText("Error en la recuperación de información");
                                toast.show();
                            }else {
                                if (respuesta.equals("No hay ningun acto eleccionario")) { //Si no hay un acto cargado
                                    toast.setText("No hay ningún acto eleccionario programado");
                                    toast.show();
                                } else {
                                    if (respuesta.equals("El acto eleccionario aun no ha comenzado")) { //Si hay acto pero aun no comenzó
                                        toast.setText("El acto eleccionario aún no ha comenzado.\nIncio: " + array.getString(1));
                                        toast.show();
                                    } else {
                                        if (respuesta.equals("Aun no has votado")) {

                                            toast.setText("Aun no has votado");
                                            toast.show();
                                        } else {
                                            Intent intent = new Intent(MenuPrincipal.this, Comprobante.class);
                                            intent.putExtra("Comprobante", response);
                                            startActivity(intent);
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
                Log.d("error_servidor", error.toString());
                progressDialog.dismiss();
                Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_LONG).show();
            }
        }){
            @Override
            protected Map<String, String> getParams()  {
                Map<String, String> parametros = new HashMap<>();
                //Se carga el shared de datos del usuario y se sacan valores para enviar en la solicitud
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                parametros.put("ele_legajo", datosUsuario.getString("legajo",""));
                return parametros;
            }
        };
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Descargando información");
        progressDialog.show();
    }

    private void obtenerResultados()
    {
        RequestQueue rqt = Volley.newRequestQueue(MenuPrincipal.this);
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
                                            Intent intent = new Intent(MenuPrincipal.this, Resultados.class);
                                            intent.putExtra("Resultados", response);
                                            startActivity(intent);
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
                Log.d("error_servidor", error.toString());
                progressDialog.dismiss();
                Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_LONG).show();
            }
        });
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Descargando información");
        progressDialog.show();
    }

    // Sobreescribe el metodo crear de la superclase para agregarle el icono y quitar un boton
    @Override
    public void crear(String titulo)
    {
        super.crear(titulo);
        getSupportActionBar().setLogo(R.mipmap.unpavote_circular);
        getSupportActionBar().setDisplayUseLogoEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(false);
        TextView toolbarTitulo = (TextView) this.findViewById(R.id.toolbar_titulo);
        toolbarTitulo.setPadding(30, 0, 0, 0);
    }

    // Sobreescribe el metodo de la accion de pulsar atras en el celular para pedir dos pulsaciones antes de cerrar la app
    @Override
    public void onBackPressed()
    {
        if (mBackPressed + TIME_INTERVAL > System.currentTimeMillis())
        {
            super.onBackPressed();
            return;
        }
        else
        {
            Toast.makeText(getBaseContext(), "Presiona de nuevo para salir", Toast.LENGTH_SHORT).show();
        }
        mBackPressed = System.currentTimeMillis();
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}