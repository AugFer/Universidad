package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
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

public class Usuario extends Base_toolbar
{
    private Button btn_contrasena, btn_pin;
    private TextView tv_nombre, tv_apellido, tv_legajo, tv_claustro, tv_cargo_carrera, tv_email;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.usuario);
        crear(getString(R.string.usu_toolbar_titulo));

        cargarVistas();
        negritaYsubrayado();
        cargarDatosDeUsuario();

        btn_contrasena.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                startActivity(new Intent(getApplicationContext(),Contrasena.class));
            }
        });

        btn_pin.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                consultarPin();
            }
        });
    }

    private void consultarPin()
    {
        RequestQueue rqt = Volley.newRequestQueue(Usuario.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_usu_pin);

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

                            if (respuesta.equals("Error de conexion")) {
                                toast.setText("Error en la recuperación de información");
                                toast.show();
                            }
                            else {
                                if (respuesta.equals("No hay ningun acto eleccionario")) {
                                    toast.setText("No hay ningún acto eleccionario programado");
                                    toast.show();
                                }
                                else {
                                    if (respuesta.equals("El acto eleccionario aun no ha comenzado")) {
                                        toast.setText("El acto eleccionario aún no ha comenzado.\nIncio: "+array.getString(1));
                                        toast.show();
                                    }
                                    else {
                                        if (respuesta.equals("El acto eleccionario ya ha finalizado")) {
                                            toast.setText("El acto eleccionario ya ha finalizado.\nFin: "+array.getString(1));
                                            toast.show();
                                        }
                                        else {
                                            Intent intent = new Intent(Usuario.this, Pin.class);
                                            intent.putExtra("control", respuesta);
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
                return parametros;
            }
        };
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Sincronizando información...");
        progressDialog.show();
    }

    private void cargarVistas()
    {
        tv_nombre = (TextView)findViewById(R.id.tv_nombre);
        tv_apellido = (TextView)findViewById(R.id.tv_apellido);
        tv_legajo = (TextView)findViewById(R.id.tv_legajo);
        tv_claustro = (TextView)findViewById(R.id.tv_claustro);
        tv_cargo_carrera = (TextView)findViewById(R.id.tv_cargo_carrera);
        tv_email = (TextView)findViewById(R.id.tv_email);
        btn_contrasena = (Button)findViewById(R.id.btn_contrasena);
        btn_pin = (Button)findViewById(R.id.btn_pin);
    }

    private void cargarDatosDeUsuario()
    {
        SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
        tv_nombre.append(" "+datosUsuario.getString("nombre",""));
        tv_apellido.append(" "+datosUsuario.getString("apellido",""));
        tv_legajo.append(" "+datosUsuario.getString("legajo",""));
        tv_claustro.append(" "+datosUsuario.getString("claustro",""));
        tv_cargo_carrera.append(" "+datosUsuario.getString("cargo_carrera",""));
        tv_email.append(" "+datosUsuario.getString("email",""));
    }

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    private void negritaYsubrayado()
    {
        for(int i=1; i<=6; i++)
        {
            TextView tv=tv_nombre;
            switch(i)
            {
                case 1:
                    tv = tv_nombre;
                    break;
                case 2:
                    tv = tv_apellido;
                    break;
                case 3:
                    tv = tv_legajo;
                    break;
                case 4:
                    tv = tv_claustro;
                    break;
                case 5:
                    tv = tv_cargo_carrera;
                    break;
                case 6:
                    tv = tv_email;
                    break;
            }
            final SpannableStringBuilder spanBuild = new SpannableStringBuilder(tv.getText());
            final StyleSpan boldStyle = new StyleSpan(android.graphics.Typeface.BOLD);
            spanBuild.setSpan(boldStyle, 0, tv.length()-1, Spannable.SPAN_INCLUSIVE_INCLUSIVE);
            //spanBuild.setSpan(new UnderlineSpan(), 0, tv.length()-1, 0);
            tv.setText(spanBuild);
        }
    }
}