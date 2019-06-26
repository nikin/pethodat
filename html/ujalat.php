<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');
?>
<script language='JavaScript' type='text/javascript'>
			function CheckField() {
				if(document.DogRegister.dog_name.value == ''){alert('A kutya neve hiányzik!');return false;}
				if(document.DogRegister.breed.value == ''){alert('Hiányzó adat: FAJTA!');return false;}
				if(document.DogRegister.colour.value == ''){alert('Add meg a kutya színét!');return false;}
				if(document.DogRegister.bdate.value == ''){alert('Születési dátum???');return false;}
				if(document.DogRegister.marm.value == ''){alert('Marmagasság?');return false;}
				if(document.DogRegister.bef_date.value == ''){alert('Befogás ideje?');return false;}
				if(document.DogRegister.bef_place.value == ''){alert('Befogás helye?');return false;}
				if(document.DogRegister.bef_cond.value == ''){alert('Befogás körülményei?');return false;}
			}
		</script>
<div>&nbsp;</div>
<div>
<?php
if (isset($_SESSION['MSG'])){DropMsg();}
?>
<form name='DogRegister' id="DogRegister" method="post" action="" onsubmit='return CheckField()'>
	<table width="900" border="0" cellspacing="0" cellpadding="0" class="border">
    	<tr height="20">
    		<td class="right pl"></td>
		    <td colspan="3">&nbsp;</td>
        </tr>
  		<tr height="20">
    		<td class="right pl"><b>Státusz:</b></td>
    		<td colspan="3"><select class="textfield" name="status" id="status">
            		<option value="ST0"><?php print DataName(ST0);?></option>
            		<option value="ST1"><?php print DataName(ST1);?></option>
            		<option value="ST2"><?php print DataName(ST2);?></option>
            		<option value="ST3"><?php print DataName(ST3);?></option>
            		<option value="ST4"><?php print DataName(ST4);?></option>
            		<option value="ST5"><?php print DataName(ST5);?></option>
        		</select>
   			</td>
  		</tr>
  		<tr height="20">
    		<td class="right pl"><b>Kutya neve:</b></td>
    		<td colspan="3"><input type="text" name="dog_name" size="35" maxlength="30"/></td>
  		</tr>
  		<tr height="20">
    		<td width="180" class="right pl"><b>Nem:</b></td>
    		<td width="250"><select class="textfield" name="sex" id="sex">
           			<option value="SE0"><?php print DataName(SE0);?></option>
            		<option value="SE1"><?php print DataName(SE1);?></option>
            	</select>
			</td>
    		<td width="120" class="right pl"><b>Fajta:</b></td>
    		<td width="350"><input type="text" name="breed" size="35" maxlength="90"/></td>
    	</tr>
    	<tr height="20">
    		<td class="right pl"><b>Szőrzet:</b></td>
    		<td><select class="textfield" name="hair" id="hair">
           			<option value="H0"><?php print DataName(H0);?></option>
            		<option value="H1"><?php print DataName(H1);?></option>
            		<option value="H2"><?php print DataName(H2);?></option>
            	</select>
     		</td>
    		<td class="right pl"><b>Szinezet:</b></td>
    		<td colspan="3"><input type="text" name="colour" size="35" maxlength="30"/></td>
  		</tr>
  		<tr height="20">
    		<td class="right pl"><b>Születési idő:</b></td>
    		<td width="200"><input name="bdate" type="text" id="bdate" size="10" maxlength="10" /></td>
    		<td width="150" class="right pl"><b>Becsült:</b></td>
    		<td><input name="estimated" type="checkbox" value="1" /></td>
 		</tr>
  		<tr height="20">
    		<td class="right pl"><b>Marmagasság:</b></td>
    		<td width="200"><input name="marm" type="text" size="3" maxlength="3"/> cm</td>
    		<td class="right pl"><b>Chip:</b></td>
    		<td><input type="text" name="chip" size="45" maxlength="40"/></td>
  		</tr>
  		<tr>
  			<td class="right pl"><b>Oltási könyv sz.:</b></td>
			<td class="pl textf" colspan="3"><input type="text" name="book_nbr" size="25" maxlength="20"/></td>
        </tr>
  		<tr height="20">
    		<td class="right pl"><b>Befogás dátuma:</b></td>
    		<td><input type="text" name="bef_date" id="bef_date" size="10" maxlength="10" /></td>
    		<td class="right pl"><b>Befogás helye:</b></td>
    		<td><input type="text" name="bef_place" size="35" maxlength="30"/></td>
  		</tr>
  		<tr height="20">
    		<td class="right pl"><b>Befogás körülményei:</b></td>
    		<td colspan="3"><textarea name="bef_cond" cols="80" rows="3" wrap="off"></textarea></td>
  		</tr>
  		<tr height="20">
    		<td class="right pl"><b>Kutya jellemzése:</b></td>
    		<td colspan="3"><textarea name="char" cols="80" rows="3" wrap="off"></textarea></td>
  		</tr>
        <tr height="50">
    		<td class="right pl"></td>
    		<td colspan="3" class="right pl"><input class="bsave" name="Save" type="submit" value="" title="Mentés" /></td>
  		</tr>
	</table>
</form>
</div>

<?php
	if (isset($_POST['Save'])) {
		
		//Sanitize the POST values
		$status = clean($_POST['status']);
		$dog_name = clean($_POST['dog_name']);
		$sex = clean($_POST['sex']);
		$breed = clean($_POST['breed']);
		$hair = clean($_POST['hair']);
		$colour = clean($_POST['colour']);
		$bdate = clean($_POST['bdate']);
		$marm = clean($_POST['marm']);
		$chip = clean($_POST['chip']);
		$book_nbr = clean($_POST['boor_nbr']);
		$bef_date = clean($_POST['bef_date']);
		$bef_place = clean($_POST['bef_place']);
		$bef_cond = clean($_POST['bef_cond']);
		$char = clean($_POST['char']);
		if ($_POST['estimated'] == '1') {
			$estimated = true;}
		else {$estimated = false;}
		
		$dog_check = mysql_query("SELECT * FROM dogs WHERE DOG_NAME = '".$dog_name."'");
		if($dog_check) {
			//Adatok mentésa az adatbázisba
				$qry = "INSERT INTO dogs SET
						DOG_NAME = '" .  $dog_name . "',
						STATUS = '" .  $status . "',
						SEX = '" .  $sex . "',
						BREED = '" .  $breed . "',
						COLOUR = '" .  $colour . "',
						HAIR = '" .  $hair . "',
						B_DATE = '" .  $bdate . "',
						CHIP = '" .  $chip . "',
						BOOK_NBR = '" .  $book_nbr . "',
						MARM = '" .  $marm . "',
						BEF_DATE = '" .  $bef_date . "',
						BEF_PLACE = '" .  $bef_place . "',
						BEF_COND = '" .  $bef_cond . "',
						CHARACT = '" .  $char . "',
						WEB = 'AUTO',
						ESTIMATED = '" .  $estimated . "'";
				$result = @mysql_query($qry);
				
				$DNqry="SELECT * FROM dogs WHERE DOG_NAME='".$dog_name."'";
				$DNresult=mysql_query($DNqry);
				$dog = mysql_fetch_assoc($DNresult);
				
				$LOGqry = "INSERT INTO log SET
							USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
							DOG_ID = '" . $dog['DOG_ID'] . "',
							ACTION = 'A0',
							COMMENT = 'Státusz: ".DataName($status)."'";
				$LOGresult=mysql_query($LOGqry);	
				print"
					<script>
						alert('Sikeresen rögzítetted a(z) ".$dog_name." nevű kutyát!');
					</script>";	
		}
	}
?>