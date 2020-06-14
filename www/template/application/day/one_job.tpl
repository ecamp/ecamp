<table>
    <tr>
        <td><!-- job_name -->: </td>
        <td width="100%">
            <div class="hidden" id="busy_<!-- job_id -->" name="busy_<!-- job_id -->"><img border="0" src="img/busy_32.gif" /></div>

            <form id="show_<!-- job_id -->" name="show_<!-- job_id -->">
                <input name="value" type="text" readonly="readonly" onClick="javascript:ask('<!-- job_id -->')" class="showtext" value="<!-- value -->">
            </form>

            <form id="ask_<!-- job_id -->" name="ask_<!-- job_id -->" class="hidden" onsubmit="this.ok.click(); return false;">

                <input name="value" type="text" class="askedit " value="<!-- value -->" style="width:60%;" onKeyPress="return catch_key('<!-- job_id -->', event);">

                <input type="button" class="askeditbutton " value="Speichern" id="ok" onClick="javascript:save_job('<!-- job_id -->');" style="width:18%;">

                <input type="button" class="askeditbutton " value="Abbrechen" onClick="javascript:cancel('<!-- job_id -->');" style="width:20%;">



                <input name="job_id" type="hidden" value="<!-- job_id -->">

                <input name="day_id" type="hidden" value="<!-- day_id -->">

                <input name="app" value="day" type="hidden" />

                <input name="cmd" value="action_save_job_value"  type="hidden"/>

            </form>
        </td>
    </tr>
</table>
