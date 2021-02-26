<span metal:define-macro="show_user" tal:omit-tag="" >
	
	<center>
		<table>
			<tr>
				<td colspan="3" align="right">
					<a href="index.php?app=leader&cmd=home">
						Zurück zur Leiterliste
					</a>
				</td>
			</tr>
			
			<!--
			<tr>
				<td colspan="3" align="right">
					Zeige Details von 
					<select>
					</select>
				</td>
			</tr>
			-->
			
			<tr><td>&nbsp;</td></tr>
			
			<tr>
				<td colspan="3">
					<h1>
						<tal:block content="user_detail/firstname" />
						<tal:block content="user_detail/surname" /> / 
						<tal:block content="user_detail/scoutname" />:
					</h1>
				</td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			
			<tr>
				<td>
					<img tal:attributes="src user_detail/avatar" class="profile_image" />
				</td>
				<td>
					<h1 class="detail_title">Zur Person:</h1>
					
					<table class="detail_table">
						<tr>
							<td>
								<tal:block content="user_detail/firstname" />
								<tal:block content="user_detail/surname" /> / 
								<tal:block content="user_detail/scoutname" /> 
								<tal:block content="structure user_detail/sex_symbol" /> 
							</td>
						</tr>
						<tr>
							<td><tal:block content="user_detail/street" /> </td>
						</tr>
						<tr>
							<td>
								<tal:block content="user_detail/zipcode" />
								<tal:block content="user_detail/city" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<tal:block content="user_detail/birthday_str" /> 
							</td>
						</tr>
						<tr>
							<td><tal:block content="user_detail/ahv" /> </td>
						</tr>
					</table>
					
				</td>
				<td>	
					
					<h1 class="detail_title">Kontakt:</h1>
					
					<table class="detail_table">
						<tr>
							<td><tal:block content="user_detail/mail" /></td>
						</tr>
						<tr>
							<td><tal:block content="user_detail/homenr" /></td>
						</tr>
						<tr>
							<td><tal:block content="user_detail/mobilnr" /></td>
						</tr>
					</table>
					
					
					<h1 class="detail_title">Ausbildung:</h1>
					
					<table class="detail_table">
						<tr>
							<td>J+S Nummer:</td>
							<td><tal:block content="user_detail/jspersnr" /></td>
						</tr>
						
						<tr>
							<td>PBS Ausbildung:</td>
							<td><tal:block content="user_detail/pbsedu_str" /></td>
						</tr>
						
						<tr>
							<td>J+S Ausbildung:</td>
							<td><tal:block content="user_detail/jsedu_str" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
	
		
	
	
</span>