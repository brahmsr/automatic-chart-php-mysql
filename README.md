# automatic-chart-php-mysql
An automatic chart generated by Google Charts, what i've done some modifications to push some informations of my BD, doing a separation by month or by day.
I've created an database named 'controle_caixa' what means 'cashflow control' and I have a table 'transacoes' what means 'transactions', in this table we have:
# id - primary key autoincrement
# movimentacao - varchar(220) (what is a description of the transaction)
# valor_m - varchar (220) (it's the value of the transaction)
# tipo_m - tinyint (this will inform if it's a expense or gain)
# metodo_m - varchar (220) (it's a info about the tipe of transaction: debit, credit, money, banking transaction)
# criado_em - timestamp (CURRENT_TIMESTAMP) (to have a control about the transactions by day or month)

After that i've gone in Google Charts and obtained the default code of the area graph.
I've deleted the default data what comes with the chart and started with a new archive named graph.php
of course I've done a dbcon.php but this archive i've used via include('graph.php')

in case of you want to do just a page with this chart I will describe the content of the dbcon.php:

<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "controle_caixa";

$con = mysqli_connect("$host", "$username", "$password", "$database");

if (!$con)
{
    die ("Erro na conexao: " . mysqli_connect_error());
}
    

?>
