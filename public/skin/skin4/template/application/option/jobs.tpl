<span metal:define-macro="jobs" tal:omit-tag="" >
	<div style="font-style:italic">
		Tagesjobs sind Aufgaben, welche an jedem Tag von jemandem erledigt werden müssen.
		Welche alle Jobs in einem Lager existieren, wird hier festgelegt.
	</div>
	<br />
    <form id="job_form" name="job_form">
        <select name="jobs" size="10" style="width:100%;" class="input" id="job_list">
          <optgroup id="group_gp" label="Job im Picasso (1x)">
              <tal:block repeat="job option/job_list/master">
              	<option tal:attributes="value job/id"><tal:block content="job/name" /></option>
              </tal:block>
          </optgroup>
          <optgroup id="group_normal" label="Andere Jobs">
              <tal:block repeat="job option/job_list/slave">
              	<option tal:attributes="value job/id"><tal:block content="job/name" /></option>
              </tal:block>
          </optgroup>
        </select>
        <br />
        <br />
        <div class="new_job_form" >
            <input type="text" name="job_name" size="60" style="width:75%;" class="input job_name" />
            <input type="button" class="job_ok" value="+" style="width:20%" />
            <img src="public/global/img/wait.gif" class="hidden busy_new" />
		</div>
        <br />
        <center>
	        <input type="button" value="L&ouml;schen" class="job_delete" style="width: 30%" />
	        <input type="button" value="&Auml;ndern" class="job_change" style="width: 30%" />
	        <input type="button" value="Picasso" class="job_picasso" style="width: 30%" />
        </center>
        <input name="app" value="option" type="hidden" />
    </form>
</span>