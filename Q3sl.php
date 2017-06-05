<!DOCTYPE html>
<html>        
  <head>                
    <title> Shipping Priority Query
    </title>          
  </head>        
  <body>              
    <table>                    
      <tr>                            
        <td colspan="2" style="background-color:#FFA500;"><h1>Shipping Priority Query </h1>This query retrieves the 10 unshipped orders with the highest value.
 </br></br>The Shipping Priority Query retrieves the shipping priority and potential revenue, defined as l_revenue, of the orders having the largest revenue among those that had not been shipped as of a given date. Orders are listed in decreasing order of revenue. If more than 10 unshipped orders exist, only the 10 orders with the largest revenue are listed.</td>                      
      </tr>
<?php
$dbconn = pg_connect("host=localhost dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
                        ?>                    
      <tr>                          
        <td style="background-color:#eeeeee;"> 

<form>Segment:
          <select name="Segment"> 
              <option value="">Select Segment
              </option>        
    <?php
        $query = 'SELECT DISTINCT c_mktsegment FROM customer_s ORDER BY 1';
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
   echo  "<b>Segament Input: </b>";
    echo  "'".$_GET['Segment']."'<br>";
    echo  "<b>Region Input: </b>";
    echo  "'".$_GET['Date']."'<br>";

    $query = "select
l_orderkey,
round(sum(l_revenue),2) as revenue,
s1.d_date,
l_shippriority


from
customer_s,
lineorder_s,
date_s s1,
date_s s2
where
c_mktsegment = '".$_GET['Segment']."'
and c_custkey = l_custkey
and l_orderdatekey=s1.d_datekey
and l_shipdatekey=s2.d_datekey
and s1.d_date < date'".$_GET['Date']."'
and s2.d_date > date '".$_GET['Date']."'
group by
l_orderkey,
s1.d_date,
l_shippriority
order by
revenue desc,
s1.d_date
limit 10;";











    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"25%\">
    <col width=\"25%\">
    <col width=\"25%\">
    <col width=\"25%\">
    <tr>
    <th>Order Number</th>
    <th>Revenue</th>   
    <th>Order Date</th>  
    <th>Shipping Priority</th>
    </tr>";


    while ($row = pg_fetch_array($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";
      echo "<td>" . $row[1] . "</td>";    
      echo "<td>" . $row[2] . "</td>";  
      echo "<td>" . $row[3]. "</td>";
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