<input type="hidden" name="playedGroup" value="<?=$this->groupId?>" />
<input type="hidden" name="playedId" value="<?=$this->played?>" />
<input type="hidden" name="type" value="<?=$this->type?>" />
<div class="pp" action="tzCombineSelect2" length="3" random="combineRandom">
	<div class="selposition" id="wei-shu" length="3">
		<label for="position_0"><input id="position_0" class="selpositioninput" name="position_0" type="checkbox" value="16"/>万</label>
		<label for="position_1"><input id="position_1" class="selpositioninput" name="position_1" type="checkbox" value="8" />千</label>
		<label for="position_2"><input id="position_2" class="selpositioninput" name="position_2" type="checkbox" value="4" />百</label>
		<label for="position_3"><input id="position_3" class="selpositioninput" name="position_3" type="checkbox" value="2" />十</label>
		<label for="position_4"><input id="position_4" class="selpositioninput" name="position_4" type="checkbox" value="1" />个</label>
		<span>&nbsp&nbsp&nbsp&nbsp<b>温馨提示：你选择了<span id="positioncount">0</span>个位置，系统自动根据位置组合成<span id="positioninfo">0</span>个方案。</b></span>
	</div>
	<input type="button" value="0" class="code min s" />
	<input type="button" value="1" class="code min d" />
	<input type="button" value="2" class="code min s" />
	<input type="button" value="3" class="code min d" />
	<input type="button" value="4" class="code min s" />
	<input type="button" value="5" class="code max d" />
	<input type="button" value="6" class="code max s" />
	<input type="button" value="7" class="code max d" />
	<input type="button" value="8" class="code max s" />
	<input type="button" value="9" class="code max d" />
	&nbsp;
	<input type="button" value="清" class="action none" />
    <input type="button" value="双" class="action even" />
    <input type="button" value="单" class="action odd" />
    <input type="button" value="小" class="action small" />
    <input type="button" value="大" class="action large" />
    <input type="button" value="全" class="action all" />
</div>
<?php $maxPl=$this->getPl($this->type, $this->played); ?>
<script type="text/javascript">
$(".selpositioninput").click(function () {
                $.lt_position_sel = [];
                $.each($(".selpositioninput"), function () {
                    positionvalue = $(this).attr("name");
                    positionvalue = positionvalue.split("_");
                    if ($(this).attr("checked")) {
                        $.lt_position_sel.push(positionvalue[1]);
                    }
                });
                $("#positioncount").html($.lt_position_sel.length);
                var projectCount = $.lt_position_sel.length == 0 ? 0 : Combination($.lt_position_sel.length, 3);
                $("#positioninfo").html( projectCount );
				tzCombineSelect2();
            });
</script>
<script type="text/javascript">
$(function(){
	gameSetPl(<?=json_encode($maxPl)?>);
})
</script>