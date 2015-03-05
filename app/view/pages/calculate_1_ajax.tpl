<style type="text/css">
{literal}
.x{
	background:#dee9f3
}
.y{
	background:#dceed5
}
.z{
	background:#f9e1e1
}
.z1{
	background:#c5d8eb
}
.upper{
	text-transform: uppercase;
}
.offer{
	color:#000
}
.orange{
	background:#f60
}
.green{
	background:#359541
}
.red_back{
	background:#ED4941
}
.blue{
	background:#336699
}
{/literal}
</style>
<div class="main">
	<script type="text/javascript" language="javascript">
    	applicationContextPath = '/onlineInsurance';
	</script>
	<script src="{$base_url}js/soundmanager.js" type="text/javascript"/>
	<script type="text/javascript">
	{literal}
	<!--
	function showOffer(id, boolVar)
	{
		if (boolVar == true) {
        		document.location='/onlineInsurance/policyData.do?offerInd=' +
id;
    		}
  	}
	function popupNotes(id)
	{
		var url = "/onlineInsurance/showNotes.do?offerInd=" + id;
		openWin(url, "_blank", 450, 1050, "");
	}
	function sound(typeButton)
	{
		//soundManager.setVolume('radioButton', 40);
		//soundManager.play('radioButton');
		return true;
	}
	function gotoURL(url)
	{
		sound();
		if(url) {
			location = url;
		}
	}
	//-->
	{/literal}
	</script>
	<h1><center>Изберете най-доброто предложение за Вас!</center></h1>
	<p>В цените са включени задължителните 10 лева, които застрахователните
компании внасят в Гаранционния фонд и стойността на стикера за валидност, който
се лепи върху МПС.</p>
	<div class="tarifs">
    	<p class="tarifa">В черен цвят са цените на застрахователните
компании.</p>
    	<p class="tarifa_style1"><img border="0" src="images/sdiTriangle.gif"/>
В оранжев цвят са Вашите цени с отстъпка при застраховка онлайн.</p>
    	<p class="tarifa">При сключване на застраховка, полицата ще Ви бъде
доставена по куриер <span class="deliveryTime">в срок от 1 до 3 работни
дни</span> само за 1.50 лв.</p>
    	<p class="tarifa">Плащането се извършва в брой на куриера.</p>
    </div>
    <table width="100%" cellspacing="1" cellpadding="0" border="0"
class="offer">
	<tr>
		<th class="blueText upToDateNotice" colspan="14">Актуални тарифи към
11.03.2009 г.</th>
	</tr>
	<tr>
		<th style="color:#fff" scope="col" class="orange upper"
rowspan="2">Застрахователна компания</th>
		<th style="color:#fff" scope="col" class="orange upper"
rowspan="2">Еднократно<br/>плащане</th>
		<th style="color:#fff" scope="col" class="green upper" colspan="3">2
вноски</th>
		<th style="color:#fff" scope="col" class="red_back upper" colspan="4">3
вноски</th>
		<th style="color:#fff" scope="col" class="blue upper" colspan="5">4
вноски</th>
	</tr>
	<tr>
        <th scope="row" class="green">Общо</th>
        <th scope="row" class="green">1вн.</th>
        <th scope="row" class="green">2вн.</th>
        <th scope="row" class="red_back">Общо</th>
        <th scope="row" class="red_back">1вн.</th>
        <th scope="row" class="red_back">2вн.</th>
        <th scope="row" class="red_back">3вн.</th>
        <th scope="row" class="blue">Общо</th>
        <th scope="row" class="blue">1вн.</th>
        <th scope="row" class="blue">2вн.</th>
        <th scope="row" class="blue">3вн.</th>
		<th scope="row" class="blue">4вн.</th>
	</tr>
	{foreach from=$offer_list item=item}
	<tr>
		<td class="x" onclick="showOffer({$item->id},true);" style="border-top:
0.01cm solid rgb(255, 102, 0); border-left: 0.01cm solid rgb(255, 102, 0);
cursor: pointer; vertical-align: middle;" rowspan="2">
			<table>
			<tr>
				<td><img border="0" alt="{$item->image_alt}"
style="vertical-align: middle;" src="{$base_url}images/{$item->image}" /></td>
			</tr>
			</table>
		</td>
		<td class="x">{$item->price->price}</td>
		<td class="y">{$item->price2->total}</td>
		<td class="y">{$item->price2->first}</td>
		<td class="y">{$item->price2->second}</td>
		<td class="z">{$item->price3->total}</td>
		<td class="z">{$item->price3->first}</td>
		<td class="z">{$item->price3->second}</td>
		<td class="z">{$item->price3->third}</td>
		<td class="z1">{$item->price4->total}</td>
		<td class="z1">{$item->price4->first}</td>
		<td class="z1">{$item->price4->second}</td>
		<td class="z1">{$item->price4->third}</td>
		<td class="z1">{$item->price4->forth}</td>
	</tr>
	<tr class="sdidiscount">
		<td class="x">{$item->price->discount}</td>
		<td class="y"></td>
		<td class="y"></td>
		<td class="y"></td>
		<td class="z"></td>
		<td class="z"></td>
		<td class="z"></td>
		<td class="z"></td>
		<td class="z1"></td>
		<td class="z1"></td>
		<td class="z1"></td>
		<td class="z1"></td>
		<td class="z1"></td>
	</tr>
	<tr onclick="popupNotes(0)" style="cursor: pointer; background-color:
rgb(247, 214, 197);">
		<td style="border-left: 0.01cm solid rgb(255, 102, 0); border-right:
0.01cm solid rgb(255, 102, 0); border-bottom: 0.01cm solid rgb(255, 102, 0);"
colspan="16">
			<table width="100%" cellspacing="0" cellpadding="0" border="0"
style="color:#000">
			<tr>
				<td style="width: 20%;">Забележки:</td>
				<td style="text-align: left;" class="textBold">
					<ol>
					{foreach from=$item->notes item=note}
						<li>{$note}</li>
					{/foreach}
					</ol>
				</td>
				<td class="textBold" style="width: 10%; font-size: 120%;"><a
href="javascript:showOffer(0,true);">още...</a></td>
			</tr>
			</table>
		</td>
	</tr>
	{/foreach}
	</table>
	<div>
	<p>Лимитите на отговорност при
застраховка Гражданска отговорност са еднакви за всички застрахователни
компании са както следва:<br/><br/><b>При събития настъпили на територията на
Р. България</b><br/>За всяко събитие при едно пострадало лице – 700 000
лева<br/>За всяко събитие при две или повече пострадали лица – 1 000 000
лева<br/>За вреди на имущество за всяко събитие – 200 000 лева<br/><br/><b>При
събития настъпили на територията на държава членка на Европейския
съюз</b><br/>Минималните лимити на отговорност, приложими в съответната държава
членка, на територията на която е настъпило застрахователното събитие, съгласно
нейния закон или покритието съгласно закона на територията, където обичайно се
намира моторното превозно средство, когато това покритие е по-високо.
		 </p>
		</div>
</div>
