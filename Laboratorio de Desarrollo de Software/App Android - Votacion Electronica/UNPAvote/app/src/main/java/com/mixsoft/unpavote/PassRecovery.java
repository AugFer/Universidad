package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

public class PassRecovery extends Base_toolbar {

    private Button btn_recuperar_pass;
    private EditText et_correo_elec;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.pass_recovery);
        crear(getString(R.string.passR_toolbar_titulo));

        cargarVistas();

        btn_recuperar_pass.setOnClickListener(new View.OnClickListener()
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
        et_correo_elec = (EditText)findViewById(R.id.et_correo_elec);
        btn_recuperar_pass = (Button)findViewById(R.id.btn_recuperar_pass);
    }

    private void validarDatos()
    {
        String email = et_correo_elec.getText().toString().trim();
        et_correo_elec.setText(email);
        boolean validacion = true;
        if(TextUtils.isEmpty(email)){
            et_correo_elec.setError("El campo no puede estar vacío");
            et_correo_elec.requestFocus();
            validacion = false;
        }
        if(validacion){
            recuperarPass(email);
        }
    }

    private void recuperarPass(final String email)
    {
        //Request para volley y contexto + url a la que se hace la peticion
        RequestQueue rqt = Volley.newRequestQueue(PassRecovery.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_passR);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray ja = new JSONArray(response);
                            String respuesta = ja.getString(0);
                            if(respuesta.equals("Ok")) {
                                et_correo_elec.setText("");
                                Toast.makeText(getApplicationContext(), "Contraseña restablecida, revise su email", Toast.LENGTH_LONG).show();
                            }
                            if(respuesta.equals("Error")){
                                et_correo_elec.setError("La email ingresado no está asociado a ninguna cuenta");
                                et_correo_elec.requestFocus();
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
            public void onErrorResponse(VolleyError error){
                progressDialog.dismiss();
                Log.d("error_servidor", error.toString());
                Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams()  {
                Map<String, String> parametros = new HashMap<>();
                parametros.put("correo", email);
                return parametros;
            }
        };
        jsonreq.setRetryPolicy(new DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Restableciendo contraseña...");
        progressDialog.show();
    }

    //Infla la toolbar sin los items del menu, solo con el boton de back/home
    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        return true;
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}
