<?php
$mBankId=$this->param['mBankId'];
$sql="select mb.*, b.name bankName, b.logo bankLogo, b.home bankHome,mb.qrcode from {$this->prename}sysadmin_bank mb, {$this->prename}bank_list b where mb.id=$mBankId and b.isDelete=0 and mb.bankId=b.id";

$memberBank=$this->getRow($sql);
$set=$this->getSystemSettings();
?>


         <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>充值信息</div>
    <div class="f24 myt_text">
              充值说明：<br>
        1.扫二维码支付，需要在<b style="display:inline;color:#ff2525;">备注输入充值帐号信息</b>，<b style="display:inline;color:#ff2525;">如：充值帐号：123456。</b><br>
        2.转账后如<b style="display:inline;color:#ff2525;">5分钟</b>未到账，请联系客服，告知您的充值编号和您的充值金额及你的充值账号。<br>
        3.充值有效金额：<b style="display:inline;color:#ff2525;"><?=$set['rechargeMin1']?>元-<?=$set['rechargeMax1']?>元</b>。充值金额请输入非整数，以便平台更快速为您进行充值，谢谢！例如：充值<b style="display:inline;color:#ff2525;">2000.01</b>元。
    </div>
<?php
if($memberBank['bankId']==12){
    ?>

    <table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
        <tr class='table_b_th'>
            <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>充值信息</td>
        </tr>
        <tr height=25 class='table_b_tr_b' >
            <td align="right" height="80" class="copys" width="20%">充值银行：</td>
            <td align="left" ><img id="bank-type-icon" class="bankimg" src="/<?=$memberBank['bankLogo']?>" title="<?=$memberBank['bankName']?>" /></td>
        </tr>
        <tr height=25 class='table_b_tr_b'>
            <td align="right" class="copys">充值金额：</td>
            <td align="left" ><input id="recharg-amount" readonly value="<?=$this->param['amount']?>" />
                <div class="btn-a copy" for="recharg-amount">
                </div>      </td>
        </tr>
        <tr height=25 class='table_b_tr_b'>
            <td align="right" class="copys"> 充值编号 ：</td>
            <td align="left"><input id="username" readonly value="<?=$this->param['rechargeId']?>" />
                <div class="btn-a copy" for="username">
                </div>			</td>
        </tr>
        <tr height=25 class='table_b_tr_h'>
            <td colspan="2" align="right" class="copyss">
                <div align="center">

                    <form  action="http://pay.01969.top/bank_pay.php" method="post" name="form333" target="_blank" >



                        <table width="100%" border="0" align="left"  cellpadding="2" cellspacing="0" id="banklist" style="display: none;" >

                            <input name="amount" type="hidden" value="<?=$this->param['amount']?>" />
                            <input name="username" type="hidden" value="<?=$this->user['username']?>" />

                            <tr>
                                <td ><input type="radio" name="bank_code" id="bank0" value="qq"  checked="checked"/>QQ扫码支付</td>
                                <td ><div align="left"></td>
                            </tr>
                            <tr>
                                <td valign="middle"><input name="bank_code" type="radio" value="ICBC" />工商银行 </td>
                                <td valign="middle"><input name="bank_code" type="radio" value="ABC" />中国农业银行</td>
                            </tr>
                            <tr>
                                <td valign="middle"><input name="bank_code" type="radio" value="CCB" />建设银行</td>
                                <td><input name="bank_code" type="radio" value="BOCSH" />中国银行</td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="BOCOM" />交通银行 </td>
                                <td><input name="bank_code" type="radio" value="CEB" />光大银行 </td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="CMB">招商银行 </td>
                                <td><input name="bank_code" type="radio" value="CMBC" />中国民生银行</td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="GDB" />广发银行 </td>
                                <td><input name="bank_code" type="radio" value="CIB" />兴业银行 </td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="CNCB" />中信银行 </td>
                                <td><input name="bank_code" type="radio" value="PAB" />平安银行</td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="BCCB" />北京银行 </td>
                                <td><input name="bank_code" type="radio" value="BOCSH" />中国银行 </td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="PSBC" />中国邮政</td>
                                <td><input name="bank_code" type="radio" value="SPDB" />上海浦东发展银行 </td>
                            </tr>
                            <tr>
                                <td><input name="bank_code" type="radio" value="BOS" />上海银行</td>
                                <td><input name="bank_code" type="radio" value="HXB" />华夏银行 </td>
                            </tr>

                        </table>
                        <table width="100%" border="0" align="left"  cellpadding="2" cellspacing="0" id="banklist" >
                            <tr>
                                <td height="50" align="center" colspan="2"><span style="text-align:center">
                                    <input name="submit" type="submit" class="btn-a img01 darwingbtn myt_btn tc chongzhi_btn" value="进入充值"/>
                                  </span><span class="title">
                                    <input name="order_no" type="hidden" id="order_no" value="<?=$this->param['rechargeId']?>">
			                      <input name="price" type="hidden" id="price" value="<?=$this->param['amount']?>">			                     </td>
                            </tr>
                        </table>
                    </form>

                </div></td>
            </td>
        </tr>
    </table>
<?php }else if($memberBank['bankId']==2 || $memberBank['bankId']==3 || $memberBank['bankId']==21){  //支付宝 ?>
        <ul class="myi_list myt_list myt_list1" style="padding-bottom: 0;">
            <li class="clearfix rel">
                <div class="fl myw">充值方式：</div>
                <img class="col67 fl" style="min-width: auto;width: auto;" src="/<?=$memberBank['bankLogo']?>" title="<?=$memberBank['bankName']?>">
            </li>
            <li class="clearfix rel">
                <div class="fl myw">充值金额：</div>
                <p class="col67 fl"><?=$_POST['amount']?></p>
            </li>
            <li class="clearfix rel f22" style="padding:.1rem 0 .2rem .2rem; color:#666; line-height: 1.4;height: auto;">
                *充值金额必须与网站填写金额一致方能到账！
            </li>
            <li class="clearfix rel">
                <div class="fl myw">充值编号：</div>
                <p class="col67 fl"><?=$this->param['rechargeId']?></p>
            </li>
            <li class="clearfix rel f22" style="padding:.1rem 0 .2rem .2rem; color:#666; line-height: 1.4;height: auto;">
               *网银充值请务必将此编号填写到汇款“附言”里，每个充值编号仅用于一笔充值！
            </li>
            
        </ul>
        <img style="width:80%;display: block;margin:.1rem auto; padding-bottom: .3rem" src="<?=$memberBank['qrcode']?>">


<?php }?>