<!DOCTYPE html>
<html>           
  <head>                     
    <title> Discounted Revenue Query                    
    </title>             
  </head>           
  <body>                   
    <table>                           
      <tr>                                     
        <td colspan="2" style="background-color:#FFA500;"><h1> Discounted Revenue Query </h1>The Discounted Revenue Query reports the gross discounted revenue attributed to the sale of selected parts handled in a particular manner.
        </br></br>The Discounted Revenue query finds the gross discounted revenue for all orders for three different types of parts that were shipped by air and delivered in person. Parts are selected based on the combination of specific brands, a list of containers, and a range of sizes.
        </td>                             
      </tr>
</br>      
<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
                              ?>                           
      <tr>
                                         
        <td style="background-color:#eeeeee;">                                           
          <form> Small Containers                  
            <select name="brand_1"> 
              <option value="">Select Brand
              </option>        
    <?php
        $query = 'SELECT DISTINCT p_brand FROM part ORDER BY p_brand';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
                      ?>        
            </select>       
            Quantity 1: <input type="text" name="quantity_1">
            </br>
            
            
          Medium Containers
          <select name="brand_2"> 
              <option value="">Select Brand
              </option>        
<?php
        $query = 'SELECT DISTINCT p_brand FROM part ORDER BY p_brand';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
                      ?>        
            </select>                          
            Quantity 2: <input type="text" name="quantity_2"> </br>
            
            Large Containers
            <select name="brand_3"> 
              <option value="">Select Brand
              </option>        
<?php
        $query = 'SELECT DISTINCT p_brand FROM part ORDER BY p_brand';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while ($row = pg_fetch_row($result)){
          echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
        }
        pg_free_result($result);
                      ?>        
            </select>                 
            Quantity 3: <input type="text" name="quantity_3">                                                                                          
            <input type="submit" name="formSubmit" value="Search" >                                           
          </form></br>

<?php
$space = "<br>";
if(isset($_GET['formSubmit'])) 
{$space = "<br>";
		echo  "<b>Small Containers: </b>";
    echo  "'".$_GET['brand_1']."'";
    echo $space = "<br>"; 
    echo  "<b>Quantity: </b>";
    echo  "'".$_GET['quantity_1']."'<br>";
    echo $space = "<br>";
    echo  "<b>Medium Containers: </b>";
    echo  "'".$_GET['brand_2']."'";
    echo $space = "<br>";
    echo  "<b>Quantity: </b>";
    echo  "'".$_GET['quantity_2']."'<br>";
    echo $space = "<br>";
    echo  "<b>Large Containers: </b>";
    echo  "'".$_GET['brand_3']."'"; 
    echo $space = "<br>";
    echo  "<b>Quantity: </b>";
    echo  "'".$_GET['quantity_3']."'<br>";
    $space = "<br>";
$query = "SELECT round(sum(l_revenue),2)
          FROM  lineorder_s, part_s
          WHERE (p_partkey = l_partkey
          AND p_brand = '".$_GET['brand_1']."'
          AND p_container in ('SM CASE', 'SM BOX', 'SM PACK', 'SM PKG')
          AND l_quantity >= '".$_GET['quantity_1']."' and l_quantity <= '".$_GET['quantity_1']."' + 10
          AND p_size between 1 and 5
          AND l_shipmode in ('AIR', 'AIR REG')
          AND l_shipinstruct = 'DELIVER IN PERSON')
           or(
p_partkey = l_partkey
and p_brand = '".$_GET['brand_2']."'
and p_container in ('MED BAG', 'MED BOX', 'MED PKG', 'MED PACK')
and l_quantity >= '".$_GET['quantity_2']."' and l_quantity <= '".$_GET['quantity_2']."' + 10
and p_size between 1 and 10
and l_shipmode in ('AIR', 'AIR REG')
and l_shipinstruct = 'DELIVER IN PERSON'
)
or
(
p_partkey = l_partkey
and p_brand = '".$_GET['brand_3']."'
and p_container in ( 'LG CASE', 'LG BOX', 'LG PACK', 'LG PKG')
and l_quantity >= '".$_GET['quantity_3']."' and l_quantity <= '".$_GET['quantity_3']."' + 10
and p_size between 1 and 15
and l_shipmode in ('AIR', 'AIR REG')
and l_shipinstruct = 'DELIVER IN PERSON'
)";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo $space = "<br>";
    echo "<table border=\"1\">
    <col width=\"75%\">
    <col width=\"25%\">
    <tr>
    <th>Gross Discounted Revenue</th>     
    </tr>";
    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";     
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