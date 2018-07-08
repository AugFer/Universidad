package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import org.json.JSONArray;
import org.json.JSONException;
import java.math.BigInteger;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Contrasena extends Base_toolbar
{
    private Button btn_actualizar_pass;
    private EditText et_pass_actual, et_pass_nueva, et_pass_repetir_nueva;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.contrasena);
        crear(getString(R.string.con_toolbar_titulo));

        cargarVistas();

        btn_actualizar_pass.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                validarDatos();
            }
        });
    }

    private void cargarVistas()
    {
        btn_actualizar_pass = (Button)findViewById(R.id.btn_actualizar_pass);
        et_pass_actual = (EditText)findViewById(R.id.et_pass_actual);
        et_pass_nueva = (EditText)findViewById(R.id.et_pass_nueva);
        et_pass_repetir_nueva = (EditText)findViewById(R.id.et_pass_repetir_nueva);
    }

    private void validarDatos()
    {
        String actual=et_pass_actual.getText().toString();
        String nueva=et_pass_nueva.getText().toString();
        String repNueva=et_pass_repetir_nueva.getText().toString();
        boolean vacio=false;

        //Se chequean al revez de como aparecen en el layout para que el focus quede en el orden correcto
        if(TextUtils.isEmpty(repNueva)){
            et_pass_repetir_nueva.setError("El campo no puede estar vacío");
            et_pass_repetir_nueva.requestFocus();
            vacio=true;
        }
        if(TextUtils.isEmpty(nueva)){
            et_pass_nueva.setError("El campo no puede estar vacío");
            et_pass_nueva.requestFocus();
            vacio=true;
        }
        if(TextUtils.isEmpty(actual)){
            et_pass_actual.setError("El campo no puede estar vacío");
            et_pass_actual.requestFocus();
            vacio=true;
        }
        if(!vacio) {
            if (TextUtils.equals(nueva, repNueva)) {
                String md5_actual_pass = md5(actual);
                String md5_nueva_pass = md5(nueva);
                SharedPreferences prefe = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                String legajo = prefe.getString("legajo", "");
                actualizarPass(legajo, md5_actual_pass, md5_nueva_pass);
            } else {
                et_pass_repetir_nueva.setError("Las contraseñas no coinciden");
                et_pass_repetir_nueva.requestFocus();
            }
        }
    }

    private void actualizarPass(final String legajo, final String md5_actual_pass, final String md5_nueva_pass)
    {
        //Request para volley y contexto + url a la que se hace la peticion
        RequestQueue rqt = Volley.newRequestQueue(Contrasena.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_cont);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray ja = new JSONArray(response);
                            String respuesta = ja.getString(0);
                            if(respuesta.equals("Ok")) {
                                et_pass_actual.setText("");
                                et_pass_nueva.setText("");
                                et_pass_repetir_nueva.setText("");
                                Toast.makeText(getApplicationContext(), "Contraseña actualizada", Toast.LENGTH_LONG).show();
                            }
                            if(respuesta.equals("Error")){
                                et_pass_actual.setError("La contraseña ingresada no coincide con la actual");
                                et_pass_actual.requestFocus();
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
                parametros.put("ele_legajo", legajo);
                parametros.put("actual_pass", md5_actual_pass);
                parametros.put("nueva_pass", md5_nueva_pass);
                return parametros;
            }
        };
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Actualizando contraseña...");
        progressDialog.show();
    }

    private static String md5(String s)
    {
        MessageDigest digest;
        try
        {
            digest = MessageDigest.getInstance("MD5");
            digest.update(s.getBytes(Charset.forName("US-ASCII")),0,s.length());
            byte[] magnitude = digest.digest();
            BigInteger bi = new BigInteger(1, magnitude);
            String hash = String.format("%0" + (magnitude.length << 1) + "x", bi);
            return hash;
        }
        catch (NoSuchAlgorithmException e)
        {
            e.printStackTrace();
        }
        return "";
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}
