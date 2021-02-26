<span metal:define-macro="home" tal:omit-tag="">
    <div class="mail-test">
        <form class="form-horizontal" action="" method="get">
            <div class="form-group">
                <label for="mailtest" class="col-sm-2 control-label">Mail-Empfänger</label>
                <div class="col-md-10">
                    <input type="email" tabindex="1" class="form-control" id="mailtest" placeholder="Email" name="mailtest" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" tabindex="2" class="form-control btn btn-success" id="submit" name="submit" value="Sende Mail" />
                </div>
            </div>

            <input type="hidden" name="app" value="mail" />
        </form>
    </div>
</span>