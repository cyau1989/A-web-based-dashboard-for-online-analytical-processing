<!DOCTYPE html>
<html>        
  <head>                
    <title> Local Supplier Volume Query
    </title>          
  </head>        
  <body>              
    <table>                    
      <tr>                            
        <td colspan="2" style="background-color:#FFA500;"><h1>Local Supplier Volume Query</h1>This query lists the revenue volume done through local suppliers.
</br></br>The Local Supplier Volume Query lists for each nation in a region the revenue volume that resulted from lineitem transactions in which the customer ordering parts and the supplier filling them were both within that nation. The query is run in order to determine whether to institute local distribution centers in a given region. The query consid-ers only parts ordered in a given year. The query displays the nations and revenue volume in descending order by revenue. Revenue volume for all qualifying lineitems in a particular nation is defined as l_revenue).</td>                      
      </tr>
<?php
$dbconn = pg_connect("host=localhost dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
                        ?>                    
      <tr>                          
        <td style="background-color:#eeeeee;"> 

        

            <form>  Region:
        <select name="Region"> 
        <option value="">Select Region</option>
        <?php
        $query = 'SELECT DISTINCT c_region FROM customer_s ORDER BY 1';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
        ?>
        </select>



     
               Date:                                        
              <input type="date" min=1992-01-01  max=1999-01-01 name="Date">                                                               
            <input type="submit" name="formSubmit" value="Search" >                                                                                                                    
          </form>



<?php
if(isset($_GET['formSubmit'])) 
{
    echo  "<b>Region Input: </b>";
    echo  "'".$_GET['Region']."'<br>";
   echo  "<b>Date Input: </b>";
    echo  "'".$_GET['Date']."'<br>";

    $query = "select
c_nation,
round(sum(l_revenue),2) as revenue
from
customer_s,
lineorder_s,
supplier_s,
date_s
where
c_custkey = l_custkey
and l_suppkey = s_suppkey
and c_nation = s_nation
and c_region = '".$_GET['Region']."'
and l_orderdatekey = d_datekey
and d_date >= date '".$_GET['Date']."'
and d_date < date '".$_GET['Date']."' + interval '1' year
group by
c_nation
order by
revenue desc;";











    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"50%\">
    <col width=\"50%\">
    <tr>
    <th>Nation</th>
    <th>Revenue</th>   
    </tr>";


    while ($row = pg_fetch_array($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";
      echo "<td>" . $row[1] . "</td>";    
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
        <td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; BT5110 Final Group Project </td>                      
      </tr>              
    </table>        
  </body>
</html>