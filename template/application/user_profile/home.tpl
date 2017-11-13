<div metal:define-macro="home">
    <img style="vertical-align:middle" tal:attributes="src structure profile/img_src" />
    <b tal:content="user/mail"></b>
    <a href="index.php?app=user_profile&cmd=delprofile">
        <b>Profil löschen</b>
    </a>

    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_scoutname" class="col-sm-2 control-label">Pfadiname:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_scoutname" placeholder="Pfadiname" name="value" tal:attributes="value profile/scoutname/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_firstname" class="col-sm-2 control-label">Vorname:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_firstname" placeholder="Vorname" name="value" tal:attributes="value profile/firstname/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_surname" class="col-sm-2 control-label">Nachname:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_surname" placeholder="Nachname" name="value" tal:attributes="value profile/surname/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_birthday" class="col-sm-2 control-label">Geburtstag:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_birthday" placeholder="Geburtstag" name="value" tal:attributes="value profile/birthday/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_sex" class="col-sm-2 control-label">Geschlecht:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" id="user_profile_sex" tal:attributes="initvalue profile/sex/selected" >
                    <tal:block repeat="item profile/sex/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
                </select>
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_street" class="col-sm-2 control-label">Strasse:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_street" placeholder="Strasse" name="value" tal:attributes="value profile/street/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_zipcode" class="col-sm-2 control-label">PLZ:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_zipcode" placeholder="PLZ" name="value" tal:attributes="value profile/zipcode/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_city" class="col-sm-2 control-label">Ort:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_city" placeholder="Ort" name="value" tal:attributes="value profile/city/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_homenr" class="col-sm-2 control-label">Home Nr:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_homenr" placeholder="Home Nr" name="value" tal:attributes="value profile/homenr/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_mobilnr" class="col-sm-2 control-label">Mobil Nr:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_mobilnr" placeholder="Mobil Nr" name="value" tal:attributes="value profile/mobilnr/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_ahv" class="col-sm-2 control-label">AHV Nr:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_ahv" placeholder="AHV Nr" name="value" tal:attributes="value profile/ahv/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_jspersnr" class="col-sm-2 control-label">J&S Personal Nr:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_profile_jspersnr" placeholder="J&S Personal Nr" name="value" tal:attributes="value profile/jspersnr/value" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_pbsedu" class="col-sm-2 control-label">PBS Ausbildung:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="value" id="user_profile_pbsedu" tal:attributes="initvalue profile/pbsedu/selected" >
                    <tal:block repeat="item profile/pbsedu/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
                </select>
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_jsedu" class="col-sm-2 control-label">J&S Ausbildung:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="value" id="user_profile_jsedu" tal:attributes="initvalue profile/jsedu/selected" >
                    <tal:block repeat="item profile/jsedu/value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value" />
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value" />
                    </tal:block>
                </select>
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_homenr" class="col-sm-2 control-label">Portrait ändern:</label>
            <div class="col-sm-10">
                <input class="btn btn-danger" type="button" value="Ändern" id="profile_avatar" />
                <input class="btn btn-danger" type="button" value="Löschen" id="profile_del_avatar" />
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="user_profile_mobilnr" class="col-sm-2 control-label">Passwort ändern:</label>
            <div class="col-sm-10">
                <input class="btn btn-info" type="button" value="Ändern" id="profile_pw" />
            </div>
        </div>
    </div>
</div>