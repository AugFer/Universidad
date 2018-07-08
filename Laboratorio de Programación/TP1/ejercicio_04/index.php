<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tablas con HTML</title>
        <base href="http://localhost/ejercicio_04/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <table>
            <caption>Personas fumadoras</caption>
            <thead>
                <tr>
                    <td rowspan="2">País</td>
                    <td colspan="2">Sexo</td>
                    <td rowspan="2">Año</td>
                </tr>
                <tr>
                    <td>Masculino</td>
                    <td>Femenino</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Argentina</td>
                    <td>45 %</td>
                    <td>50 %</td>
                    <td rowspan="3">2010</td>
                </tr>
                <tr>
                    <td>Chile</td>
                    <td>42 %</td>
                    <td>60 %</td>
                </tr>
                <tr>
                    <td>Brasil</td>
                    <td>41 %</td>
                    <td>55 %</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Datos obtenidos de <span>XXXX</span>.</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
