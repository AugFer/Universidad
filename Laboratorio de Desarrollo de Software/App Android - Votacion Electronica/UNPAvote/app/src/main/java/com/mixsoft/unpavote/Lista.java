package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.Toolbar;
import android.text.InputType;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.squareup.picasso.NetworkPolicy;
import com.squareup.picasso.Picasso;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.util.HashMap;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Lista extends Base_toolbar
{
    private String nombreLista, voto, pin;
    private Button btn_votar;
    SharedPreferences datosUsuario;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.lista);
        crear(getString(R.string.lis_toolbar_titulo));

        TextView tv_nom_lista = (TextView) findViewById(R.id.tv_nom_lista);
        btn_votar = (Button) findViewById(R.id.btn_votar);

        //Se carga el shared con las banderas del elector: si ya voto, y si ya tiene pin
        datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
        voto = datosUsuario.getString("voto","");
        if(voto.equals("Si")){
            btn_votar.setVisibility(View.GONE);
        }
        pin = datosUsuario.getString("pin","");

        nombreLista = getIntent().getStringExtra("lista"); //Recibe dato pasado en el intent por la actividad anterior (Votacion)
        tv_nom_lista.setText(nombreLista);

        obtenerLogo();
        obtenerCandidatos();

        btn_votar.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                tocarBoton(nombreLista);
            }
        });
    }

    public void tocarBoton(final String nombreLista)
    {
        if(pin.equals("Si")) { //Si es true, significa que tiene generado su pin
            final EditText pin = new EditText(this);
            pin.setInputType(InputType.TYPE_CLASS_TEXT);
            pin.setGravity(Gravity.CENTER_HORIZONTAL);

            LinearLayout layout = new LinearLayout(this);
            pin.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
            layout.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
            LinearLayout.LayoutParams params = (LinearLayout.LayoutParams) pin.getLayoutParams();
            params.setMargins((int) getResources().getDimension(R.dimen.dp_64), 0, (int) getResources().getDimension(R.dimen.dp_64), 0);
            pin.setLayoutParams(params);
            layout.addView(pin);

            //Se crea el dialogo de alerta donde se pide el pin
            new AlertDialog.Builder(this)
                    .setTitle("Confirmación de voto")
                    .setMessage("Ingrese su PIN de seguridad y confirme la emisión de su voto. Si aún no lo ha generado, puede hacerlo desde el menú de usuario.")
                    .setView(layout)
                    .setPositiveButton("Sí", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            String nro_pin = pin.getText().toString();
                            votar(nombreLista, nro_pin);
                        }
                    })
                    .setNegativeButton("No", null)
                    .show();
        }
        else{ //Como no tiene generado su pin, se le muestra un mensaje
            Toast.makeText(getApplicationContext(), "Aún no has generado tu PIN", Toast.LENGTH_LONG).show();
        }
    }

    private void votar(final String nombreLista, final String nro_pin)
    {
        RequestQueue rqt = Volley.newRequestQueue(Lista.this);
        String url = this.getString(R.string.url_servidor)+this.getString(R.string.url_vot_votar);

        StringRequest jsonreq = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>(){
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("response",response);
                            JSONArray array = new JSONArray(response);
                            String respuesta = array.getString(0);

                            //Declaraciones generales de un mensaje emergente que se completara segun corresponda en los IF siguientes
                            Toast toast = Toast.makeText(getApplicationContext(), "", Toast.LENGTH_LONG);
                            TextView v = (TextView) toast.getView().findViewById(android.R.id.message);
                            if( v != null) v.setGravity(Gravity.CENTER);

                            if (respuesta.equals("Error de conexion")) { //Error en una consulta del lado del servidor
                                toast.setText("Error en de conexión con el servidor");
                                toast.show();
                            } else{
                                if (respuesta.equals("Error de conexion durante la generacion de su comprobante de votacion")) { //Error en una consulta del lado del servidor
                                    toast.setText("Error de conexión durante la generación de su comprobante de votación");
                                    toast.show();
                                } else {
                                    if (respuesta.equals("No hay ningun acto eleccionario")) { //Si no hay un acto cargado
                                        toast.setText("No hay ningún acto eleccionario programado");
                                        toast.show();
                                    } else {
                                        if (respuesta.equals("El acto eleccionario ya ha finalizado")) { //Si hay acto pero ya finalizó
                                            toast.setText("El acto eleccionario ya ha finalizado. Fin: " + array.getString(1));
                                            toast.show();
                                        } else {
                                            if (respuesta.equals("Ya has emitido tu voto en estas elecciones")) { //Si ya ha votado, no deberia saltar nunca a menos que se hackee la app
                                                toast.setText("Ya has emitido tu voto en estas elecciones");
                                                toast.show();
                                            } else {
                                                if (respuesta.equals("Aun no has generado tu PIN")) { //Si aún no generó su pin, no deberia saltar nunca a menos que se hackee la app
                                                    toast.setText("Aun no has generado tu PIN");
                                                    toast.show();
                                                } else {
                                                    if (respuesta.equals("El PIN ingresado es incorrecto")) { //Si el pin que ingresó no coincide con el de la BD
                                                        toast.setText("El PIN ingresado es incorrecto");
                                                        toast.show();
                                                    } else {
                                                        if (respuesta.equals("Ok")) { //Si el voto se emite correctamente, muestra mensaje y oculta botones
                                                            toast.setText("Voto emitido correctamente");
                                                            toast.show();
                                                            btn_votar.setVisibility(View.GONE);

                                                            //Actualiza la bandera voto del shared datosUsuario
                                                            SharedPreferences.Editor editor = datosUsuario.edit();
                                                            editor.putString("voto", "Si");
                                                            editor.apply();
                                                        }
                                                    }
                                                }
                                            }
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
                //Se carga el shared de datos del usuario y se sacan valores para enviar en la solicitud
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                parametros.put("ele_legajo", datosUsuario.getString("legajo",""));
                parametros.put("ele_claustro", datosUsuario.getString("claustro",""));
                //Adicionalmente se envian el PIN ingresado en el dialogo de alerta y el string de parametro en tocarBoton
                parametros.put("pin", nro_pin);
                parametros.put("voto", nombreLista);
                return parametros;
            }
        };
        jsonreq.setRetryPolicy(new DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Efectuando votación...");
        progressDialog.show();
    }

    private void obtenerCandidatos()
    {
        try {
            //Se carga el shared que tiene a los candidatos
            SharedPreferences listadoCandidatos = getSharedPreferences("listadoCandidatos", Context.MODE_PRIVATE);
            JSONArray array = new JSONArray(listadoCandidatos.getString("Candidatos",""));
            JSONObject object;
            for(int i=0; i<array.length(); i++){
                object = array.getJSONObject(i);
                if(nombreLista.equals(object.getString("cand_lista"))){ //Solo se crean los candidatos que correspondan con la lista actual
                    crearCandidato(object);
                }
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void crearCandidato(JSONObject object)
    {
        try {
            TableLayout tabla_scroll = (TableLayout)findViewById(R.id.tabla_scroll);

            //Se trae en infla una vista que es base para la creacion de los candidatos
            LayoutInflater inflater = LayoutInflater.from(Lista.this);
            LinearLayout linearL = (LinearLayout) inflater.inflate(R.layout.base_textview, tabla_scroll, false);
            TextView textView = (TextView) linearL.getChildAt(0);

            textView.setText(object.getString("per_nombres"));
            textView.append(" "+object.getString("per_apellidos"));
            textView.setTypeface(null, Typeface.BOLD);
            textView = (TextView) linearL.getChildAt(1);
            textView.setText(object.getString("cand_cargo"));

            //Se agrega el candidato al listado scrolleable de candidatos
            tabla_scroll.addView(linearL, new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT));
        }catch (JSONException e){
            e.printStackTrace();
        }
    }

    //Metodo de la libreria picasso para cargar los logos de las listas
    private void obtenerLogo()
    {
        ImageView img_lista = (ImageView)findViewById(R.id.img_lista);
        String url = getString(R.string.url_servidor)+getString(R.string.url_servidor_logo);
        String nombre = nombreLista.replaceAll(" ", "%20");
        //Notar que a diferencia que en Votacion, acá no se invalida el cache por lo que la libreria no descarga la imagen de nuevo
        //sino que busca la que esta cacheada
        Picasso.with(this).load(url+nombre+".jpg")
                .networkPolicy(NetworkPolicy.NO_CACHE)
                .error(R.drawable.no_img)
                .into(img_lista);
    }

    // Sobreescribe el metodo de pulsar la flecha del menu para devolver la respuesta a Votacion
    @Override
    public void flechaAtras(Toolbar toolbar)
    {
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
             @Override
             public void onClick (View v){
                 Intent intent = new Intent();
                 intent.putExtra("voto", datosUsuario.getString("voto",""));
                 setResult(RESULT_OK, intent);
                 finish();
             }
         }
        );
    }

    // Sobreescribe el metodo de la accion de pulsar atras en el celular para devolver la respuesta a Votacion
    @Override
    public void onBackPressed()
    {
        Intent intent = new Intent();
        intent.putExtra("voto",datosUsuario.getString("voto",""));
        setResult(RESULT_OK, intent);
        finish();
    }

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}