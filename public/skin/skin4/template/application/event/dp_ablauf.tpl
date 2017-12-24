<span metal:define-macro="dp_ablauf" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Ablauf:</span>
        
        
        <span metal:fill-slot="border_content" tal:omit-tag="">
            <div class="d_program_table" >
                <div class="d_program_row">
                    <div class="d_program_cell_time"><b>Wann</b></div>
                    <div class="d_program_cell_content"><b>Was</b></div>
                    <div class="d_program_cell_resp"><b>Wer</b></div>
                    <div class="d_program_cell_option"><b>Option</b></div>
                </div>
            </div>
            <ul id="d_program_sort" type="none" class="d_program_sort">
                <tal:block repeat="detail details">
                    <li tal:attributes="id detail/id" class="dp_event_detail">
                        <div class="d_program_table ">
                            <div class="d_program_row">
                                <div class="d_program_cell_time" >
                                	<input type="text" name="time" style="width:100%" tal:attributes="value detail/time" />
                                </div>
                                
                                <div class="d_program_cell_content">
                                	<textarea name="content" style="width:100%" tal:content="detail/content" ></textarea>
                                </div>
                                
                                <div class="d_program_cell_resp">
                                	<textarea name="resp" style="width:100%" tal:content="detail/resp" ></textarea>
                                </div>
                                
                                <div class="d_program_cell_option">
                                    <!--
	                                <a href="#" class="handle"><img src="public/global/img/move.gif" border="0" alt="Bewegen" /></a>
	                                -->
	                                <a href="#" class="delete"><img src="public/global/img/del.png" border="0" alt="Löschen" /></a>
	                                <a href="#" class="up"><img src="public/global/img/up.png" border="0" /></a>
	                                <a href="#" class="down"><img src="public/global/img/down.png" border="0" /></a>
                                </div>
                            </div>
                            
                            <input type="hidden" class="detail_id" name="detail_id" tal:attributes="value detail/id" />
                        </div>
                    </li>
                </tal:block>
                
                
                <li class="dp_event_detail hidden" id="dp_event_detail_example">
                    <div class="d_program_table ">
                        <div class="d_program_row">
                            <div class="d_program_cell_time" >
                            	<input type="text" name="time" style="width:100%" />
                            </div>
                            
                            <div class="d_program_cell_content">
                            	<textarea name="content" style="width:100%"></textarea>
                            </div>
                            
                            <div class="d_program_cell_resp">
                            	<textarea name="resp" style="width:100%"></textarea>
                            </div>
                            
                            <div class="d_program_cell_option">
                                <!--
                                <a href="#" class="handle"><img src="public/global/img/move.gif" border="0" alt="Bewegen" /></a>
                                -->
                                <a href="#" class="delete" name="delete"><img src="public/global/img/del.png" border="0" alt="Löschen" /></a>
                                <a href="#" class="up" name="up"><img src="public/global/img/up.png" border="0" /></a>
                                <a href="#" class="down" name="down"><img src="public/global/img/down.png" border="0" /></a>
                            </div>
                        </div>
                        
                        <input type="hidden" class="detail_id" name="detail_id" />
                    </div>
                </li>
                
                
            </ul>
            
            <center>
	            <div style="text-align:right; width:90%; margin-top:10px; margin-bottom:10px">
	            	<input class="dp_add_detail" value="Programmpunkt hinzufügen" type="button" />
				</div>
			</center>
        </span>
    </span>
</span>