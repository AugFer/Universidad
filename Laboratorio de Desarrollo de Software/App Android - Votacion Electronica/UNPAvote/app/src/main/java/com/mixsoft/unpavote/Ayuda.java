package com.mixsoft.unpavote;

import android.content.Context;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import com.github.aakira.expandablelayout.ExpandableRelativeLayout;
import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Ayuda extends Base_toolbar
{
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ayuda);
        crear(getString(R.string.ayu_toolbar_titulo));
    }

    //Expandir/contraer los items de las preguntas
    public void accion(View view)
    {
        String tag = "expandableLayout"+view.getTag().toString();
        int resId = getResources().getIdentifier(tag, "id", getPackageName());
        ExpandableRelativeLayout exRelatLay = (ExpandableRelativeLayout) this.findViewById(resId);
        exRelatLay.toggle();
    }

    //Infla la toolbar sin el item de -ayuda-
    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        super.onCreateOptionsMenu(menu);
        menu.removeItem(R.id.ayuda);
        return true;
    }

    //Metodo de la libreria para cambiar la fuente de las vistas
    @Override
    protected void attachBaseContext(Context newBase)
    {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
}