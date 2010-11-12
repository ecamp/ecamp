<br />

<!-- daily_jobs_gp -->

<br />

<table width="100%" style="background-color:white; font-size:9px; border:1px black solid;">
<colgroup width="30px">
<colgroup width="48px">
<colgroup width="60px">
<colgroup width="*">
<colgroup width="120px">
<colgroup width="40px">
<tr valign="top">
    <td></td>
	<td>Start</td>
    <td>Dauer</td>
    <td>Bezeichnung</td>
    <td>Wer?</td>
    <td>Fortschritt</td>
</tr>
<tr><td colspan="6" style="border-bottom:1px black solid;"><img border="0" src="img/spacer.gif" height="6px" /></td></tr>
<tr><td colspan="6"><img border="0" src="img/spacer.gif" height="6px" /></td></tr>
<!-- events -->
<tr><td colspan="6"> <input type="button" value="+" onclick="javascript:lock_screen(); Element.removeClassName('menu_add_event','hidden');" onmouseover="Tip('<b>Neuen Programmblock hinzuf&uuml;gen</b><br><br>...',WIDTH,250);"/></td></tr>
<tr><td colspan="6"><img border="0" src="img/spacer.gif" height="10px" /></td></tr>
</table>


<br />
<b>Roter Faden (Tagesablauf):</b><br>
<div class="hidden" id="busy_story" name="busy_story"><img border="0" src="img/busy_32.gif" /></div>

<form id="show_story"><br />
<div style="border: dotted 1px; cursor:pointer;"  onClick="javascript:ask('story')">
 <table width="100%" cellspacing="0" cellpadding="0"><tr>
   <td width="1"><img src="img/spacer.gif" width="1px" height="50px" border="0" /></td>
   <td id="show_story_value" style="font-size:11px; text-align:left; font-family:Verdana, Arial, Helvetica, sans-serif; vertical-align:top;"><!-- value_story_html --></td>
 </tr></table>
 </div>
</form>

<form id="ask_story" name="ask_story" class="hidden" onsubmit="this.ok.click(); return false;">
    <img src="img/spacer.gif" height="12px" border="0">
  <textarea name="value" rows="4" class="input" style="width:100%;" onKeyPress="return catch_key('story', event);"><!-- value_story --></textarea>
    <br><br>
  <input type="button" class="askeditbutton" value="Speichern" id="ok" onClick="javascript:save_field('story');" style="width:18%;">
  <input type="button" class="askeditbutton" value="Abbrechen" onClick="javascript:cancel('story');" style="width:20%;">    
    
  <input name="field" type="hidden" value="story">
  <input name="app" value="day" type="hidden" />
    <input name="cmd" value="action_save_day"  type="hidden"/>
  <input name="day_id" value="<!-- day_id -->" type="hidden"/>
</form>


<br>

<b>Notizen:</b><br>
<div class="hidden" id="busy_notes" name="busy_notes"><img border="0" src="img/busy_32.gif" /></div>

<form id="show_notes"><br />
<div style="border: dotted 1px; cursor:pointer;"  onClick="javascript:ask('notes')">
 <table width="100%" cellspacing="0" cellpadding="0"><tr>
   <td width="1"><img src="img/spacer.gif" width="1px" height="50px" border="0" /></td>
   <td id="show_notes_value" style="font-size:11px; text-align:left; font-family:Verdana, Arial, Helvetica, sans-serif; vertical-align:top;"><!-- value_notes_html --></td>
 </tr></table>
 </div>
</form>

<form id="ask_notes" name="ask_notes" class="hidden" onsubmit="this.ok.click(); return false;">
    <img src="img/spacer.gif" height="12px" border="0">
  <textarea name="value" rows="4" class="input" style="width:100%;" onKeyPress="return catch_key('notes', event);"><!-- value_notes --></textarea>
    <br><br>
  <input type="button" class="askeditbutton" value="Speichern" id="ok" onClick="javascript:save_field('notes');" style="width:18%;">
  <input type="button" class="askeditbutton" value="Abbrechen" onClick="javascript:cancel('notes');" style="width:20%;">    
    
  <input name="field" type="hidden" value="notes">
  <input name="app" value="day" type="hidden" />
  <input name="cmd" value="action_save_day"  type="hidden"/>
  <input name="day_id" value="<!-- day_id -->" type="hidden"/>
</form>

<br>
<div width="100%" height=5px" style="border:none; border-top:1px black solid;"></div>

<div align="left" style="margin-top:10px;"><b>Tagesjobs:</b></div>
<br>
<!-- daily_jobs -->

