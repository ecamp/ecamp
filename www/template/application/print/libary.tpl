<span metal:define-macro="libary" tal:omit-tag="">
	<center>
		<p class="libary">
			Durch klicken hinzufügen.
		</p>
		
		<ul id="libary">
			<li class="libary title">
				<h1>Titelblatt</h1>
			</li>
			
			<li class="libary picasso">
				<h1>Picasso</h1>
				<p>
					<select>
						<option value="P">Hochformat</option>
						<option value="L">Querformat</option>
					</select>
				</p>
				
			</li>
			
			<li class="libary allevents">
				<h1>Alle Blöcke</h1>
				<p>
					<input type="checkbox" checked="checked" />Tagesübersicht drucken
				</p>
			</li>
			
			<li class="libary event">
				<h1>Einzelner Block</h1>
				<p>
					<select>
						<tal:block repeat="day events">
							<optgroup tal:attributes="label day/day_str">
								<option tal:repeat="event day/events" tal:attributes="value event/event_instance_id">
									<tal:block content="event/day_offset"/>.<tal:block content="event/event_nr" />)
									<tal:block content="event/short_name" />: <tal:block content="event/name" />
								</option>
							</optgroup>
						</tal:block>
					</select>
					<br />
					<br />
					<input type="checkbox" name="dayoverview" />vorhergehend zugehörige Tagesübersicht drucken
				</p>
			</li>
			
			<li class="libary toc">
				<h1>Inhaltsverzeichnis</h1>
			</li>

			<li class="libary notes">
				<h1>Notizen</h1>
				<p>
					Anzahl Seiten Notizpapier:
					<input type="number" name="notes" value="1" min="1" />
				</p>
			</li>
			
			<li class="libary pdf" tal:condition="true">
				<h1>PDF</h1>
				<p>
					<input type="file" />
				</p>
			</li>
		</ul>
	</center>
</span>