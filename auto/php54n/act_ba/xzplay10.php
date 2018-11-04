<?php
$id = ceil($data2['id']);
$msg = array();
$msg['id'] = 'selectBanker' . $data2['id'];
$msg['html'] = 'active';
act('active', $msg, $connection);
$play = $db->getOne("select * from jz_rule where id='" . $db->s($id) . "' and zt=1");
if (isset($connection->user['history_select'])) {
	$history_select = $db->getOne('SELECT `history_select` FROM `jz_user` WHERE `id` = ' . ceil($connection->user['id']));
	$history_select = !empty($history_select['history_select']) ? json_decode($history_select['history_select'], true) : [];
	if (empty($history_select[$play['type']])) {
		$history_select[$play['type']] = [];
	}
	$history_select[$play['type']]['id'] = $play['id'];
	$db->update('jz_user', ['history_select' => json_encode($history_select)], 'id=' . ceil($connection->user['id']));
}
$msg = array();
//$msg['id'] = 'setting';
$msg['id'] = 'open-wrap';
$msg['html'] = '';
if ($play['mode']) {
	$msg['html'] .= '<div class="selectPart">
                            <div class="selectTitle">模式：</div>
                            <div class="selectList">';
	$list = explode(',', $play['mode']);
	foreach ($list as $key => $value) {
		$msg['html'] .= '<div class="selectItem" id="mode' . $key . '" onclick="send(\'rule\',{id:\'mode\',key:' . $key . '})">
                                    <div class="selectBox"></div>
                                    <img src="/app/files/d_19/images/common/gou.png">
                                    <div class="selectText">' . $value . '</div>
                                </div> ';
	}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                        </div>';
}
if ($play['welfare']) {
	$msg['html'] .= '<div class="selectPart" id="welfare">
                            <div class="selectTitle">福利：</div>
                            <div class="selectList">';
	$list = explode(',', $play['welfare']);
	foreach ($list as $key => $value) {
		$msg['html'] .= '<div class="selectItem" id="welfare' . $key . '" onclick="send(\'rule\',{id:\'welfare\',key:' . $key . '})">
                                    <div class="selectBox"></div>
                                    <img src="/app/files/d_19/images/common/gou.png">
                                    <div class="selectText">' . $value . '</div>
                                </div> ';
	}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                        </div>';
}
if ($play['target']) {
	$msg['html'] .= '<div class="selectPart" id="target">
                            <div class="selectTitle">对象：</div>
                            <div class="selectList">';
	$list = explode(',', $play['target']);
	foreach ($list as $key => $value) {
		$msg['html'] .= '<div class="selectItem" id="target' . $key . '" onclick="send(\'rule\',{id:\'target\',key:' . $key . '})">
                                    <div class="selectBox"></div>
                                    <img src="/app/files/d_19/images/common/gou.png">
                                    <div class="selectText">' . $value . '</div>
                                </div> ';
	}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                        </div>';
}
if ($play['admittance']) {
	$msg['html'] .= '<div class="selectPart" id="admittance">
                            <div class="selectTitle">准入：</div>
                            <div class="selectList">';
	$list = explode(',', $play['admittance']);
	foreach ($list as $key => $value) {
		$msg['html'] .= '<div class="selectItem" id="admittance' . $key . '" onclick="send(\'rule\',{id:\'admittance\',key:' . $key . '})">
                                    <div class="selectBox"></div>
                                    <img src="/app/files/d_19/images/common/gou.png">
                                    <div class="selectText">' . $value . '</div>
                                </div> ';
	}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                        </div>';
}
if ($play['type'] == 32  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">模式：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" >自由抢庄（3局后可下庄）</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 40  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">模式：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" >射门上庄，无射门轮庄</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 48 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4分</div>
							</div>
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
                              <div  class="selectItem"   id ="shabi" onclick="send(\'rulel\',{id:\'shabi\',key:value,value:this.value})">
                             <div class="selectBox" ></div>
                             <img src="/app/files/d_19/images/common/gou.png">
                               <select  style="margin-top: 0.5vh;" onchange="send(\'rulel\',{id:\'df\',key:value,value:this.value})">
                              <option value="0">1分</option><option value="1">2分</option><option value="2">3分</option><option value="3">4分</option><option value="4">5分</option>
                              <option value="5">6分</option>
                              <option value="6">7分</option><option value="7">8分</option><option value="8">9分</option><option value="9"selected>10分</option><option value="10">11分</option><option value="11">12分</option><option value="12">13分</option><option value="13">14分</option><option value="14">15分</option><option value="15">16分</option><option value="16">17分</option><option value="17">18分</option><option value="18">19分</option><option value="19">20分</option><option value="20">21分</option><option value="21">22分</option><option value="22">23分</option><option value="23">24分</option><option value="24">25分</option><option value="25">26分</option><option value="26">27分</option><option value="27">28分</option><option value="28">29分</option><option value="29">30分</option><option value="30">31分</option><option value="31">32分</option><option value="32">33分</option><option value="33">34分</option><option value="34">35分</option><option value="35">36分</option><option value="36">37分</option><option value="37">38分</option><option value="38">39分</option><option value="39">40分</option><option value="40">41分</option><option value="41">42分</option><option value="42">43分</option><option value="43">44分</option><option value="44">45分</option><option value="45">46分</option><option value="46">47分</option><option value="47">48分</option><option value="48">49分</option><option value="49">50分</option><option value="50">51分</option><option value="51">52分</option><option value="52">53分</option><option value="53">54分</option><option value="54">55分</option><option value="55">56分</option><option value="56">57分</option><option value="57">58分</option><option value="58">59分</option><option value="59">60分</option><option value="60">61分</option><option value="61">62分</option><option value="62">63分</option><option value="63">64分</option><option value="64">65分</option><option value="65">66分</option><option value="66">67分</option><option value="67">68分</option><option value="68">69分</option><option value="69">70分</option><option value="70">71分</option><option value="71">72分</option><option value="72">73分</option><option value="73">74分</option><option value="74">75分</option><option value="75">76分</option><option value="76">77分</option><option value="77">78分</option><option value="78">79分</option><option value="79">80分</option><option value="80">81分</option><option value="81">82分</option><option value="82">83分</option><option value="83">84分</option><option value="84">85分</option><option value="85">86分</option><option value="86">87分</option><option value="87">88分</option><option value="88">89分</option><option value="89">90分</option><option value="90">91分</option><option value="91">92分</option><option value="92">93分</option><option value="93">94分</option><option value="94">95分</option><option value="95">96分</option><option value="96">97分</option><option value="97">98分</option><option value="98">99分</option><option value="99">100分</option></select>
                              </div>								
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 33 || $play['type'] == 37 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4分</div>
							</div>
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
                              <div  class="selectItem"   id ="shabi" onclick="send(\'rulel\',{id:\'shabi\',key:value,value:this.value})">
                             <div class="selectBox" ></div>
                             <img src="/app/files/d_19/images/common/gou.png">
                               <select  style="margin-top: 0.5vh;" onchange="send(\'rulel\',{id:\'df\',key:value,value:this.value})">
                              <option value="0">1分</option><option value="1">2分</option><option value="2">3分</option><option value="3">4分</option><option value="4">5分</option>
                              <option value="5">6分</option>
                              <option value="6">7分</option><option value="7">8分</option><option value="8">9分</option><option value="9">10分</option><option value="10">11分</option><option value="11">12分</option><option value="12">13分</option><option value="13">14分</option><option value="14"selected>15分</option><option value="15">16分</option><option value="16">17分</option><option value="17">18分</option><option value="18">19分</option><option value="19">20分</option><option value="20">21分</option><option value="21">22分</option><option value="22">23分</option><option value="23">24分</option><option value="24">25分</option><option value="25">26分</option><option value="26">27分</option><option value="27">28分</option><option value="28">29分</option><option value="29">30分</option><option value="30">31分</option><option value="31">32分</option><option value="32">33分</option><option value="33">34分</option><option value="34">35分</option><option value="35">36分</option><option value="36">37分</option><option value="37">38分</option><option value="38">39分</option><option value="39">40分</option><option value="40">41分</option><option value="41">42分</option><option value="42">43分</option><option value="43">44分</option><option value="44">45分</option><option value="45">46分</option><option value="46">47分</option><option value="47">48分</option><option value="48">49分</option><option value="49">50分</option><option value="50">51分</option><option value="51">52分</option><option value="52">53分</option><option value="53">54分</option><option value="54">55分</option><option value="55">56分</option><option value="56">57分</option><option value="57">58分</option><option value="58">59分</option><option value="59">60分</option><option value="60">61分</option><option value="61">62分</option><option value="62">63分</option><option value="63">64分</option><option value="64">65分</option><option value="65">66分</option><option value="66">67分</option><option value="67">68分</option><option value="68">69分</option><option value="69">70分</option><option value="70">71分</option><option value="71">72分</option><option value="72">73分</option><option value="73">74分</option><option value="74">75分</option><option value="75">76分</option><option value="76">77分</option><option value="77">78分</option><option value="78">79分</option><option value="79">80分</option><option value="80">81分</option><option value="81">82分</option><option value="82">83分</option><option value="83">84分</option><option value="84">85分</option><option value="85">86分</option><option value="86">87分</option><option value="87">88分</option><option value="88">89分</option><option value="89">90分</option><option value="90">91分</option><option value="91">92分</option><option value="92">93分</option><option value="93">94分</option><option value="94">95分</option><option value="95">96分</option><option value="96">97分</option><option value="97">98分</option><option value="98">99分</option><option value="99">100分</option></select>
                              </div>								
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 44 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>				
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 47 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>	
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
                            <div class="selectItem" id ="df5" onclick="send(\'rule\',{id:\'df\',key:\'5\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >50分</div>
							</div>				
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 36 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4分</div>
							</div>
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>					
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 45|| $play['type'] == 46 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4分</div>
							</div>	
                           	<div class="selectItem"  id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
							<div class="selectItem" id ="df5" onclick="send(\'rule\',{id:\'df\',key:\'5\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>
                            <div class="selectItem" id ="df6" onclick="send(\'rule\',{id:\'df\',key:\'6\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20分</div>
							</div>	
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 40 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >50分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >100分</div>
							</div>					
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 43 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>				
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 39 || $play['type'] == 41){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20分</div>
							</div>					
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 43  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >轮流问地主</div>
							</div>							
							<div class="selectItem"  id ="gz1" onclick="send(\'rule\',{id:\'gz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >随机问地主</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 44  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >加倍</div>
							</div>							
							<div class="selectItem"  id ="gz1" onclick="send(\'rule\',{id:\'gz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >明牌</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 32|| $play['type'] == 33  ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >牛牛X3牛九X2牛八X2</div>
							</div>							
							<div class="selectItem"  id ="gz1" onclick="send(\'rule\',{id:\'gz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >牛牛X4牛九X3牛八X2牛七X2</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 45 ){
$msg['html'] .= '
<div class="selectPart" style="height:13vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >牛牛X3牛九X2牛八X2</div>
							</div>							
							<div class="selectItem"  id ="gz1" onclick="send(\'rule\',{id:\'gz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >牛牛X4牛九X3牛八X2牛七X2</div>
							</div> 
                            <div class="selectItem"  id ="gz2"  onclick="send(\'rule\',{id:\'gz\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1点最大</div>
							</div>							
							<div class="selectItem"  id ="gz3" onclick="send(\'rule\',{id:\'gz\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >6点最大</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 41){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">炸弹：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5张</div>
							</div>							
							<div class="selectItem"  id ="gz1" onclick="send(\'rule\',{id:\'gz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10张</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}

if ($play['type'] == 40  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz0"  onclick="send(\'rule\',{id:\'gz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >AK撞门框赔2倍</div>
							</div>	   
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 44){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">封顶：</div>
						<div class="selectList">
							<div class="selectItem"  id ="ss0"  onclick="send(\'rule\',{id:\'ss\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >无</div>
							</div>							
							<div class="selectItem"  id ="ss1" onclick="send(\'rule\',{id:\'ss\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >250</div>
							</div>  
                            				<div class="selectItem"  id ="ss2"  onclick="send(\'rule\',{id:\'ss\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >500</div>
							</div>							
							<div class="selectItem"  id ="ss3" onclick="send(\'rule\',{id:\'ss\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1000</div>
							</div> 
                              </div>
					           </div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 35) {
$msg['html'] .= '
<div class="selectPart" style="height: 9vh;" >
						<div class="selectTitle">筹码：</div>
						<div class="selectList">
							<div class="selectItem"  id ="cm0"  onclick="send(\'rule\',{id:\'cm\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2/4-4/8-8/16-10/20</div>
							</div>							
							<div class="selectItem"  id ="cm1" onclick="send(\'rule\',{id:\'cm\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2/4-5/10-10/20-20/40</div>
							</div>                           
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 42) {
$msg['html'] .= '
<div class="selectPart" style="height: 4vh;" >
						<div class="selectTitle">筹码：</div>
						<div class="selectList">
							<div class="selectItem"  id ="cm0"  onclick="send(\'rule\',{id:\'cm\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10,20,50,100</div>
							</div>							
							<div class="selectItem"  id ="cm1" onclick="send(\'rule\',{id:\'cm\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20,50,100,200</div>
							</div>                           
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 34|| $play['type'] == 38){
$msg['html'] .= '
<div class="selectPart" style="height: 4vh;" >
						<div class="selectTitle">筹码：</div>
						<div class="selectList">
							<div class="selectItem"  id ="cm0"  onclick="send(\'rule\',{id:\'cm\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >300</div>
							</div>							
							<div class="selectItem"  id ="cm1" onclick="send(\'rule\',{id:\'cm\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >500</div>
							</div>
							<div class="selectItem" id ="cm2" onclick="send(\'rule\',{id:\'cm\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1000</div>
							</div>	                                 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 35){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz20"  onclick="send(\'rule\',{id:\'gz2\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >100分以下不能比牌</div>
							</div>							
							<div class="selectItem"  id ="gz21" onclick="send(\'rule\',{id:\'gz2\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >闷牌，全场禁止比牌</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 38){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz20"  onclick="send(\'rule\',{id:\'gz2\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >天公，雷公，地公</div>
							</div>		
                      
							<div class="selectItem" id ="gz21" onclick="send(\'rule\',{id:\'gz2\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >暴玖</div>
							</div>       
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 36 || $play['type'] == 37 ){
$msg['html'] .= '
<div class="selectPart" style="height:18vh;" >
						<div class="selectTitle">规则：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;max-width:190px;">
                       <div class="selectText" >暴玖x9大三公x9小三公x7三公x5九点x4八点x3七点x2散牌x1豹子x6同花顺x5金花x4顺子x3对子x2散牌x1</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 39  ){
$msg['html'] .= '
<div class="selectPart" style="height:14vh;" >
						<div class="selectTitle">规则：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;max-width:190px;">
                       <div class="selectText" >每人分四张牌，分大小组，分别与庄家对牌，全胜全败为胜负，一胜一负为和局</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 39  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">牌型：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;max-width:190px;">
                       <div class="selectText" >丁三牌及二四牌可以互换使用</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 34|| $play['type'] == 35) {
$msg['html'] .= '
<div class="selectPart" style="height: 4vh;" >
						<div class="selectTitle">牌型：</div>
						<div class="selectList">
							<div class="selectItem"  id ="px0"  onclick="send(\'rule\',{id:\'px\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五花牛</div>
							</div>							
							<div class="selectItem"  id ="px1" onclick="send(\'rule\',{id:\'px\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >炸弹牛</div>
							</div>
							<div class="selectItem" id ="px2" onclick="send(\'rule\',{id:\'px\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五小牛</div>
							</div>
                      	                                 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 35  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">上限：</div>
						<div class="selectList">
							<div class="selectItem"  id ="ss0"  onclick="send(\'rule\',{id:\'ss\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >无</div>
							</div>							
							<div class="selectItem"  id ="ss1" onclick="send(\'rule\',{id:\'ss\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >500</div>
							</div>   
                            <div class="selectItem"  id ="ss2" onclick="send(\'rule\',{id:\'ss\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1000</div>
							</div> 
                            <div class="selectItem"  id ="ss3" onclick="send(\'rule\',{id:\'ss\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2000</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 47 || $play['type'] == 48 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">鬼牌：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gp0"  onclick="send(\'rule\',{id:\'gp\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >无</div>
							</div>							
							<div class="selectItem"  id ="gp1" onclick="send(\'rule\',{id:\'gp\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2张</div>
							</div>   
                            <div class="selectItem"  id ="gp2" onclick="send(\'rule\',{id:\'gp\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3张</div>
							</div> 
                            <div class="selectItem"  id ="gp3" onclick="send(\'rule\',{id:\'gp\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4张</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 48 ){
$msg['html'] .= '
<div class="selectPart" style="height:8vh;" >
						<div class="selectTitle">看牌：</div>
						<div class="selectList">
							<div class="selectItem"  id ="kp0"  onclick="send(\'rule\',{id:\'kp\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >8张</div>
							</div>							
							<div class="selectItem"  id ="kp1" onclick="send(\'rule\',{id:\'kp\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >9张</div>
							</div>   
                            <div class="selectItem"  id ="kp2" onclick="send(\'rule\',{id:\'kp\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10张</div>
							</div> 
                            <div class="selectItem"  id ="kp3" onclick="send(\'rule\',{id:\'kp\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >11张</div>
							</div>      
                            <div class="selectItem"  id ="kp4" onclick="send(\'rule\',{id:\'kp\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >12张</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 40  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">上限：</div>
						<div class="selectList">
							<div class="selectItem"  id ="ss0"  onclick="send(\'rule\',{id:\'ss\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >无</div>
							</div>							
							<div class="selectItem"  id ="ss1" onclick="send(\'rule\',{id:\'ss\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1000</div>
							</div>   
                            <div class="selectItem"  id ="ss2" onclick="send(\'rule\',{id:\'ss\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1500</div>
							</div> 
                            <div class="selectItem"  id ="ss3" onclick="send(\'rule\',{id:\'ss\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2000</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 45  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">喜分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="ss0"  onclick="send(\'rule\',{id:\'ss\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >无</div>
							</div>							
							<div class="selectItem"  id ="ss1" onclick="send(\'rule\',{id:\'ss\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >100</div>
							</div>   
                            <div class="selectItem"  id ="ss2" onclick="send(\'rule\',{id:\'ss\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >300</div>
							</div> 
                            <div class="selectItem"  id ="ss3" onclick="send(\'rule\',{id:\'ss\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >500</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 33 || $play['type'] == 37 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">癞子：</div>
						<div class="selectList">
							<div class="selectItem"  id ="lz0"  onclick="send(\'rule\',{id:\'lz\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2个</div>
							</div>							
							<div class="selectItem"  id ="lz1" onclick="send(\'rule\',{id:\'lz\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4个</div>
							</div>   
                            <div class="selectItem"  id ="lz2" onclick="send(\'rule\',{id:\'lz\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >6个</div>
							</div>      
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 32) {
$msg['html'] .= '
<div class="selectPart" style="height: 9vh;" >
						<div class="selectTitle">牌型：</div>
						<div class="selectList">
							<div class="selectItem"  id ="px0"  onclick="send(\'rule\',{id:\'px\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >四花牛(5倍)</div>
							</div>							
							<div class="selectItem"  id ="px1" onclick="send(\'rule\',{id:\'px\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五花牛(6倍)</div>
							</div>
							<div class="selectItem" id ="px2" onclick="send(\'rule\',{id:\'px\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >炸弹牛(7倍)</div>
							</div>
                            <div class="selectItem" id ="px3" onclick="send(\'rule\',{id:\'px\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五小牛(8倍)</div>
							</div>	                                 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 33) {
$msg['html'] .= '
<div class="selectPart" style="height: 18vh;" >
						<div class="selectTitle">牌型：</div>
						<div class="selectList">
							<div class="selectItem"  id ="px0"  onclick="send(\'rule\',{id:\'px\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >四花牛(4倍)</div>
							</div>							
							<div class="selectItem"  id ="px1" onclick="send(\'rule\',{id:\'px\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五花牛(5倍)</div>
							</div>
							<div class="selectItem" id ="px2" onclick="send(\'rule\',{id:\'px\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >顺子牛(6倍)</div>
							</div>
                            <div class="selectItem" id ="px3" onclick="send(\'rule\',{id:\'px\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >同花牛(6倍)</div>
							</div>	
                            	<div class="selectItem"  id ="px4"  onclick="send(\'rule\',{id:\'px\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >葫芦牛(6倍)</div>
							</div>							
							<div class="selectItem"  id ="px5" onclick="send(\'rule\',{id:\'px\',key:\'5\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >炸弹牛(8倍)</div>
							</div>
							<div class="selectItem" id ="px6" onclick="send(\'rule\',{id:\'px\',key:\'6\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >同花顺牛(9倍)</div>
							</div>
                            <div class="selectItem" id ="px7" onclick="send(\'rule\',{id:\'px\',key:\'7\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五小牛(10倍)</div>
							</div>	 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 45) {
$msg['html'] .= '
<div class="selectPart" style="height: 9vh;" >
						<div class="selectTitle">牌型：</div>
						<div class="selectList">
							<div class="selectItem"  id ="px0"  onclick="send(\'rule\',{id:\'px\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >葫芦(5倍)</div>
							</div>							
							<div class="selectItem"  id ="px1" onclick="send(\'rule\',{id:\'px\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >四条(6倍)</div>
							</div>
							<div class="selectItem" id ="px2" onclick="send(\'rule\',{id:\'px\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >顺子(8倍)</div>
							</div>
                            <div class="selectItem" id ="px3" onclick="send(\'rule\',{id:\'px\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >五条(10倍)</div>
							</div>	                                 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 46  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">牌型：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" >对子(2倍)顺子(4倍)豹子(6倍)</div> 
                        </div> 
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 33|| $play['type'] == 36  || $play['type'] == 37 || $play['type'] == 45|| $play['type'] == 46|| $play['type'] == 48){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">倍数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="bs1"  onclick="send(\'rulel\',{id:\'bs\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1，2，4，5</div>
							</div>							
							<div class="selectItem"  id ="bs2" onclick="send(\'rulel\',{id:\'bs\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1，3，5，8</div>
							</div>
							<div class="selectItem" id ="bs3" onclick="send(\'rulel\',{id:\'bs\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2，4，6，10</div>
							</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 37|| $play['type'] == 33 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">抢庄</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>	
						<div class="selectList" style="margin-left: 8vh;margin-top: .4vh">
							<div class="selectItem"  >
								<div class="text" style="float: left;">下注</div>
								<select id = "timexz" onchange="send(\'rulel\',{id:\'time\',key:\'xz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem" style="margin-left: 1vh;">
								<div class="text" style="float: left;">摊牌</div>
								<select id = "timetp" onchange="send(\'rulel\',{id:\'time\',key:\'tp\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 48 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">抢庄</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>	
						<div class="selectList" style="margin-left: 8vh;margin-top: .4vh">
							<div class="selectItem"  >
								<div class="text" style="float: left;">下注</div>
								<select id = "timexz" onchange="send(\'rulel\',{id:\'time\',key:\'xz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem" style="margin-left: 1vh;">
								<div class="text" style="float: left;">理牌</div>
								<select id = "timetp" onchange="send(\'rulel\',{id:\'time\',key:\'tp\',value:this.value})">
									<option value="10">10秒</option>
									<option value="15">15秒</option>
									<option value="20">20秒</option>
                                	<option value="30"selected>30秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 45 || $play['type'] == 46 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">抢庄</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>	
						<div class="selectList" style="margin-left: 8vh;margin-top: .4vh">
							<div class="selectItem"  >
								<div class="text" style="float: left;">下注</div>
								<select id = "timexz" onchange="send(\'rulel\',{id:\'time\',key:\'xz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem" style="margin-left: 1vh;">
								<div class="text" style="float: left;">开盅</div>
								<select id = "timetp" onchange="send(\'rulel\',{id:\'time\',key:\'tp\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 47  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">理牌</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="10">10秒</option>
									<option value="15">15秒</option>
									<option value="20">20秒</option>
                                	<option value="30"selected>30秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 41  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
                                    <option value="10"selected>10秒</option>
									<option value="11">11秒</option>
									<option value="12">12秒</option>
									<option value="13">13秒</option>
									<option value="14">14秒</option>
									<option value="15">15秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 44  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="30">30秒</option>
									<option value="25">25秒</option>
									<option value="20">20秒</option>
									<option value="15"selected>15秒</option>
									<option value="10">10秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';

if ($play['type'] == 38 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">下注</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>	
						<div class="selectList" style="margin-left: 8vh;margin-top: .4vh">
							<div class="selectItem"  >
								<div class="text" style="float: left;">摊牌</div>
								<select id = "timexz" onchange="send(\'rulel\',{id:\'time\',key:\'xz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 40 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">下注</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
							</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 32 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">锅底：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gd0"  onclick="send(\'rule\',{id:\'gd\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >500</div>
							</div>							
							<div class="selectItem"  id ="gd1" onclick="send(\'rule\',{id:\'gd\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1000</div>
							</div>
							<div class="selectItem" id ="gd2" onclick="send(\'rule\',{id:\'gd\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2000</div>
							</div>
                            <div class="selectItem" id ="gd3" onclick="send(\'rule\',{id:\'gd\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >5000</div>
							</div>
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 32  ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;line-height:4.5vh ">
						<div class="selectTitle">时间：</div>
						<div class="selectList">						
							<div class="selectItem"  >
								<div class="text" style="float: left;">准备</div>
								<select  onchange="send(\'rulel\',{id:\'time\',key:\'zb\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
							<div class="selectItem"  style="margin-left: 1vh;">
								<div class="text" style="float: left;">抢庄</div>
								<select id = "timeqz" onchange="send(\'rulel\',{id:\'time\',key:\'qz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>	
						<div class="selectList" style="margin-left: 8vh;margin-top: .4vh">
							<div class="selectItem"  >
								<div class="text" style="float: left;">下注</div>
								<select id = "timexz" onchange="send(\'rulel\',{id:\'time\',key:\'xz\',value:this.value})">
									<option value="5">5秒</option>
									<option value="6">6秒</option>
									<option value="7">7秒</option>
									<option value="8">8秒</option>
									<option value="9">9秒</option>
                                	<option value="10"selected>10秒</option>
								</select>
							</div>
						</div>
					</div>';

					
}
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
if ($play['type'] == 32 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">结算：</div>
						<div class="selectList">
							<div class="selectItem"  id ="jss0"  onclick="send(\'rule\',{id:\'lss\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >负锅底包赔</div>
							</div>							
							<div class="selectItem"  id ="jss1" onclick="send(\'rule\',{id:\'jss\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >负锅底包赔</div>
</div>
<div class="selectItem" style="width: 50vw; margin-left: 1.2vh; line-height: 3.5vh; ;">
<div class="selectText">锅底低于0分，自动下庄：</div>
                                </div> 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31 ){
$msg['html'] .= '
<div class="selectPart" style="height:9vh;" >
						<div class="selectTitle">底分：</div>
						<div class="selectList">
							<div class="selectItem"  id ="df0"  onclick="send(\'rule\',{id:\'df\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4分</div>
							</div>							
							<div class="selectItem"  id ="df1" onclick="send(\'rule\',{id:\'df\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10分</div>
							</div>
							<div class="selectItem" id ="df2" onclick="send(\'rule\',{id:\'df\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20分</div>
							</div>
                            <div class="selectItem" id ="df3" onclick="send(\'rule\',{id:\'df\',key:\'3\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >40分</div>
							</div>
                            <div class="selectItem" id ="df4" onclick="send(\'rule\',{id:\'df\',key:\'4\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >100分</div>
							</div>
                              <div class="selectItem" id ="df5" onclick="send(\'rule\',{id:\'df\',key:\'5\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >200分</div>
							</div>	                                 
                              </div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29   ){
$msg['html'] .= '
<div class="selectPart" style="height:25vh;" >
						<div class="selectTitle">筹码：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" style="color: rgb(0, 130, 89);">选择四组游戏筹码(已选4组) </div> 
                        </div> 
<div class="selectItem" id ="gz210" onclick="send(\'rule\',{id:\'gz2\',key:\'10\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">2/4</div>
</div>
<div class="selectItem" id ="gz211" onclick="send(\'rule\',{id:\'gz2\',key:\'11\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">4/8</div>
</div>
<div class="selectItem"id ="gz212" onclick="send(\'rule\',{id:\'gz2\',key:\'12\'})" style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">5/10</div>
</div> 
<div class="selectItem" id ="gz213" onclick="send(\'rule\',{id:\'gz2\',key:\'13\'})"style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">8/16</div>
</div> <div class="selectItem"id ="gz214" onclick="send(\'rule\',{id:\'gz2\',key:\'14\'})" style="width: 15vw;">
<div class="selectBox"></div> 								
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">10/20</div>
</div> 
<div class="selectItem"id ="gz215" onclick="send(\'rule\',{id:\'gz2\',key:\'15\'})" style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">20/40</div>
</div> <div class="selectItem"id ="gz216" onclick="send(\'rule\',{id:\'gz2\',key:\'16\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">50/100</div>
</div> <div class="selectItem"id ="gz217" onclick="send(\'rule\',{id:\'gz2\',key:\'17\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">100/200</div>
</div>
<div class="selectItem" style="width: 50vw; margin-left: 1.2vh; line-height: 3.5vh; color: rgb(0, 130, 89);">
<div class="selectText">血战筹码：</div>
                                </div> 
                                <div class="selectItem"id ="gz218" onclick="send(\'rule\',{id:\'gz2\',key:\'18\'})">
                                <div class="selectBox"></div> 
                            	<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">120</div>
                                </div> <div class="selectItem"id ="gz219" onclick="send(\'rule\',{id:\'gz2\',key:\'19\'})">
                                <div class="selectBox"></div> 
								<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">160</div>
                                </div> 
                                <div class="selectItem"id ="gz220" onclick="send(\'rule\',{id:\'gz2\',key:\'20\'})">
                                <div class="selectBox"></div> 
                           		<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">200</div>

                                </div>
                                </div>	
                                </div>';                        

	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 30   ){
$msg['html'] .= '
<div class="selectPart" style="height:25vh;" >
						<div class="selectTitle">筹码：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" style="color: rgb(0, 130, 89);">选择四组游戏筹码(已选4组) </div> 
                        </div> 
<div class="selectItem" id ="gz210" onclick="send(\'rule\',{id:\'gz2\',key:\'10\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">2/4</div>
</div>
<div class="selectItem" id ="gz211" onclick="send(\'rule\',{id:\'gz2\',key:\'11\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">4/8</div>
</div>
<div class="selectItem"id ="gz212" onclick="send(\'rule\',{id:\'gz2\',key:\'12\'})" style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">5/10</div>
</div> 
<div class="selectItem" id ="gz213" onclick="send(\'rule\',{id:\'gz2\',key:\'13\'})"style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">8/16</div>
</div> <div class="selectItem"id ="gz214" onclick="send(\'rule\',{id:\'gz2\',key:\'14\'})" style="width: 15vw;">
<div class="selectBox"></div> 								
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">10/20</div>
</div> 
<div class="selectItem"id ="gz215" onclick="send(\'rule\',{id:\'gz2\',key:\'15\'})" style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">20/40</div>
</div> <div class="selectItem"id ="gz216" onclick="send(\'rule\',{id:\'gz2\',key:\'16\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">50/100</div>
</div> <div class="selectItem"id ="gz217" onclick="send(\'rule\',{id:\'gz2\',key:\'17\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">100/200</div>
</div>
<div class="selectItem" style="width: 50vw; margin-left: 1.2vh; line-height: 3.5vh; color: rgb(0, 130, 89);">
<div class="selectText">换牌筹码：</div>
                                </div> 
                                <div class="selectItem"id ="gz218" onclick="send(\'rule\',{id:\'gz2\',key:\'18\'})">
                                <div class="selectBox"></div> 
                            	<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">40</div>
                                </div> <div class="selectItem"id ="gz219" onclick="send(\'rule\',{id:\'gz2\',key:\'19\'})">
                                <div class="selectBox"></div> 
								<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">60</div>
                                </div> 
                                <div class="selectItem"id ="gz220" onclick="send(\'rule\',{id:\'gz2\',key:\'20\'})">
                                <div class="selectBox"></div> 
                           		<img src="/app/files/d_19/images/common/gou.png">
                                <div class="selectText">80</div>

                                </div>
                                </div>	
                                </div>';                        

	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 31   ){
$msg['html'] .= '
<div class="selectPart" style="height:18vh;" >
						<div class="selectTitle">筹码：</div>
                        <div class="selectList"><div class="selectItem" style="margin-left: 1.2vh;">
                       <div class="selectText" style="color: rgb(0, 130, 89);">选择四组游戏筹码(已选4组) </div> 
                        </div> 
<div class="selectItem" id ="gz210" onclick="send(\'rule\',{id:\'gz2\',key:\'10\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">2/4</div>
</div>
<div class="selectItem" id ="gz211" onclick="send(\'rule\',{id:\'gz2\',key:\'11\'})"style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">4/8</div>
</div>
<div class="selectItem"id ="gz212" onclick="send(\'rule\',{id:\'gz2\',key:\'12\'})" style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">5/10</div>
</div> 
<div class="selectItem" id ="gz213" onclick="send(\'rule\',{id:\'gz2\',key:\'13\'})"style="width: 15vw;">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">8/16</div>
</div> <div class="selectItem"id ="gz214" onclick="send(\'rule\',{id:\'gz2\',key:\'14\'})" style="width: 15vw;">
<div class="selectBox"></div> 								
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">10/20</div>
</div> 
<div class="selectItem"id ="gz215" onclick="send(\'rule\',{id:\'gz2\',key:\'15\'})" style="width: 15vw;">
<div class="selectBox"></div>
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">20/40</div>
</div> <div class="selectItem"id ="gz216" onclick="send(\'rule\',{id:\'gz2\',key:\'16\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">50/100</div>
</div> <div class="selectItem"id ="gz217" onclick="send(\'rule\',{id:\'gz2\',key:\'17\'})">
<div class="selectBox"></div> 
<img src="/app/files/d_19/images/common/gou.png">
<div class="selectText">100/200</div>
</div>

                                </div>	
                                </div>';                        

	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">规则：</div>
						<div class="selectList">
							<div class="selectItem"  id ="gz20"  onclick="send(\'rule\',{id:\'gz2\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >闷牌-全场禁止比牌</div>
							</div>						
							
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">下注：</div>
						<div class="selectList">
							<div class="selectItem"  id ="dff0"  onclick="send(\'rule\',{id:\'dff\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >8轮</div>
							</div>							
							<div class="selectItem"  id ="dff1" onclick="send(\'rule\',{id:\'dff\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10轮</div>
							</div>
							<div class="selectItem" id ="dff2" onclick="send(\'rule\',{id:\'dff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >12轮</div>
							</div>		
                            	<div class="selectItem" id ="dff2" onclick="send(\'rule\',{id:\'dff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >15轮</div>
							</div>	
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">必闷：</div>
						<div class="selectList">
							<div class="selectItem"  id ="dfff0"  onclick="send(\'rule\',{id:\'dfff\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >0轮</div>
							</div>							
							<div class="selectItem"  id ="dfff1" onclick="send(\'rule\',{id:\'dfff\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1轮</div>
							</div>
							<div class="selectItem" id ="dfff2" onclick="send(\'rule\',{id:\'dfff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2轮</div>
							</div>		
                            	<div class="selectItem" id ="dfff2" onclick="send(\'rule\',{id:\'dfff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >3轮</div>
							</div>	
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">比牌：</div>
						<div class="selectList">
							<div class="selectItem"  id ="ddff0"  onclick="send(\'rule\',{id:\'ddff\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >>1轮</div>
							</div>							
							<div class="selectItem"  id ="ddff1" onclick="send(\'rule\',{id:\'ddff\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >>2轮</div>
							</div>
							<div class="selectItem" id ="ddff2" onclick="send(\'rule\',{id:\'ddff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >>3轮</div>
							</div>		
                            	<div class="selectItem" id ="ddff2" onclick="send(\'rule\',{id:\'ddff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >>4轮</div>
							</div>	
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">血战：</div>
						<div class="selectList">
							<div class="selectItem"  id ="dzff0"  onclick="send(\'rule\',{id:\'dzff\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >1轮</div>
							</div>							
							<div class="selectItem"  id ="dzff1" onclick="send(\'rule\',{id:\'dzff\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2轮</div>
							</div>
							<div class="selectItem" id ="dzff2" onclick="send(\'rule\',{id:\'dzff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >2轮</div>
							</div>		
                            	<div class="selectItem" id ="dzff2" onclick="send(\'rule\',{id:\'dzff\',key:\'2\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >4轮</div>
							</div>	
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 29 || $play['type'] == 30|| $play['type'] == 31|| $play['type'] == 33|| $play['type'] == 45|| $play['type'] == 46 || $play['type'] == 34|| $play['type'] == 35 || $play['type'] == 36|| $play['type'] == 37|| $play['type'] == 38|| $play['type'] == 39|| $play['type'] == 40 || $play['type'] == 42 ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">局数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="js0"  onclick="send(\'rule\',{id:\'js\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >12局X2房卡</div>
							</div>						
							<div class="selectItem"  id ="js1" onclick="send(\'rule\',{id:\'js\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >24局X4房卡</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 41|| $play['type'] == 43 || $play['type'] == 44  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">局数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="js0"  onclick="send(\'rule\',{id:\'js\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >6局X1房卡</div>
							</div>							
							<div class="selectItem"  id ="js1" onclick="send(\'rule\',{id:\'js\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >12局X2房卡</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 32  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">局数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="js0"  onclick="send(\'rule\',{id:\'js\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >12局X3房卡</div>
							</div>							
							<div class="selectItem"  id ="js1" onclick="send(\'rule\',{id:\'js\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >24局X6房卡</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 47  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">局数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="js0"  onclick="send(\'rule\',{id:\'js\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10局</div>
							</div>							
							<div class="selectItem"  id ="js1" onclick="send(\'rule\',{id:\'js\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20局</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 48  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
						<div class="selectTitle">局数：</div>
						<div class="selectList">
							<div class="selectItem"  id ="js0"  onclick="send(\'rule\',{id:\'js\',key:\'0\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >10局X2张</div>
							</div>							
							<div class="selectItem"  id ="js1" onclick="send(\'rule\',{id:\'js\',key:\'1\'})">
								<div class="selectBox" ></div>
								<img src="/app/files/d_19/images/common/gou.png">
								<div class="selectText" >20局X4张</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
if ($play['type'] == 47  ){
$msg['html'] .= '
<div class="selectPart" style="height:4vh;" >
<div class="selectTitle" style="width: 100%; left: 0px; text-align: center; color: rgb(215, 41, 28);">限时免费</div>
						</div>
					</div>';
	$msg['html'] .= '</div><div style="clear: both;"></div>
                </div>';
}
act('html', $msg, $connection);
$data = array();
$data['act'] = 'rule';
$data['play'] = $play;
reqact($data, $connection);
if (!empty($history_select) && !empty($history_select[$play['type']]) && !empty($history_select[$play['type']]['rule'])) {
	foreach ($history_select[$play['type']]['rule'] as $id => $val) {
		if (($id == 'gz2') || ($id == 'px')) {
		} else {
			$data = array();
			$data['act'] = 'rule';
			$data['id'] = $id;
			$data['key'] = $val;
			reqact($data, $connection);
		}
	}
} 
            $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '10';
			reqact($data, $connection);

            $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '11';
			reqact($data, $connection);

 $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '12';
			reqact($data, $connection);

            $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '14';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '18';
			reqact($data, $connection);

            $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz2';
			$data['key'] = '0';
			reqact($data, $connection);

 $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'dzff';
			$data['key'] = '0';
			reqact($data, $connection);

            $data = array();
			$data['act'] = 'rule';
			$data['id'] = 'ddff';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'dfff';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'dff';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'df';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'js';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gz';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '1';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '2';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '3';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '4';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '5';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '6';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'px';
			$data['key'] = '7';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gd';
			$data['key'] = '1';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'jss';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'df';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'lz';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'bs';
			$data['key'] = '1';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'cm';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'ss';
			$data['key'] = '2';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'gp';
			$data['key'] = '0';
			reqact($data, $connection);
$data = array();
			$data['act'] = 'rule';
			$data['id'] = 'kp';
			$data['key'] = '0';
			reqact($data, $connection);




