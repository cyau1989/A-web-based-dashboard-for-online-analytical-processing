<!DOCTYPE html>
<html>           
  <head>                     
    <title> Volume Shipping Query              
    </title>             
  </head>           
  <body>                   
    <table>                           
      <tr>                                     
        <td colspan="2" style="background-color:#FFA500;"><h1>Volume Shipping Query </h1>This query determines the value of goods shipped between certain nations to help in the re-negotiation of shipping contracts.
</br></br>The Volume Shipping Query finds, for two given nations, the gross discounted revenues derived from lineitems in which parts were shipped from a supplier in either nation to a customer in the other nation during 1995 and 1996. The query lists the supplier nation, the customer nation, the year, and the revenue from shipments that took place in that year. The query orders the answer by Supplier nation, Customer nation, and year (all ascending).</td>                             
      </tr>
<?php
$dbconn = pg_connect("host=localhost dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
   ?>                           
      <tr>                                   
        <td style="background-color:#eeeeee;">



          <form> Supplier's Nation:
          <select name="Nation1"> 
              <option value="">Select Supplier's Nation
              </option>        
    <?php
       $query = 'SELECT DISTINCT s_nation FROM supplier_s ORDER BY 1';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
          while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
                      ?>        
            </select>



            Customer's Nation:
          <select name="Nation2"> 
              <option value="">Select Customer's Nation
              </option>        
    <?php
        $query = 'SELECT DISTINCT c_nation FROM customer_s ORDER BY 1';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
                      ?>        
            </select>


            <input type="submit" name="formSubmit" value="Search" >                                
          </form>
<?php
if(isset($_GET['formSubmit'])) 
{
	
	   echo  "<b>Supplier's Nation: </b>";
    echo  "'".$_GET['Nation1']."'<br>";
    echo  "<b>Customer's Nation: </b>";
    echo  "'".$_GET['Nation2']."'<br>";
    
 $query = "select
s_nation,
c_nation,
l_year, 
round(sum(volume),2) as revenue
from (
select
s_nation,
c_nation,
extract(year from d_date) as l_year,
l_revenue as volume
from
supplier_s,
lineorder_s,
customer_s,
date_s
where
s_suppkey = l_suppkey
and c_custkey = l_custkey
and d_datekey = l_shipdatekey
and (
(s_nation =  '".$_GET['Nation1']."' and c_nation = '".$_GET['Nation2']."')
or ( s_nation='".$_GET['Nation2']."' and c_nation = '".$_GET['Nation1']."')
)
and d_date between date '1995-01-01' and date '1996-12-31'
) as shipping
group by
s_nation,
c_nation,
l_year
order by
s_nation,
c_nation,
l_year;";


    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"25%\">
    <col width=\"25%\">
    <col width=\"25%\">
    <col width=\"25%\">

   <tr>
    <th>Supplier Nation</th>
    <th>Customer Nation</th>
    <th>Shipping Year</th>
    <th>Revenue</th>
    </tr>";


    while ($row = pg_fetch_array($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";
    echo "<td>" . $row[1]. "</td>";
    echo "<td>" . $row[2]. "</td>";
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

