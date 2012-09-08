
<h1>Sample First Data Global Gateway Connect Order Form</h1>

<h1>Order Form</h1>
<p>Your order chargetotal is: 13.99.</p>  

 <!--
 online action  https://www.linkpointcentral.com/lpc/servlet/lppay
 
 test action https://www.staging.linkpointcentral.com/lpc/servlet/lppay
 -->

<FORM action="https://www.staging.linkpointcentral.com/lpc/servlet/lppay" method="post">
<input type="hidden" name="storename" value="1909078235">
<input type="hidden" name="chargetotal" value="62.35" >
<input type="hidden" name="txnorg" value="eci">
<input type="hidden" name="mode" value="PayPlus">
<input type="hidden" name="txntype" value="sale">
Credit card number: <input type="text" name="cardnumber" size="20"
maxlength="30"><br>
Expires: <SELECT name="expmonth" size="1"> <OPTION
value="">...</OPTION> <OPTION value="1">Jan</OPTION>
<OPTION value="2">Feb</OPTION>
<OPTION value="3">Mar</OPTION>
<OPTION value="4">Apr</OPTION>
<OPTION value="5">May</OPTION>
<OPTION value="6">Jun</OPTION>
<OPTION value="7">Jul</OPTION>
<OPTION value="8">Aug</OPTION>
<OPTION value="9">Sep</OPTION>
<OPTION value="10">Oct</OPTION>
<OPTION value="11">Nov</OPTION>
<OPTION value="12">Dec</OPTION>
</SELECT> / <select NAME="expyear" SIZE="1">
<OPTION value="">...</OPTION>
<option value="2004"> 2004 </option>
<option value="2005"> 2005 </option>
<option value="2006"> 2006 </option>
<option value="2007"> 2007 </option>
<option value="2008"> 2008 </option>
<option value="2009"> 2009 </option>
<option value="2010"> 2010 </option>
<option value="2011"> 2011 </option>
<option value="2012"> 2012 </option>
<option value="2013"> 2013 </option>
</select><br>
Card Code: <input type="text" name="cvm" size="4"> <input
type="checkbox" name="cvmnotpres"> Code not present <br>
Name: <input type="text" name="bname" size="30" maxlength="30"><br>
Address (1st line): <input type="text" name="baddr1" size="30"
maxlength="30"><br>
Zip code: <input type="text" name="bzip" size="5" maxlength="10">
<br><br>
<INPUT type="submit" value="Continue to secure payment form">
</FORM>

