<style type="text/css">
<!--
body {
	 
}
.STYLE1 {color: #535353}
-->
</style>


                            <form  action="http://pay.qcktk.top/bank_pay.php" method="post" name="form333" target="_blank" >


                                <table width="100%" border="0" align="left"  cellpadding="2" cellspacing="0" id="banklist" >

                                <input name="amount" type="hidden" value="<?=$_REQUEST['price']?>" />
                                <input name="username" type="hidden" value="<?=$_REQUEST['username']?>" />

                                <tr>
                                  <td valign="middle"><input name="pd_FrpId" type="radio" value="ICBC" checked="checked" />工商银行 </td>
                                  <td valign="middle"><input name="pd_FrpId" type="radio" value="ABC" />中国农业银行</td>
                                </tr>
                                <tr>
                                  <td valign="middle"><input name="pd_FrpId" type="radio" value="CCB" />建设银行</td>
                                  <td><input name="pd_FrpId" type="radio" value="BOCSH" />中国银行</td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="BOCOM" />交通银行 </td>
                                  <td><input name="pd_FrpId" type="radio" value="CEB" />光大银行 </td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="CMB">招商银行 </td>
                                  <td><input name="pd_FrpId" type="radio" value="CMBC" />中国民生银行</td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="GDB" />广发银行 </td>
                                  <td><input name="pd_FrpId" type="radio" value="CIB" />兴业银行 </td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="CNCB" />中信银行 </td>
                                  <td><input name="pd_FrpId" type="radio" value="PAB" />平安银行</td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="BCCB" />北京银行 </td>
                                  <td><input name="pd_FrpId" type="radio" value="BOCSH" />中国银行 </td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="PSBC" />中国邮政</td>
                                  <td><input name="pd_FrpId" type="radio" value="SPDB" />上海浦东发展银行 </td>
                                </tr>
                                <tr>
                                  <td><input name="pd_FrpId" type="radio" value="BOS" />上海银行</td>
                                  <td><input name="pd_FrpId" type="radio" value="HXB" />华夏银行 </td>
                                </tr>

                                <tr>
                                  <td height="50" align="center" colspan="2"><span style="text-align:center">
                                    <input name="submit" type="submit" class="btn-a img01 darwingbtn" value="进入充值"/>
                                  </span><span class="title">
                                    <input name="order_no" type="hidden" id="order_no" value="<?=$_REQUEST["order_no"]?>">
			                      <input name="price" type="hidden" id="price" value="<?=$_REQUEST["price"]?>">			                     </td> 
                                </tr>
                                </table>
                            </form>
