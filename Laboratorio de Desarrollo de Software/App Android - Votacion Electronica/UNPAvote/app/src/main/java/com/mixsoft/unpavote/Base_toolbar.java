package com.mixsoft.unpavote;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

public class Base_toolbar extends AppCompatActivity {

    public void crear(String titulo) {
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        TextView toolbarTitulo = (TextView) toolbar.findViewById(R.id.toolbar_titulo);
        toolbarTitulo.setText(titulo);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        flechaAtras(toolbar);
    }

    public void flechaAtras(Toolbar toolbar) {
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick (View v){
                finish();
            }
        }
        );
    }

    @Override
    public void onBackPressed() {
        finish();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        getMenuInflater().inflate(R.menu.menu_accion, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        switch (item.getItemId())
        {
            case R.id.logout:
                SharedPreferences datosUsuario = getSharedPreferences("datosUsuario", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = datosUsuario.edit();
                editor.clear();
                editor.apply();


                Intent intent = new Intent(getApplicationContext(), Login.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                Toast.makeText(getApplicationContext(), "Sesión finalizada", Toast.LENGTH_LONG).show();
                startActivity(intent);
                finish();
                return true;
            case R.id.ayuda:
                startActivity(new Intent(getApplicationContext(), Ayuda.class));
                return true;
            case R.id.acerca_de:
                startActivity(new Intent(getApplicationContext(), Acerca_de.class));
                return true;
        }
        return true;
    }
}