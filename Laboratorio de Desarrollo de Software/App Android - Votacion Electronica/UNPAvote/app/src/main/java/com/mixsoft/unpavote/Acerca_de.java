package com.mixsoft.unpavote;

import android.content.Context;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.View;
import android.widget.TextView;

import com.github.aakira.expandablelayout.ExpandableRelativeLayout;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Acerca_de extends Base_toolbar{
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.acerca_de);
        crear(getString(R.string.ace_toolbar_titulo));
        TextView tv_version = (TextView)findViewById(R.id.tv_version);
        String version = "";
        try {
            tv_version.append(getApplicationContext().getPackageManager().getPackageInfo(getApplicationContext().getPackageName(), 0).versionName);
        } catch (PackageManager.NameNotFoundException e) {
            e.printStackTrace();
        }

    }

    //Infla la toolbar sin el menu
    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        super.onCreateOptionsMenu(menu);
        menu.removeItem(R.id.ayuda);
        menu.removeItem(R.id.logout);
        menu.removeItem(R.id.acerca_de);
        return true;
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}