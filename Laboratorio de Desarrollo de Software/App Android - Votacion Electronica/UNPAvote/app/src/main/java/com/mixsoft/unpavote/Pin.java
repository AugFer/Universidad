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
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Pin extends Base_toolbar
{
    String control;
    Button btn_generar, btn_reenviar;
    TextView tv_descripcion;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.pin);
        crear(getString(R.string.pin_toolbar_titulo));

        btn_generar = (Button)findViewById(R.id.btn_generar);
        btn_reenviar = (Button)findViewById(R.id.btn_reenviar);
        tv_descripcion = (TextView)findViewById(R.id.tv_descripcion);

        control = getIntent().getStringExtra("control");
        iniciarBotones(control);
    }

    private void iniciarBotones(String control)
    {
        if(control.equals("Ya tiene")){
            btn_generar.setVisibility(View.GONE);
            tv_descripcion.setText(getString(R.string.pin_txt_descripcion_reenviar));
            btn_reenviar.setOnClickListener(new View.OnClickListener()
            {
                @Override
                public void onClick(View v)
                {
                    String url = getString(R.string.url_servidor)+getString(R.string.url_pin_reenviar);
                    peticion("Reenviar", url);
                }
            });
        }
        else{
            btn_reenviar.setVisibility(View.GONE);
            btn_generar.setOnClickListener(new View.OnClickListener()
            {
                @Override
                public void onClick(View v)
                {
                    String url = getString(R.string.url_servidor)+getString(R.string.url_pin_generar);
                    peticion("Generar", url);
                }
            });
        }
    }

    private void peticion(final String botonPulsado, String url)
    {
        RequestQueue rqt = Volley.newRequestQueue(Pin.this);

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

                            if (respuesta.equals("Error")) {
                                toast.setText("Error en el servidor");
                                toast.show();
                            }
                            else {
                                if (respuesta.equals("Ok")) {
                                    if(botonPulsado.equals("Reenviar")){
                                        toast.setText("PIN reenviado exitosamente");
                                        toast.show();
                                    }
                                    if(botonPulsado.equals("Generar")){
                                        String pin = array.getString(1);
                                        btn_generar.setVisibility(View.GONE);

                                        String str = getString(R.string.pin_txt_descripcion_generado);
                                        str = new StringBuilder(str).insert(11, pin).toString();
                                        str = new StringBuilder(str).insert(17, "\n\n").toString();
                                        tv_descripcion.setText(str);
                                        negritaYsubrayado(tv_descripcion);

                                        toast.setText("PIN generado exitosamente");
                                        toast.show();
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
        }) {
            @Override
            protected Map<String, String> getParams()  {
                Map<String, String> parametros = new HashMap<>();
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                parametros.put("ele_legajo", datosUsuario.getString("legajo",""));
                parametros.put("correo", datosUsuario.getString("email",""));
                return parametros;
            }
        };
        jsonreq.setRetryPolicy(new DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        if(botonPulsado.equals("Generar")){
            progressDialog.setMessage("Generando PIN...");
        }
        else{
            progressDialog.setMessage("Reenviando PIN...");
        }
        progressDialog.show();
    }

    private void negritaYsubrayado(TextView tv)
    {
        final SpannableStringBuilder spanBuild = new SpannableStringBuilder(tv.getText());
        final StyleSpan boldStyle = new StyleSpan(android.graphics.Typeface.BOLD);
        spanBuild.setSpan(boldStyle, 11, 17, Spannable.SPAN_INCLUSIVE_INCLUSIVE);
        tv.setText(spanBuild);
    }

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}