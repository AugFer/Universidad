package com.mixsoft.unpavote;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TextView;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Resultados_plazas extends Base_toolbar
{
    String banderaClaustro="";

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.resultados_plazas);
        crear(getString(R.string.res_plazas_toolbar_titulo));

        obtenerPlazas();
    }

    private void obtenerPlazas()
    {
        try {
            SharedPreferences resultPlazas = getSharedPreferences("resultPlazas", Context.MODE_PRIVATE);
            JSONArray array = new JSONArray(resultPlazas.getString("resultadosPlazas",""));
            JSONObject object;
            for(int i=0; i<array.length(); i++){
                object = array.getJSONObject(i);
                if(!object.getString("res_claustro").equals(banderaClaustro))
                {
                    banderaClaustro=object.getString("res_claustro");

                    TableLayout tabla_scroll = (TableLayout)findViewById(R.id.tabla_scroll);

                    LayoutInflater inflater = LayoutInflater.from(Resultados_plazas.this);
                    LinearLayout linearL = (LinearLayout) inflater.inflate(R.layout.base_textview, tabla_scroll, false);

                    TextView textView = (TextView) linearL.getChildAt(0);
                    textView.setText(object.getString("res_claustro"));
                    textView.setTypeface(null, Typeface.BOLD);
                    textView.setTextSize(TypedValue.COMPLEX_UNIT_SP,25);
                    textView.setPadding(0,10,0,0);
                    textView.setTextColor(ContextCompat.getColor(this, R.color.turquesa_oscuro));

                    textView = (TextView) linearL.getChildAt(1);
                    textView.setVisibility(View.GONE);

                    //Se agrega el claustro al que pertenecen las plazas siguientes
                    tabla_scroll.addView(linearL, new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT));
                }
                crearResultPlaza(object);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void crearResultPlaza(JSONObject object)
    {
        try {
            TableLayout tabla_scroll = (TableLayout)findViewById(R.id.tabla_scroll);

            //Se trae en infla una vista que es base para la creacion de los candidatos
            LayoutInflater inflater = LayoutInflater.from(Resultados_plazas.this);
            LinearLayout linearL = (LinearLayout) inflater.inflate(R.layout.base_textview, tabla_scroll, false);
            TextView textView = (TextView) linearL.getChildAt(0);

            textView.setText(object.getString("res_cargo"));
            textView.setTypeface(null, Typeface.BOLD);

            textView = (TextView) linearL.getChildAt(1);
            textView.setText(object.getString("per_nombres"));
            textView.append(" "+object.getString("per_apellidos"));
            textView.append(" - "+object.getString("res_lista"));

            //Se agrega el candidato al listado scrolleable
            tabla_scroll.addView(linearL, new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT));
        }catch (JSONException e){
            e.printStackTrace();
        }
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}