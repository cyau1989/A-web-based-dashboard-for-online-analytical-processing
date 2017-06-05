<!DOCTYPE html>
<html>        
  <head>                
    <title> Returned Item Reporting Query
    </title>          
  </head>        
  <body>              
    <table>                    
      <tr>                            
        <td colspan="2" style="background-color:#FFA500;"><h1> Returned Item Reporting Query </h1>The query identifies customers who might be having problems with the parts that are shipped to them.
        </br></br>The Returned Item Reporting Query finds the top 20 customers, in terms of their effect on lost revenue for a given quarter, who have returned parts. The query considers only parts that were ordered in the specified quarter. The query lists the customer's name, address, nation, phone number, account balance, comment information and revenue lost. The customers are listed in descending order of lost revenue. Revenue lost is defined as l_revenue for all qualifying lineitems.
        </td>                      
      </tr>
<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=final user=postgres password=Passw2rd")
    or die('Could not connect: ' . pg_last_error());
?>                    
      <tr>                          
        <td style="background-color:#eeeeee;">                                
          <form>        Date:                                        
           <input type="date" min=1992-01-01  max=1999-01-01 name="Date">                                                                 
            <input type="submit" name="formSubmit" value="Search" >                                
          </form>
<?php
if(isset($_GET['formSubmit'])) 
{
		echo  "<b>Date Input: </b>";
    echo  "'".$_GET['Date']."'<br>";
    
    $query = "select
c_custkey,
c_name,
cast(sum(l_revenue) as numeric(10,2)) as revenue,
c_acctbal,
c_nation,
c_address,
c_phone,
c_comment
from
customer_s,
lineorder_s,
date_s
where
c_custkey = l_custkey
and l_orderdatekey = d_datekey
and d_date >= date '".$_GET['Date']."'
and d_date < date '".$_GET['Date']."' + interval '3' month
and l_returnflag = 'R'
group by
c_custkey,
c_name,
c_acctbal,
c_phone,
c_nation,
c_address,
c_comment
order by
revenue desc
limit 20;";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"75%\">
    <col width=\"25%\">
    <tr>
    <th>Customer Key</th>
    <th>Customer Name</th>   
    <th>Revenue</th>  
    <th>Account Balance</th> 
    <th>Nation</th> 
    <th>Address</th> 
    <th>Phone</th> 
    <th>Comment</th> 
    </tr>";
    while ($row = pg_fetch_array($result)){
      echo "<tr>";
      echo "<td>" . $row[0]. "</td>";
      echo "<td>" . $row[1] . "</td>";    
      echo "<td>" . $row[2] . "</td>";  
      echo "<td>" . $row[3] . "</td>";  
      echo "<td>" . $row[4] . "</td>";  
      echo "<td>" . $row[5] . "</td>";  
      echo "<td>" . $row[6] . "</td>";  
      echo "<td>" . $row[7] . "</td>";  
      
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