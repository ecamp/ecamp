<span metal:define-macro="context_menu" tal:omit-tag="">

    <ul id="event_c_menu" class="pmenu contextmenu" >
        <li><a href="#" onClick="$event.edit( $('event_id').value )"><img border="0" src="public/application/program/img/dp.png" /> Block editieren	</a></li>
        <li><a href="#" onclick='' class="parent"><img border="0" src="public/application/program/img/edit.png" /> Bearbeiten</a>
            <ul class="pmenu">
              <li><a href="#" onClick="$program.event.get( $('event_id').value ).save_change_name()"><img border="0" src="public/application/program/img/rename.png" /> Name &auml;ndern</a></li>
              <li><a href="#" onClick="$program.event.get( $('event_id').value ).save_change_responsible_user()"><img border="0" src="public/application/program/img/resp.png" /> Verant. &auml;ndern</a></li>
              <li><a href="#" onClick="$program.event.get( $('event_id').value ).save_change_category()"><img border="0" src="public/application/program/img/type.png" /> Typ &auml;ndern</a></li>
            </ul>
        </li>
        <li><a href="#" onclick='' class="parent"><img border="0" src="public/application/program/img/option.png" /> Optionen</a>
            <ul class="pmenu">
              <li><a href="#" onClick="$program.event_instance.get( $('event_instance_id').value ).save_copy_event_instance()"><img border="0" src="public/application/program/img/split.png" /> Block spliten</a></li>
              <li><a href="#" onClick="$program.event_instance.get( $('event_instance_id').value ).save_copy_event()"><img border="0" src="public/application/program/img/copy.png" /> Block kopieren</a></li>
              <li><a href="#" onClick="$program.event_instance.get( $('event_instance_id').value ).save_remove()"><img border="0" src="public/application/program/img/del.png" /> Block l&ouml;schen</a></li>
            </ul>
        </li>
        <li><a href="#" onClick="print_event( document.event_c_menu.event_id.value )"><img border="0" src="public/application/program/img/print.png" /> Drucken</a></li>
    </ul>
    
    <ul id="index_c_menu" class="pmenu contextmenu" >
        <li><a href="#" onClick="$program.day.get( $('day_id').value ).save_add_event()" ><img border="0" src="public/application/program/img/new.png" /> Neuer Block</a></li>
        <li><a href="#" onClick="$program.day.get( $('day_id').value ).save_add_event()" ><img border="0" src="public/application/program/img/copy.png" /> Neuer Block</a></li>
        <li><a href="#" onclick='' class="parent"><img border="0" src="public/application/program/img/option.png" /> Darstellung</a>
            <ul class="pmenu">
              <li><a href="#" onClick="$program.show_cat()">Blocktype anzeigen</a></li>
              <li><a href="#" onClick="$program.show_progress()">Fortschritt anzeigen</a></li>
            </ul>
        </li>
    </ul>
    
    
    <form style="visibility:hidden" name="event_c_menu">
        <input type="hidden" id="event_instance_id" />
        <input type="hidden" id="event_id" />
    </form>
    <form style="visibility:hidden" name="index_c_menu">
        <input type="hidden" id="day_id" />
    </form>
</span>