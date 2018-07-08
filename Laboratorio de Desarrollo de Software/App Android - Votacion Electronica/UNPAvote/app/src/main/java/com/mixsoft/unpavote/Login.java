package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
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
import org.json.JSONObject;
import java.math.BigInteger;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Login extends AppCompatActivity
{
    private Button btn_login;
    private TextView tv_forg_pass;
    private EditText et_ele_legajo, et_ele_pass;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.login);

        //Se chequea si el sharedpreferences tiene info guardada, si tiene, se abre el menu principal directamente
        SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
        if(datosUsuario.getString("legajo","").length()>0){
            startActivity(new Intent(getApplicationContext(),MenuPrincipal.class));
            finish();
        }

        btn_login = (Button)findViewById(R.id.btn_login);
        tv_forg_pass = (TextView) findViewById(R.id.tv_forg_pass);
        et_ele_legajo = (EditText)findViewById(R.id.et_ele_legajo);
        et_ele_pass = (EditText)findViewById(R.id.et_ele_pass);

        btn_login.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                validarDatos();
            }
        });

        tv_forg_pass.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                startActivity(new Intent(getApplicationContext(),PassRecovery.class));
            }
        });
    }

    private void validarDatos()
    {
        String legajo = et_ele_legajo.getText().toString();
        String pass = et_ele_pass.getText().toString();
        boolean validacion = true;

        //Se chequean al revez de como aparecen en el layout para que el focus quede en el orden correcto
        if(TextUtils.isEmpty(pass)){
            et_ele_pass.setError("El campo no puede estar vacío");
            et_ele_pass.requestFocus();
            validacion = false;
        }
        if(pass.length()<8){
            et_ele_pass.setError("La contraseña debe tener al menos 8 caracteres");
            et_ele_pass.requestFocus();
            validacion = false;
        }
        if(TextUtils.isEmpty(legajo)){
            et_ele_legajo.setError("El campo no puede estar vacío");
            et_ele_legajo.requestFocus();
            validacion = false;
        }
        if(validacion){
            if(legajo.length()==13){
                String md5_pass = md5(pass);
                login(legajo, md5_pass);
            }
            else{
                et_ele_legajo.setError("El legajo se compone de 13 caracteres: x-xxxxxxxx/xx");
                et_ele_legajo.requestFocus();
            }
        }
    }

    private void login(final String legajo, final String md5_pass)
    {
        //Request para volley y contexto + url a la que se hace la peticion
        RequestQueue rqt = Volley.newRequestQueue(Login.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_login);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray array = new JSONArray(response);
                            JSONObject object = array.getJSONObject(0);

                            SharedPreferences datosUsuario = getSharedPreferences("datosUsuario",Context.MODE_PRIVATE);
                            SharedPreferences.Editor editor = datosUsuario.edit();
                            editor.putString("voto", object.getString("ele_voto"));
                            editor.putString("pin", object.getString("ele_pin"));
                            editor.putString("legajo", object.getString("ele_legajo"));
                            editor.putString("claustro", object.getString("ele_claustro"));
                            editor.putString("cargo_carrera", object.getString("ele_cargo_carrera"));
                            editor.putString("nombre", object.getString("per_nombres"));
                            editor.putString("apellido", object.getString("per_apellidos"));
                            editor.putString("email", object.getString("per_email"));
                            editor.apply();

                            progressDialog.dismiss();
                            Toast.makeText(getApplicationContext(), "Sesión iniciada", Toast.LENGTH_LONG).show();
                            startActivity(new Intent(getApplicationContext(),MenuPrincipal.class));
                            finish();
                        } catch (JSONException e) {
                            progressDialog.dismiss();
                            Toast.makeText(getApplicationContext(), "Datos inválidos", Toast.LENGTH_LONG).show();
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
                parametros.put("ele_pass", md5_pass);
                return parametros;
            }
        };
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Iniciando sesión...");
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

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}