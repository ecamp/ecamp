<span metal:define-macro="main" tal:omit-tag="">

	<span tal:condition="no_notes">
    <i>[Keine neuen Kommentare]</i>
    </span>

	<span tal:repeat="note notes" >
        <img width="40px" style="float:left; margin:5px;" src="http://localhost/ecamp/www/index.php?app=user_profile&cmd=show_avatar&user_id=${user/id}" />
        <b>Betrifft</b>: ${note/camp} / <a href="#" onclick="$event.edit(${note/event_id});">${note/event} (Programm öffnen)</a><br />
        <i>${note/creater} schreibt am ${note/t_created}:</i><br /><br />
        
        ${note/text} 
        <br /><a href="#" onclick="$postit.loadComment(${note/comment_id});">[Mehr]</a><br />
        <!-- ${note/event_id}
        ${note/comment_user_id} -->
        
        <br /><br />
        <a href="#">[ausblenden]</a>
        <span tal:condition="not: repeat/note/end">
          <hr />
        </span>
    </span>

</span>