package com.mixsoft.unpavote;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
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
import android.widget.TableRow;
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
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Votacion extends Base_toolbar
{
    private Button btn_blanco, btn_nulo;
    private String voto, pin;
    private SharedPreferences datosUsuario;
    private ProgressDialog progressDialog;

    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.votacion);
        crear(getString(R.string.vot_toolbar_titulo));

        btn_blanco = (Button)findViewById(R.id.btn_blanco);
        btn_nulo = (Button)findViewById(R.id.btn_nulo);

        //Se carga el shared con las banderas del elector: si ya voto, y si ya tiene pin
        datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
        voto = datosUsuario.getString("voto","");
        if(voto.equals("Si")){ //Si es true, significa que ya votó y se ocultan los botones de la app
            btn_blanco.setVisibility(View.GONE);
            btn_nulo.setVisibility(View.GONE);
        }
        pin = datosUsuario.getString("pin",""); // se usa en el metodo tocarBoton, podria ser local

        cargarActo();

        btn_blanco.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                tocarBoton("Blanco");
            }
        });
        btn_nulo.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                tocarBoton("Nulo");
            }
        });
    }

    public void tocarBoton(final String boton)
    {
        if(pin.equals("Si")) { //Si es true, significa que tiene generado su pin
            final EditText et_pin = new EditText(this);
            et_pin.setInputType(InputType.TYPE_CLASS_TEXT);
            et_pin.setGravity(Gravity.CENTER_HORIZONTAL);

            LinearLayout layout = new LinearLayout(this);
            et_pin.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
            layout.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
            LinearLayout.LayoutParams params = (LinearLayout.LayoutParams) et_pin.getLayoutParams();
            params.setMargins((int) getResources().getDimension(R.dimen.dp_64), 0, (int) getResources().getDimension(R.dimen.dp_64), 0);
            et_pin.setLayoutParams(params);
            layout.addView(et_pin);

            //Se crea el dialogo de alerta donde se pide el pin
            new AlertDialog.Builder(this)
                    .setTitle("Confirmación de voto")
                    .setMessage("Ingrese su PIN de seguridad y confirme la emisión de su voto.")
                    .setView(layout)
                    .setPositiveButton("Sí", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            votar(boton, et_pin.getText().toString());
                        }
                    })
                    .setNegativeButton("No", null)
                    .show();
        }
        else{ //Como no tiene generado su pin, se le muestra un mensaje
            Toast.makeText(getApplicationContext(), "Aún no has generado tu PIN. Puedes hacerlo desde el menú de usuario.", Toast.LENGTH_LONG).show();
        }
    }

    private void votar(final String boton, final String nro_pin)
    {
        RequestQueue rqt = Volley.newRequestQueue(Votacion.this);
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
                            } else {
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
                                                            btn_blanco.setVisibility(View.GONE);
                                                            btn_nulo.setVisibility(View.GONE);

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
                parametros.put("voto", boton);
                return parametros;
            }
        };
        jsonreq.setRetryPolicy(new DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        rqt.add(jsonreq);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Efectuando votación...");
        progressDialog.show();
    }

    private void cargarActo()
    {
        SharedPreferences actoEleccionario = getSharedPreferences("actoEleccionario", Context.MODE_PRIVATE);
        try {
            //Carga nombre del acto y formatea la fecha de cierre
            JSONArray array = new JSONArray(actoEleccionario.getString("actoYListas",""));
            JSONObject object = array.getJSONObject(0);
            TextView tv_titulo = (TextView) findViewById(R.id.tv_titulo);
            tv_titulo.setText(object.getString("pro_nombre"));
            TextView tv_descripcion = (TextView) findViewById(R.id.tv_descripcion);

            SimpleDateFormat originalFormat = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.US);
            SimpleDateFormat targetFormat = new java.text.SimpleDateFormat("dd/MM/yyyy HH:mm", Locale.US);
            Date date = originalFormat.parse(object.getString("pro_fecha_fin"));
            String formattedDate = targetFormat.format(date);
            tv_descripcion.setText("Cierre: "+formattedDate+"hs");


            //Carga de las listas: Arranca en 1 porque en la posicion 0 (usada arriba) esta la informacion del acto eleccionario
            for(int i=1; i<array.length(); i++){
                object = array.getJSONObject(i);
                object.getString("lis_nombre");
                crearLista(object);
            }
        } catch (JSONException | ParseException e) {
            e.printStackTrace();
        }
    }

    private void crearLista(JSONObject object)
    {
        try {
            TableLayout tabla_scroll = (TableLayout)findViewById(R.id.tabla_scroll);

            //Se trae en infla una vista que es base para la creacion de las listas
            LayoutInflater inflater = LayoutInflater.from(Votacion.this);
            TableRow row = (TableRow) inflater.inflate(R.layout.base_tablerow_button, tabla_scroll, false);

            ImageView imgVieLogo = (ImageView) row.getChildAt(0);
            String nombreLista = object.getString("lis_nombre");
            obtenerLogo(imgVieLogo, nombreLista); //Descargar el logo de la lista

            final Button btn = (Button) row.getChildAt(1);
            btn.setText(object.getString("lis_nombre"));
            btn.setId(Integer.parseInt(object.getString("lis_id")));
            final int id = btn.getId();

            btn.setOnClickListener(new View.OnClickListener()
            {
                @Override
                public void onClick(View v)
                {
                    //Se crea un intent y se le colocan datos para pasearselos a la proxima actividad
                    Intent intent = new Intent(Votacion.this, Lista.class);
                    intent.putExtra("id", String.valueOf(id));
                    intent.putExtra("lista", btn.getText());
                    intent.putExtra("voto", voto);

                    //La actividad actual espera por una respuesta al momento en el que la nueva sea finalizada
                    startActivityForResult(intent, 1); //El 1 es el identificador de la respuesta, se utiliza en el metodo onActivityResult
                }
            });

            //Se agrega la lista al listado scrolleable de listas candidatas
            tabla_scroll.addView(row, new TableLayout.LayoutParams(TableLayout.LayoutParams.MATCH_PARENT, TableLayout.LayoutParams.WRAP_CONTENT));
        }catch (JSONException e){
            Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_LONG).show();
            e.printStackTrace();
        }
    }

    //Metodo que espera la respuesta de la actividad siguiente
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        switch(requestCode) { //requestCode es el identificador de la respuesta definido en crearLista
            case (1) : {
                if (resultCode == RESULT_OK) { //Nombre de la respuesta
                    String voto = data.getStringExtra("voto"); //Recibe dato pasado en el intent por la actividad anterior (Lista)
                    if(voto.equals("Si")){ //Si es true, significa que se votó a la lista de la actividad siguiente. Se ocultan los botones
                        btn_blanco.setVisibility(View.GONE);
                        btn_nulo.setVisibility(View.GONE);
                    }
                }
                break;
            }
        }
    }

    //Metodo de la libreria picasso para cargar los logos de las listas
    private void obtenerLogo(ImageView imgVieLogo, String nombreLista)
    {
        String url = getString(R.string.url_servidor)+getString(R.string.url_servidor_logo);
        String nombre = nombreLista.replaceAll(" ", "%20");
        Picasso.with(this).invalidate(url+nombre+".jpg"); //Invalida el cache para cargar el logo siempre que se inicie la actividad

        Picasso.with(this).load(url+nombre+".jpg") //Carga el logo correspondiente o coloca una imagen de error por default
                .networkPolicy(NetworkPolicy.NO_CACHE)
                .error(R.drawable.no_img)
                .into(imgVieLogo);
    }

    //Este es el metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}