<span metal:define-macro="home" tal:omit-tag="" >
    <table width="100%">
        <tr>
            <td rowspan="10" width="18%" align="center"><img style="vertical-align:middle" tal:attributes="src structure profile/img_src" /></td>
            <td rowspan="10" width="2%"> </td>
            <td colspan="3" align=""><b tal:content="user/mail"></b></td>
            <td colspan="3" align="right">
            	
            	<a href="index.php?app=user_profile&cmd=delprofile">
	            	<b>Profil löschen</b>
	            </a>
	            
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr height="25">
            <td width="12.5%" valign="top">Pfadiname:</td>
            <td width="25%" valign="top">
            	<input tabindex="1" type="text" name="value" id="user_profile_scoutname" style="width: 100%" tal:attributes="value profile/scoutname/value" />
            </td>
            
            <td width="5%">&nbsp;</td>
            
            <td width="12.5%" valign="top">Geburtstag:</td>
            <td width="25%" valign="top">
            	<input tabindex="9" type="text" name="value" id="user_profile_birthday" style="width: 100%" tal:attributes="value profile/birthday/value" />
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Vorname:</td>
            <td valign="top">
            	<input tabindex="2" type="text" name="value" id="user_profile_firstname" style="width: 100%" tal:attributes="value profile/firstname/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">AHV Nr:</td>
            <td valign="top">
            	<input tabindex="10" type="text" name="value" id="user_profile_ahv" style="width: 100%" tal:attributes="value profile/ahv/value" />
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Nachname:</td>
            <td valign="top">
            	<input tabindex="3" type="text" name="value" id="user_profile_surname" style="width: 100%" tal:attributes="value profile/surname/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">J&amp;S Personal Nr:</td>
            <td valign="top">
            	<input tabindex="11" type="text" name="value" id="user_profile_jspersnr" style="width: 100%" tal:attributes="value profile/jspersnr/value" />
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Strasse:</td>
            <td valign="top">
            	<input tabindex="4" type="text" name="value" id="user_profile_street" style="width: 100%" tal:attributes="value profile/street/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">Geschlecht:</td>
            <td valign="top">
            	<select tabindex="12" name="value" id="user_profile_sex" style="width: 100%" tal:attributes="initvalue profile/sex/selected" >
            		<tal:block repeat="item profile/sex/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
            	</select>
            	
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">PLZ:</td>
            <td valign="top">
            	<input tabindex="5" type="text" name="value" id="user_profile_zipcode" style="width: 100%" tal:attributes="value profile/zipcode/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">PBS Ausbildung:</td>
            <td valign="top">
            	<select tabindex="13" name="value" id="user_profile_pbsedu" style="width: 100%" tal:attributes="initvalue profile/pbsedu/selected" >
            		<tal:block repeat="item profile/pbsedu/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
            	</select>
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Ort:</td>
            <td valign="top">
            	<input tabindex="6" type="text" name="value" id="user_profile_city" style="width: 100%" tal:attributes="value profile/city/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">J&amp;S Ausbildung:</td>
            <td valign="top">
            	<select tabindex="14" name="value" id="user_profile_jsedu" style="width: 100%" tal:attributes="initvalue profile/jsedu/selected" >
            		<tal:block repeat="item profile/jsedu/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
            	</select>
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Home Nr:</td>
            <td valign="top">
            	<input tabindex="7" type="text" name="value" id="user_profile_homenr" style="width: 100%" tal:attributes="value profile/homenr/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top">Portrait ändern:</td>
            <td valign="top">
            	<input tabindex="15" type="button" value="&Auml;ndern" id="profile_avatar" />
                <input tabindex="16" type="button" value="L&ouml;schen" id="profile_del_avatar" />
            </td>
        </tr>
        
        <tr height="25">
            <td valign="top">Mobil Nr:</td>
            <td valign="top">
            	<input tabindex="8" type="text" name="value" id="user_profile_mobilnr" style="width: 100%" tal:attributes="value profile/mobilnr/value" />
            </td>
            
            <td>&nbsp;</td>
            
            <td valign="top" rowspan="3">Passwort &auml;ndern:</td>
            <td valign="top">
            	<input tabindex="17" type="button" value="&Auml;ndern" id="profile_pw" />
            </td>
        </tr>
    </table>
</span>