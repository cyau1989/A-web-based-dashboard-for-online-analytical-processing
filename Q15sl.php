<!DOCTYPE html>
<html>        
  <head>                
    <title> Top Supplier Query
    </title>          
  </head>        
  <body>              
    <table>                    
      <tr>                            
        <td colspan="2" style="background-color:#FFA500;"><h1> Top Supplier Query </h1>This query determines the top supplier so it can be rewarded, given more business, or identified for special recogni-tion.
        </br></br>The Top Supplier Query finds the supplier who contributed the most to the overall revenue for parts shipped during a given quarter of a given year. In case of a tie, the query lists all suppliers whose contribution was equal to the maximum, presented in supplier number order.
        </td>                      
      </tr>
<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
                        ?>                    
      <tr>                          
        <td style="background-color:#eeeeee;">                                
          <form>        
      
        Date                                       
            <input type="date" min=1992-01-01  max=1999-01-01 name="Date">                                                                    
  
            
            <input type="submit" name="formSubmit" value="Search" >   
            
          </form>
<?php

if(isset($_GET['formSubmit'])) 

{
				echo  "<b>Date Input: </b>";
    echo  "'".$_GET['Date']."'<br>";

    $query = "
select
s_suppkey,
s_name,
s_address,
s_phone,
cast(total_revenue as numeric(10,2))
from
supplier_s,
(select
l_suppkey as supplier_no,
sum(l_revenue) as total_revenue
from
lineorder_s, date_s
where
date_s.d_date >= date '".$_GET['Date']."'
and date_s.d_date < date '".$_GET['Date']."' + interval '3' month
and date_s.d_datekey = l_shipdatekey
group by
l_suppkey ) as revenue
where
s_suppkey = supplier_no
and total_revenue = (
select
max(total_revenue)
from
(select
l_suppkey as supplier_no,
sum(l_revenue) as total_revenue
from
lineorder_s, date_s
where
date_s.d_date >= date '".$_GET['Date']."'
and date_s.d_date < date '".$_GET['Date']."' + interval '3' month
and  date_s.d_datekey = l_shipdatekey
group by
l_suppkey ) as revenue
)
order by
s_suppkey;";

    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"75%\">
    <col width=\"25%\">
    <tr>
    <th>Supplier Key</th>
    <th>Name</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Total Revenue</th>
    
 
    </tr>";
    while ($row = pg_fetch_array($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";
      echo "<td>" . $row[1]. "</td>";
      echo "<td>" . $row[2]. "</td>";
      echo "<td>" . $row[3]. "</td>";
      echo "<td>" . $row[4]. "</td>";
 

      
      echo "</tr>";
    }
    echo "</table>";
 
    pg_free_result($result);
    }
                        ?></td>                             
      </tr>
<?php
pg_close($dbconn);
                        ?>                    
      <tr>                          
        <td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; BT5110 </td>                      
      </tr>              
    </table>        
  </body>
</html>