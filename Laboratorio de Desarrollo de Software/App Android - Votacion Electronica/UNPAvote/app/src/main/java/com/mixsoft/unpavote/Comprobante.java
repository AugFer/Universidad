package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.Spannable;
import android.text.SpannableStringBuilder;
import android.text.style.StyleSpan;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Comprobante extends Base_toolbar
{
    private TextView tv_legajo, tv_dni, tv_apellido, tv_nombre, tv_claustro, tv_cargo_carrera, tv_transaccion;
    private Button btn_reenviar;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.comprobante);
        crear(getString(R.string.com_toolbar_titulo));

        String comprobante = getIntent().getStringExtra("Comprobante");
        cargarVistas();
        negritaYsubrayado();
        cargarComprobante(comprobante);

        btn_reenviar.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                btn_reenviar.setEnabled(false);
                reenviarComprobante();
            }
        });

    }

    private void reenviarComprobante()
    {
        String url = getString(R.string.url_servidor)+getString(R.string.url_comp_reenviar);
        RequestQueue rqt = Volley.newRequestQueue(Comprobante.this);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("response",response);
                            JSONArray array = new JSONArray(response);
                            String respuesta = array.getString(0);
                            Toast toast = Toast.makeText(getApplicationContext(), "", Toast.LENGTH_LONG);
                            TextView v = (TextView) toast.getView().findViewById(android.R.id.message);
                            if( v != null) v.setGravity(Gravity.CENTER);

                            if (respuesta.equals("Error de conexion durante el envio de su comprobante")) {
                                toast.setText("Error de conexión durante el envío de su comprobante");
                                toast.show();
                            }
                            else {
                                if (respuesta.equals("Ok")) {
                                    toast.setText("Comprobante reenviado exitosamente");
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
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                parametros.put("ele_legajo", datosUsuario.getString("legajo",""));
                parametros.put("email", datosUsuario.getString("email",""));
                return parametros;
            }
        };
        jsonreq.setRetryPolicy(new DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Reenviando comprobante...");
        progressDialog.show();
    }

    private void cargarVistas()
    {
        tv_legajo = (TextView) findViewById(R.id.tv_legajo);
        tv_dni = (TextView) findViewById(R.id.tv_dni);
        tv_apellido = (TextView) findViewById(R.id.tv_apellido);
        tv_nombre = (TextView) findViewById(R.id.tv_nombre);
        tv_claustro = (TextView) findViewById(R.id.tv_claustro);
        tv_cargo_carrera = (TextView) findViewById(R.id.tv_cargo_carrera);
        tv_transaccion = (TextView) findViewById(R.id.tv_transaccion);
        btn_reenviar = (Button)findViewById(R.id.btn_reenviar);
    }

    private void cargarComprobante(String comprobante)
    {
        try {
            JSONArray array = new JSONArray(comprobante);

            JSONObject object = array.getJSONObject(0);
            tv_legajo.append(" "+object.getString("ele_legajo"));
            tv_dni.append(" "+object.getString("ele_dni"));
            tv_apellido.append(" "+object.getString("per_apellidos"));
            tv_nombre.append(" "+object.getString("per_nombres"));
            tv_claustro.append(" "+object.getString("ele_claustro"));
            tv_cargo_carrera.append(" "+object.getString("ele_cargo_carrera"));

            object = array.getJSONObject(1);
            tv_transaccion.append(" "+object.getString("voto_transaccion"));
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void negritaYsubrayado()
    {
        for(int i=1; i<=7; i++)
        {
            TextView tv=tv_legajo;
            switch(i)
            {
                case 1:
                    tv = tv_legajo;
                    break;
                case 2:
                    tv = tv_dni;
                    break;
                case 3:
                    tv = tv_apellido;
                    break;
                case 4:
                    tv = tv_nombre;
                    break;
                case 5:
                    tv = tv_claustro;
                    break;
                case 6:
                    tv = tv_cargo_carrera;
                    break;
                case 7:
                    tv = tv_transaccion;
                    break;

            }
            final SpannableStringBuilder spanBuild = new SpannableStringBuilder(tv.getText());
            final StyleSpan boldStyle = new StyleSpan(android.graphics.Typeface.BOLD);
            spanBuild.setSpan(boldStyle, 0, tv.length()-1, Spannable.SPAN_INCLUSIVE_INCLUSIVE);
            //spanBuild.setSpan(new UnderlineSpan(), 0, tv.length()-1, 0);
            tv.setText(spanBuild);
        }
    }

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}
